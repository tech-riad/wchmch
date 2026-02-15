<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\WhmcsService;
use Illuminate\Http\Request; // use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(WhmcsService $whmcs)
    {
        $resp = $whmcs->call('GetClients', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        if (($resp['result'] ?? '') !== 'success') {
            // dd($resp);
        }

        $clients = $resp['clients']['client'] ?? [];

        // single client normalize
        if (!empty($clients) && isset($clients['id'])) {
            $clients = [$clients];
        }

        $totalClients = count($clients);
        // dd("Total clients: $totalClients");
        $inactiveCount = 0;
        $activeCount = 0;
        $closedCount = 0;



        foreach ($clients as &$client) {

            $products = $whmcs->call('GetClientsProducts', [
                'clientid'   => $client['id'],
                'limitstart' => 0,
                'limitnum'   => 200,
            ]);

            $services = $products['products']['product'] ?? [];

            // single service normalize
            if (!empty($services) && isset($services['id'])) {
                $services = [$services];
            }

            $client['services'] = $services;

            if (strtolower($client['status']) === 'active') {
                $activeCount++;
            } elseif(strtolower($client['status']) === 'inactive') {
                 $inactiveCount++;
            } elseif(strtolower($client['status']) === 'closed') {
                $closedCount++;
            }
        }
        unset($client);

        // dd($clients, $totalClients, $activeCount, $inactiveCount);

        return view('backend.client.index', compact('clients', 'totalClients','inactiveCount','activeCount','closedCount'));
    }

    public function create(WhmcsService $whmcs)
    {
        $currencyApi = $whmcs->call('GetCurrencies', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // Fix: Use $currencyApi instead of $currency
        $currencies = $currencyApi['currencies']['currency'] ?? [];

        $groupApi = $whmcs->call('GetClientGroups', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // dd($groupApi);
        $groups = $groupApi['groups']['group'] ?? [];
        // Payment method API call
        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // dd($paymentMethodApi);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];

        // dd($paymethodMethods);

        return view('backend.client.create', compact('currencies', 'groups', 'paymethodMethods'));
    }
    public function store(WhmcsService $whmcs, Request $request)
    {
        // dd($request->all());
        // Validation আগে করাই best
        $request->validate([
            'firstname'   => 'required|string|max:255',
            'lastname'    => 'required|string|max:255',
            'email'       => 'required|email',
            'password'    => 'required|string|min:6|confirmed',
        ]);

        $postData = [
            'firstname'      => $request->firstname,
            'lastname'       => $request->lastname,
            'companyname'    => $request->companyname,
            'email'          => $request->email,

            // WHMCS field নাম অবশ্যই phonenumber
            'phonenumber'    => $request->phone,

            'password2'      => $request->password, // ✅ plain দিতে হবে

            'address1'       => $request->address1,
            'address2'       => $request->address2,
            'city'           => $request->city,
            'state'          => $request->state,
            'postcode'       => $request->postcode,
            'country'        => $request->country,

            'tax_id'         => $request->tax_id,
            'currency'       => $request->currency,
            'groupid'        => $request->group,     // ⚠️ WHMCS uses groupid না "group"
            'status'         => $request->status,
            'paymentmethod'  => $request->payment_method,
            'notes'          => $request->notes,

            'clientip'       => $request->ip(),
        ];


        // dd($postData);

        $resp = $whmcs->call('AddClient', $postData);

        // dd( $resp);

        if (($resp['result'] ?? '') !== 'success') {
            return back()
                ->with('error', $resp['message'] ?? 'Failed to create client')
                ->withInput();
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Client created successfully');
    }

    public function details(WhmcsService $whmcs, Request $request)
    {
        $clientId = $request->input('client_id');

        if (!$clientId) {
            return response()->json(['error' => 'Client ID is required'], 400);
        }

        $resp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientId,
        ]);

        if (($resp['result'] ?? '') !== 'success') {
            return response()->json(['error' => $resp['message'] ?? 'Failed to fetch client details'], 500);
        }

        // dd($resp);
        return view('backend.client.view', ['client' => $resp['client'] ?? []]);
    }

    public function edit(WhmcsService $whmcs, $id)
    {
        // dd($id);
        $resp = $whmcs->call('GetClientsDetails', [
            'clientid' => $id,
        ]);

        if (($resp['result'] ?? '') !== 'success') {
            return back()->with('error', $resp['message'] ?? 'Failed to fetch client details');
        }

        $currencyApi = $whmcs->call('GetCurrencies', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // Fix: Use $currencyApi instead of $currency
        $currencies = $currencyApi['currencies']['currency'] ?? [];

        $groupApi = $whmcs->call('GetClientGroups', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // dd($groupApi);
        $groups = $groupApi['groups']['group'] ?? [];
        // dd($groups);
        // Payment method API call
        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        // dd($paymentMethodApi);

        // dd($paymentMethodApi);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];

        // dd($resp['client']);
        // dd($paymethodMethods);
        return view('backend.client.edit', [
            'client' => $resp['client'] ?? [],
            'currencies' => $currencies,
            'groups' => $groups,
            'paymentMethods' => $paymethodMethods,
        ]);

    }

}
