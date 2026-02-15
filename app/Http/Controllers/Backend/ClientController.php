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

        $currencies = $currencyApi['currencies']['currency'] ?? [];

        $groupApi = $whmcs->call('GetClientGroups', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // dd($groupApi);
        $groups = $groupApi['groups']['group'] ?? [];
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

    public function edit(WhmcsService $whmcs, $id, Request $request)
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
        // dd($currencies);

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

    public function update(WhmcsService $whmcs, Request $request, $id)
    {
        $request->validate([
            'firstname'   => 'required|string|max:255',
            'lastname'    => 'required|string|max:255',
            'companyname' => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255',

            'phone'       => 'nullable|string|max:30',
            'address1'    => 'nullable|string|max:255',
            'address2'    => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'postcode'    => 'nullable|string|max:30',
            'country'     => 'nullable|string|max:2',
            'tax_id'      => 'nullable|string|max:100',
            'notes'       => 'nullable|string',

            'currency'       => 'nullable|integer',
            'group'          => 'nullable|integer',
            'status'         => 'nullable|in:Active,Inactive,Closed',
            'payment_method' => 'nullable|string|max:50',

            'email_preferences'   => 'nullable|array',
            'email_preferences.*' => 'nullable|in:0,1',

            'taxexempt'              => 'nullable|in:0,1',
            'latefeeoveride'         => 'nullable|in:0,1',
            'overideduenotices'      => 'nullable|in:0,1',
            'separateinvoices'       => 'nullable|in:0,1',
            'disableautocc'          => 'nullable|in:0,1',
            'emailoptout'            => 'nullable|in:0,1',
            'marketing_emails_opt_in'=> 'nullable|in:0,1',
            'overrideautoclose'      => 'nullable|in:0,1',
            'allowSingleSignOn'      => 'nullable|in:0,1',
        ]);

        $postData = [
            'clientid'    => (int) $id,
            'firstname'   => $request->input('firstname'),
            'lastname'    => $request->input('lastname'),
            'companyname' => $request->input('companyname', ''),
        ];

        // Optional basics
        if ($request->filled('email')) {
            $postData['email'] = $request->input('email');
        }
        if ($request->filled('phone')) {
            $postData['phonenumber'] = $request->input('phone');
        }

        foreach (['address1','address2','city','state','postcode','country','tax_id','notes'] as $f) {
            if ($request->filled($f)) {
                $postData[$f] = $request->input($f);
            }
        }

        if ($request->filled('currency')) {
            $postData['currency'] = (int) $request->input('currency');
        }
        if ($request->filled('group')) {
            $postData['groupid'] = (int) $request->input('group');
        }
        if ($request->filled('status')) {
            $postData['status'] = $request->input('status');
        }
        if ($request->filled('payment_method')) {
            $postData['paymentmethod'] = $request->input('payment_method');
        }

        foreach (['general','invoice','support','product','domain','affiliate'] as $k) {
            if ($request->has("email_preferences.$k")) {
                $postData["email_preferences[$k]"] = (string) $request->input("email_preferences.$k");
            }
        }

        $inverseFields = ['latefeeoveride', 'overideduenotices', 'emailoptout'];

        $toggleFields = [
            'taxexempt',
            'latefeeoveride',
            'overideduenotices',
            'separateinvoices',
            'disableautocc',
            'emailoptout',
            'marketing_emails_opt_in',
            'overrideautoclose',
            'allowSingleSignOn',
        ];

        foreach ($toggleFields as $k) {
            if ($request->has($k)) {
                $enabled = (string)$request->input($k);
                $boolEnabled = in_array($enabled, ['1', 1, true, 'true', 'on'], true);


                if (in_array($k, $inverseFields, true)) {
                    $boolEnabled = !$boolEnabled;
                }

                $postData[$k] = $boolEnabled ? '1' : '0';
            }
        }

        $resp = $whmcs->call('UpdateClient', $postData);

        if (!is_array($resp) || ($resp['result'] ?? '') !== 'success') {
            return back()->withErrors(['whmcs' => $resp['message'] ?? 'WHMCS update failed'])->withInput();
        }


        return back()->with([
            'success' => 'Client updated successfully'
        ]);
    }

    public function getUserContact(WhmcsService $whmcs, Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }

        // Client details
        $clientResp = $whmcs->call('GetClientsDetails', [
            'clientid' => (int)$id,
        ]);
        // dd($clientResp);

        $client = $clientResp['client'] ?? [];

        // Contacts list
        $resp = $whmcs->call('GetContacts', [
            'clientid' => (int)$id,
        ]);
        // dd($resp);

        if (($resp['result'] ?? '') !== 'success') {
            return back()->withErrors(['whmcs' => $resp['message'] ?? 'Failed to fetch client contacts']);
        }

        $contacts = $resp['contacts']['contact'] ?? [];

        // selected contact id from query: ?contactid=...
        $contactid = $request->query('contactid');

        // Decide default selection
        $selectedContactId = null;
        if ($contactid === 'addnew' || empty($contacts)) {
            $selectedContactId = 'addnew';
        } elseif (!empty($contactid)) {
            $selectedContactId = (int)$contactid;
        } else {
            // no query, has contacts => select first
            $first = $contacts[0] ?? null;
            $selectedContactId = $first ? (int)($first['id'] ?? $first['contactid'] ?? 0) : 'addnew';
        }

        // Load selected contact details for form (if not addnew)
        $selectedContact = [];
        if ($selectedContactId !== 'addnew' && !empty($selectedContactId)) {
            // Try to get full details (WHMCS action name may vary)
            $detailResp = $whmcs->call('GetContactDetails', [
                'contactid' => (int)$selectedContactId,
            ]);

            // fallback: if GetContactDetails not available, fill from list item
            $selectedContact = $detailResp['contact'] ?? [];

            if (empty($selectedContact)) {
                foreach ($contacts as $c) {
                    $cid = (int)($c['id'] ?? $c['contactid'] ?? 0);
                    if ($cid === (int)$selectedContactId) {
                        $selectedContact = $c;
                        break;
                    }
                }
            }
        }

        return view('backend.client.contact.index', [
            'contacts' => $contacts,
            'client' => $client,
            'selectedContactId' => $selectedContactId,   // 'addnew' OR int id
            'selectedContact' => $selectedContact,       // array (blank if addnew)
        ]);
    }


    public function createUserContact(WhmcsService $whmcs, Request $request, $id)
    {
        // dd($request->all(), $id);
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:30',
        ]);

        $postData = [
            'clientid'  => (int)$id,
            'firstname' => $request->input('firstname'),
            'lastname'  => $request->input('lastname'),
            'email'     => $request->input('email'),
            'address1'     => $request->input('address1'),
            'address2'     => $request->input('address2'),
            'city'     => $request->input('city'),
            'state'     => $request->input('state'),
            'postcode'     => $request->input('postcode'),
            'country'     => $request->input('country'),
            'companyname'     => $request->input('companyname'),

        ];

        if ($request->filled('phone')) {
            $postData['phonenumber'] = $request->input('phone');
        }

        $resp = $whmcs->call('AddContact', $postData);

        if (!is_array($resp) || ($resp['result'] ?? '') !== 'success') {
            return back()->withErrors(['whmcs' => $resp['message'] ?? 'Failed to create contact'])->withInput();
        }

        return back()->with('success', 'Contact created successfully');
    }





}
