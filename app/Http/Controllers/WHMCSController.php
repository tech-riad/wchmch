<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WhmcsService;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class WHMCSController extends Controller
{
    public function test(WhmcsService $whmcs)
    {
        // dd(config('whmcs'));
        $resp = $whmcs->call('GetProducts');
        return response()->json($resp);
    }
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $resp = Http::withHeaders([
                'X-Shared-Secret' => env('WHMCS_LARAVEL_SHARED_SECRET'),
                'Accept' => 'application/json',
            ])
            ->asJson()
            ->timeout(15)
            ->post(env('WHMCS_INTERNAL_AUTH_URL'), [
                'username' => $request->login,
                'password' => $request->password,
            ]);

        $data = $resp->json();

        if (!$resp->ok() || !($data['ok'] ?? false)) {
            return redirect()->back()->with('error', $data['message'] ?? 'Invalid')->withInput();
        }

        $email = $data['email'] ?? ($data['username'] . '@whmcs-admin.local');

        $user = \App\Models\User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $data['name'] ?: $data['username'],
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(40)),
                'is_admin' => 1,
                'whmcs_admin_id' => $data['admin_id'] ?? null,
            ]
        );

        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }
    public function index()
    {
        // dd('here');
        return view('welcome');
    }
}
