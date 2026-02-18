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
        $contactid = $request->query('contactid');

        $selectedContactId = null;
        if ($contactid === 'addnew' || empty($contacts)) {
            $selectedContactId = 'addnew';
        } elseif (!empty($contactid)) {
            $selectedContactId = (int)$contactid;
        } else {
            $first = $contacts[0] ?? null;
            $selectedContactId = $first ? (int)($first['id'] ?? $first['contactid'] ?? 0) : 'addnew';
        }

        $selectedContact = [];
        if ($selectedContactId !== 'addnew' && !empty($selectedContactId)) {
            $detailResp = $whmcs->call('GetContactDetails', [
                'contactid' => (int)$selectedContactId,
            ]);

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
            'selectedContactId' => $selectedContactId,
            'selectedContact' => $selectedContact,
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
            'domainemails'     => $request->input('domainemails'),
            'generalemails'     => $request->input('generalemails'),
            'invoiceemails'     => $request->input('invoiceemails'),
            'productemails'     => $request->input('productemails'),
            'supportemails'     => $request->input('supportemails'),
            'affiliateemails'     => $request->input('affiliateemails'),

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
    public function updateUserContact(WhmcsService $whmcs, Request $request, $clientId, $contactId)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'required|string|max:30',

            'address1'  => 'required|string|max:255',
            'address2'  => 'nullable|string|max:255',
            'city'      => 'required|string|max:255',
            'state'     => 'required|string|max:255',
            'postcode'  => 'required|string|max:30',
            'country'   => 'required|string|max:2',

            // email notifications
            'generalemails'   => 'nullable|in:0,1',
            'invoiceemails'   => 'nullable|in:0,1',
            'supportemails'   => 'nullable|in:0,1',
            'productemails'   => 'nullable|in:0,1',
            'domainemails'    => 'nullable|in:0,1',
            'affiliateemails' => 'nullable|in:0,1',
        ]);


        if ((int)$contactId === 0) {

            $resp = $whmcs->call('AddContact', [
                'clientid'  => (int)$clientId,
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'email'     => $request->email,
                'phonenumber' => $request->phone,

                'address1'  => $request->address1,
                'address2'  => $request->address2,
                'city'      => $request->city,
                'state'     => $request->state,
                'postcode'  => $request->postcode,
                'country'   => $request->country,

                'generalemails'   => (string)$request->input('generalemails', 0),
                'invoiceemails'   => (string)$request->input('invoiceemails', 0),
                'supportemails'   => (string)$request->input('supportemails', 0),
                'productemails'   => (string)$request->input('productemails', 0),
                'domainemails'    => (string)$request->input('domainemails', 0),
                'affiliateemails' => (string)$request->input('affiliateemails', 0),
            ]);

            if (($resp['result'] ?? '') !== 'success') {
                return back()->withErrors([
                    'whmcs' => $resp['message'] ?? 'Contact creation failed'
                ])->withInput();
            }

            return back()->with('success', 'Contact created successfully');
        }


        $postData = [
            'contactid' => (int)$contactId,
            'clientid'  => (int)$clientId,

            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'phonenumber' => $request->phone,

            'address1'  => $request->address1,
            'address2'  => $request->address2,
            'city'      => $request->city,
            'state'     => $request->state,
            'postcode'  => $request->postcode,
            'country'   => $request->country,
        ];

        $emailToggleFields = [
            'generalemails',
            'invoiceemails',
            'supportemails',
            'productemails',
            'domainemails',
            'affiliateemails',
        ];

        foreach ($emailToggleFields as $field) {
            if ($request->has($field)) {
                $postData[$field] = (string)$request->input($field);
            }
        }

        $resp = $whmcs->call('UpdateContact', $postData);

        if (($resp['result'] ?? '') !== 'success') {
            return back()->withErrors([
                'whmcs' => $resp['message'] ?? 'Contact update failed'
            ])->withInput();
        }

        return back()->with('success', 'Contact updated successfully');
    }

    public function products(WhmcsService $whmcs, Request $request, $clientId)
    {
        // Client details
        $clientResp = $whmcs->call('GetClientsDetails', [
            'clientid' => (int)$clientId,
        ]);
        // dd($clientResp);

        $client = $clientResp['client'] ?? [];
        // comment ------------------------------------------------

        $resp = $whmcs->call('GetClients', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        $clients = $resp['clients']['client'] ?? [];
        // dd($clients);

        // single client normalize
        if (!empty($clients) && isset($clients['id'])) {
            $clients = [$clients];
        }
        // dd($client);

        $respclientproducts = $whmcs->call('GetClientsProducts', [
            'clientid' => (int)$clientId,
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // dd($resp);
        $clientId = request()->route('clientId');
        $productsclient = $respclientproducts['products']['product'] ?? [];


        // dd($products);

        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        $respaproduct = $whmcs->call('GetProducts', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        // dd($respaproduct);
        $mainproducts = $respaproduct['products']['product'] ?? [];
        $products = $mainproducts;
        $groupMap = [];
        foreach (($respaproduct['productgroups']['group'] ?? []) as $g) {
            $groupMap[$g['gid']] = $g['name'];
        }

        $grouped = [];
        foreach ($products as $p) {
            $gid = $p['gid'] ?? 0;
            $groupName = $groupMap[$gid] ?? ('Group #'.$gid);
            $grouped[$groupName][] = $p;
        }
        // dd($mainproducts);


        // dd($paymentMethodApi);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];
        // dd($products, $client, $clientId, $clients, $paymethodMethods, $mainproducts);


        if ($productsclient === []) {
            // dd($productsclient);
        return view('backend.client.product.index', [
                        'products'          => $products,
                        'client'            => $client,
                        'clientId'          => $clientId,
                        'clients'           => $clients,
                        'paymethodMethods'  => $paymethodMethods,
                        'mainproducts'      => $grouped,
                        'productsclient'    => $productsclient,
                    ]);
            }else{

            dd($productsclient);


            return view('backend.client.product.oders', [
                'products'          => $products,
                'client'            => $client,
                'clientId'          => $clientId,
                'clients'           => $clients,
                'paymethodMethods'  => $paymethodMethods,
                'mainproducts'      => $grouped,
                'productsclient'    => $productsclient,
            ]);
            }
    }


    // <-- Additional methods for product management can be added here -->


    public function createOrder(WhmcsService $whmcs, Request $request, $clientId)
    {
        // Client details
        $clientResp = $whmcs->call('GetClientsDetails', [
            'clientid' => (int)$clientId,
        ]);
        // dd($clientResp);

        $client = $clientResp['client'] ?? [];
        // comment ------------------------------------------------

        $resp = $whmcs->call('GetClients', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        $clients = $resp['clients']['client'] ?? [];
        // dd($clients);

        // single client normalize
        if (!empty($clients) && isset($clients['id'])) {
            $clients = [$clients];
        }
        // dd($client);

        $respclientproducts = $whmcs->call('GetClientsProducts', [
            'clientid' => (int)$clientId,
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // dd($resp);
        $clientId = request()->route('clientId');
        $productsclient = $respclientproducts['products']['product'] ?? [];


        // dd($products);

        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        $respaproduct = $whmcs->call('GetProducts', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        // dd($respaproduct);
        $mainproducts = $respaproduct['products']['product'] ?? [];

        // ধরেন $mainproducts = $resp['products']['product'] বা আপনার যেভাবে আসছে
        $products = $mainproducts;

        // group name বের করতে map বানান (WHMCS API GetProducts -> productgroups থেকে পাওয়া যায়)
        $groupMap = [];
        foreach (($respaproduct['productgroups']['group'] ?? []) as $g) {
            $groupMap[$g['gid']] = $g['name'];
        }

        // gid অনুযায়ী group
        $grouped = [];
        foreach ($products as $p) {
            $gid = $p['gid'] ?? 0;
            $groupName = $groupMap[$gid] ?? ('Group #'.$gid);
            $grouped[$groupName][] = $p;
        }
        // dd($mainproducts);


        // dd($paymentMethodApi);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];
        // dd($products, $client, $clientId, $clients, $paymethodMethods, $mainproducts);


        return view('backend.client.product.create', [
                        'products'          => $products,
                        'client'            => $client,
                        'clientId'          => $clientId,
                        'clients'           => $clients,
                        'paymethodMethods'  => $paymethodMethods,
                        'mainproducts'      => $grouped,
                        'productsclient'    => $productsclient,
                    ]);



    }

    // 1) products list
    public function ajaxProducts(Request $request, WhmcsService $whmcs)
    {
        $resp = $whmcs->call('GetProducts', [
            'pid' => '',
        ]);

        // WHMCS return format varies; normalize simple list:
        $products = $resp['products']['product'] ?? [];
        return response()->json(['products' => $products]);
    }

    // 2) client domains list
    public function ajaxClientDomains(Request $request, WhmcsService $whmcs)
    {
        $clientId = $request->query('client_id');
        $resp = $whmcs->call('GetClientsDomains', ['clientid' => $clientId]);

        $domains = $resp['domains']['domain'] ?? [];
        return response()->json(['domains' => $domains]);
    }

    // 3) product pricing for a pid
    public function ajaxProductPricing(Request $request, WhmcsService $whmcs)
    {
        $pid = $request->query('pid');
        $resp = $whmcs->call('GetProducts', ['pid' => $pid]);

        $product = ($resp['products']['product'][0] ?? null);
        // pricing structure example: $product['pricing']['USD']['monthly'] etc (depends on WHMCS settings)
        return response()->json(['product' => $product]);
    }

    // 4) AddOrder submit
    public function storeOrder(Request $request, WhmcsService $whmcs)
    {
        // dd($request->all());
        $request->validate([
            'clientid'       => 'required|integer',
            'paymentmethod'  => 'required|string',
            'orderstatus'    => 'nullable|string',
        ]);

        // dd($request->all());

        $filterArray = function ($arr) {
            $arr = is_array($arr) ? $arr : [];
            return array_values(array_filter($arr, function ($v) {
                if (is_null($v)) return false;
                $v = is_string($v) ? trim($v) : $v;
                return $v !== '';
            }));
        };
        // dd($filterArray);

        $pid          = $filterArray($request->input('pid', []));
        $qty          = $filterArray($request->input('qty', []));
        $domain       = $filterArray($request->input('domain', []));
        $billingcycle = $filterArray($request->input('billingcycle', []));
        $priceoverride= $filterArray($request->input('priceoverride', []));

        $regaction    = $filterArray($request->input('regaction', []));
        $regdomain    = $filterArray($request->input('regdomain', []));
        $regperiod    = $filterArray($request->input('regperiod', []));
        $eppcode      = $filterArray($request->input('eppcode', []));
        $idnlanguage  = $filterArray($request->input('idnlanguage', []));

        $dnsmanagement   = $request->input('dnsmanagement', []);
        $emailforwarding = $request->input('emailforwarding', []);
        $idprotection    = $request->input('idprotection', []);
        $domainpriceoverride = $request->input('domainpriceoverride', []);
        $domainrenewoverride = $request->input('domainrenewoverride', []);
        // dd($pid, $qty, $domain, $billingcycle, $priceoverride, $regaction, $regdomain, $regperiod, $eppcode, $idnlanguage, $dnsmanagement, $emailforwarding, $idprotection);

        $toBoolArray = function ($arr) {
            $arr = is_array($arr) ? $arr : [];
            $out = [];
            foreach ($arr as $k => $v) {
                $out[] = in_array($v, [1, '1', true, 'true', 'on'], true);
            }
            return $out;
        };

        $payload = [
            'clientid'      => (int) $request->input('clientid'),
            'paymentmethod' => $request->input('paymentmethod'),
        ];
        // dd($payload);

        if ($request->filled('promocode') && $request->input('promocode') !== '0') {
            $payload['promocode'] = $request->input('promocode');
        }

        if ($request->filled('orderstatus')) {
            $payload['status'] = $request->input('orderstatus');
        }

        $payload['noemail']        = !$request->has('adminorderconf');
        $payload['noinvoice']      = !$request->has('admingenerateinvoice');
        $payload['noinvoiceemail'] = !$request->has('adminsendinvoice');

        if (!empty($pid)) {
            $payload['pid'] = array_map('intval', $pid);
            // dd($payload);

            if (!empty($qty)) {
                $payload['qty'] = array_map('intval', array_pad($qty, count($pid), 1));
            } else {
                $payload['qty'] = array_fill(0, count($pid), 1);
            }

            if (!empty($domain)) {
                $payload['domain'] = array_pad($domain, count($pid), '');
            }
            if (!empty($billingcycle)) {
                $payload['billingcycle'] = array_pad($billingcycle, count($pid), '');
            }
            if (!empty($priceoverride)) {
                $payload['priceoverride'] = array_map(function($v){
                    return is_numeric($v) ? (float)$v : 0;
                }, array_pad($priceoverride, count($pid), 0));
            }
            // dd($payload);
        }

        if (!empty($regaction)) {
            $payload['domaintype'] = array_pad($regaction, count($regaction), '');

            if (!empty($regdomain)) {
                $payload['domain'] = isset($payload['domain'])
                    ? $payload['domain']
                    : [];
                $payload['domain'] = array_merge($payload['domain'], $regdomain);
            }

            if (!empty($regperiod)) {
                $payload['regperiod'] = array_map('intval', $regperiod);
            }

            if (!empty($eppcode)) {
                $payload['eppcode'] = $eppcode;
            }

            if (!empty($idnlanguage)) {
                $payload['idnlanguage'] = $idnlanguage;
            }

            if (!empty($dnsmanagement)) {
                $payload['dnsmanagement'] = $toBoolArray($dnsmanagement);
            }
            if (!empty($emailforwarding)) {
                $payload['emailforwarding'] = $toBoolArray($emailforwarding);
            }
            if (!empty($idprotection)) {
                $payload['idprotection'] = $toBoolArray($idprotection);
            }

            if (!empty($domainpriceoverride)) {
                $payload['domainpriceoverride'] = array_map(function($v){
                    return is_numeric($v) ? (float)$v : 0;
                }, $filterArray($domainpriceoverride));
            }
            if (!empty($domainrenewoverride)) {
                $payload['domainrenewoverride'] = array_map(function($v){
                    return is_numeric($v) ? (float)$v : 0;
                }, $filterArray($domainrenewoverride));
            }
        }

        $payload = array_filter($payload, function($v){
            if (is_array($v)) return count($v) > 0;
            return $v !== null && $v !== '';
        });
        // dd($payload);

        $resp = $whmcs->call('AddOrder', $payload);
        $orderId = $resp['orderid'] ?? null;

        if (!$orderId) {
            dd('No orderid returned', $resp);
        }

        // ✅ GetOrders ঠিকভাবে কল করুন (array payload)
        $orders = $whmcs->call('GetOrders', [
            'id' => $orderId, // কিছু WHMCS-এ id কাজ করে
        ]);

        // dd($orders);
        if (($resp['result'] ?? '') !== 'success') {
            return back()->withInput()->with('error', $resp['message'] ?? 'Order create failed')->with('whmcs', $resp);
        }

        // dd($resp);

        return redirect()
            ->route('admin.users.products', ['clientId' => $request->input('clientid')])
            ->with('success', 'Order Created Successfully!')
            ->with('whmcs', $resp);
    }






}
