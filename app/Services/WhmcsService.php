<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WhmcsService
{
    protected string $baseUrl;
    protected string $identifier;
    protected string $secret;

    public function __construct()
    {
        $this->baseUrl    = rtrim(config('whmcs.url'), '/');
        $this->identifier = (string) config('whmcs.identifier');
        $this->secret     = (string) config('whmcs.secret');
    }

    public function call(string $action, array $params = []): array
    {
        // dd('here');
        if (!$this->baseUrl || !$this->identifier || !$this->secret) {
            return [
                'result'  => 'error',
                'message' => 'WHMCS config missing: url/identifier/secret'
            ];
        }

        $payload = array_merge([
            'identifier'   => $this->identifier,
            'secret'       => $this->secret,
            'action'       => $action,
            'responsetype' => 'json',
        ], $params);

        // dd($payload);
        try {
            $response = Http::asForm()
                ->timeout(30)
                ->retry(2, 200) // small retry
                ->post($this->baseUrl . '/includes/api.php', $payload);
                // dd($this->baseUrl);

            $json = $response->json();
            // dd($json);

            // fallback if response is not json
            if (!is_array($json)) {
                return [
                    'result'  => 'error',
                    'message' => 'Non-JSON response from WHMCS',
                    'raw'     => (string) $response->body(),
                ];
            }

            return $json;

        } catch (\Throwable $e) {
            return [
                'result'  => 'error',
                'message' => 'HTTP error: ' . $e->getMessage(),
            ];
        }
    }
}
