<?php

namespace App\Http\Controllers;

use App\Services\WhmcsService;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
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
        // dd('login attempt');
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

        // dd($resp->status(), $resp->body());

        $data = $resp->json();

        // dd($data);

        if (!$resp->ok() || !($data['ok'] ?? false)) {
            return back()->with('error', $data['message'] ?? 'Invalid admin credentials');
        }
        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('admin.dashboard');
    }
    public function index()
    {
        return view('welcome');
    }
}
