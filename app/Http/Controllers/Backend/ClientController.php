<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\WhmcsService;
use Carbon\Carbon;
use Illuminate\Http\Request; // use Symfony\Component\HttpFoundation\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function domains(WhmcsService $whmcs, $clientid)
    {


        $resp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientid,
        ]);

        // dd($transactiondata);
        $paymethodMethods = $whmcs->call('GetPaymentMethods');

        $paymentMethods = $paymethodMethods['paymentmethods']['paymentmethod'] ?? [];

        // dd($resp);

        return view('backend.client.domain.index', [
            'client' => $resp['client'] ?? [],
        ]);
    }
    public function storeBillableItem(Request $request, WhmcsService $whmcs, $clientid)
    {
        $request->merge([
            'description'   => $request->description ? trim($request->description) : null,
            'hours'         => $request->hours !== null ? trim($request->hours) : '0',
            'amount'        => $request->amount !== null ? trim($request->amount) : '0.00',
            'invoiceaction' => $request->invoiceaction !== null ? trim($request->invoiceaction) : 'noinvoice',
            'recur'         => $request->recur !== null ? trim($request->recur) : '0',
            'recurcycle'    => $request->recurcycle ? trim($request->recurcycle) : null,
            'recurfor'      => $request->recurfor !== null ? trim($request->recurfor) : null,
            'duedate'       => $request->duedate ? trim($request->duedate) : null,
            'invoicecount'  => $request->invoicecount !== null ? trim($request->invoicecount) : '0',
            'unit'          => $request->unit !== null ? trim($request->unit) : 'hours',
        ]);

        $request->validate([
            'description'   => ['required', 'string', 'max:255'],
            'hours'         => ['required', 'numeric', 'min:0'],
            'amount'        => ['required', 'numeric', 'min:0'],
            'unit'          => ['required', 'in:hours,quantity'],
            'invoiceaction' => ['required', 'in:noinvoice,nextcron,nextinvoice,duedate,recur'],
            'duedate'       => ['nullable', 'date_format:d/m/Y'],
            'invoicecount'  => ['nullable', 'integer', 'min:0'],
            'recur'         => ['nullable', 'integer', 'min:0'],
            'recurcycle'    => ['nullable', 'in:Days,Weeks,Months,Years'],
            'recurfor'      => ['nullable', 'integer', 'min:0'],
        ], [
            'description.required'   => 'Description is required.',
            'hours.required'         => 'Hours/Qty is required.',
            'hours.numeric'          => 'Hours/Qty must be a valid number.',
            'amount.required'        => 'Amount is required.',
            'amount.numeric'         => 'Amount must be a valid number.',
            'unit.in'                => 'Invalid unit selected.',
            'invoiceaction.in'       => 'Invalid invoice action selected.',
            'duedate.date_format'    => 'Due Date must be in dd/mm/yyyy format.',
            'invoicecount.integer'   => 'Invoice Count must be a valid number.',
            'recur.integer'          => 'Recurring interval must be a valid number.',
            'recurcycle.in'          => 'Invalid recurring cycle selected.',
            'recurfor.integer'       => 'Recurring times must be a valid number.',
        ]);

        // Recur হলে extra validation
        if ($request->invoiceaction === 'recur') {
            if ((int) $request->recur <= 0) {
                return redirect()->back()
                    ->withErrors(['recur' => 'Recurring interval must be greater than 0.'])
                    ->withInput();
            }

            if (empty($request->recurcycle)) {
                return redirect()->back()
                    ->withErrors(['recurcycle' => 'Recurring cycle is required.'])
                    ->withInput();
            }

            if ($request->recurfor !== null && $request->recurfor !== '' && (int) $request->recurfor <= 0) {
                return redirect()->back()
                    ->withErrors(['recurfor' => 'Recurring times must be greater than 0.'])
                    ->withInput();
            }
        }

        // Due date দরকার হলে
        if (in_array($request->invoiceaction, ['duedate', 'recur'], true) && empty($request->duedate)) {
            return redirect()->back()
                ->withErrors(['duedate' => 'Due Date is required for this invoice action.'])
                ->withInput();
        }

        $postData = array_filter([
            'clientid'      => $clientid,
            'description'   => $request->description,
            'hours'         => $request->hours,
            'amount'        => $request->amount,
            'invoiceaction' => $request->invoiceaction,
            'duedate'       => $request->duedate,
            'invoicecount'  => $request->invoicecount,
            'recur'         => $request->recur,
            'recurcycle'    => $request->recurcycle,
            'recurfor'      => $request->recurfor,
            'unit'          => $request->unit, // hours or quantity
        ], function ($value) {
            return $value !== null && $value !== '';
        });

        $response = $whmcs->call('AddBillableItem', $postData);

        if (($response['result'] ?? '') !== 'success') {
            return redirect()->back()
                ->withErrors([
                    'api' => $response['message'] ?? 'Failed to add billable item.'
                ])
                ->withInput();
        }

        return redirect()
            ->route('admin.users.billableitem', ['clientid' => $clientid])
            ->with('success', 'Billable item added successfully.');
    }
    public function addBillableitem(WhmcsService $whmcs, $clientid)
    {

            // dd($clientid);
        $resp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientid,
        ]);

        // dd($transactiondata);
        $paymethodMethods = $whmcs->call('GetPaymentMethods');

        $paymentMethods = $paymethodMethods['paymentmethods']['paymentmethod'] ?? [];


        return view('backend.client.billableitem.add', [
            'client' => $resp['client'] ?? [],
        ]);
    }
    public function billableitem(WhmcsService $whmcs, $clientid)
    {


        $resp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientid,
        ]);

        // dd($transactiondata);
        $paymethodMethods = $whmcs->call('GetPaymentMethods');

        $paymentMethods = $paymethodMethods['paymentmethods']['paymentmethod'] ?? [];

        // dd($resp);

        return view('backend.client.billableitem.index', [
            'client' => $resp['client'] ?? [],
        ]);
    }

    public function updateTransaction(Request $request, WhmcsService $whmcs, $clientid, $transactionid)
    {
        $request->merge([
            'userid' => $clientid,
            'date' => $request->date ? trim($request->date) : null,
            'description' => $request->description ? trim($request->description) : null,
            'transid' => $request->transid ? trim($request->transid) : null,
            'invoiceid' => $request->invoiceid ? trim($request->invoiceid) : null,
            'amountin' => $request->amountin !== null ? trim($request->amountin) : null,
            'amountout' => $request->amountout !== null ? trim($request->amountout) : null,
            'fees' => $request->fees !== null ? trim($request->fees) : null,
            'paymentmethod' => $request->paymentmethod ? trim($request->paymentmethod) : null,
            'rate' => $request->rate ? trim($request->rate) : '1.00000',
        ]);

        $request->validate([
            'date' => ['required', 'date_format:d/m/Y'],
            'paymentmethod' => ['required', 'string'],

            'description' => ['nullable', 'string', 'max:255', 'required_without:invoiceid'],
            'invoiceid' => ['nullable', 'integer', 'min:1', 'required_without:description'],

            'amountin' => ['nullable', 'numeric', 'min:0'],
            'amountout' => ['nullable', 'numeric', 'min:0'],
            'fees' => ['nullable', 'numeric', 'min:0'],

            'transid' => ['nullable', 'string', 'max:191'],
            'rate' => ['nullable', 'numeric', 'min:0'],
            'addcredit' => ['nullable', 'in:1'],
        ], [
            'date.required' => 'Transaction date is required.',
            'date.date_format' => 'Date must be in dd/mm/yyyy format.',

            'paymentmethod.required' => 'Payment method is required.',

            'description.required_without' => 'Invoice ID or description is required.',
            'invoiceid.required_without' => 'Invoice ID or description is required.',

            'invoiceid.integer' => 'Invoice ID must be a valid number.',
            'invoiceid.min' => 'Invoice ID must be greater than 0.',

            'amountin.numeric' => 'Amount In must be a valid number.',
            'amountout.numeric' => 'Amount Out must be a valid number.',
            'fees.numeric' => 'Fees must be a valid number.',

            'amountin.min' => 'Amount In cannot be negative.',
            'amountout.min' => 'Amount Out cannot be negative.',
            'fees.min' => 'Fees cannot be negative.',
        ]);

        $amountIn = (float) ($request->amountin ?? 0);
        $amountOut = (float) ($request->amountout ?? 0);
        $fees = (float) ($request->fees ?? 0);

        if ($amountIn <= 0 && $amountOut <= 0) {
            return redirect()->back()
                ->withErrors([
                    'amountin' => 'Amount In or Amount Out is required.'
                ])
                ->withInput();
        }

        if ($fees > 0 && $amountIn <= 0) {
            return redirect()->back()
                ->withErrors([
                    'fees' => 'Fees cannot be added without Amount In.'
                ])
                ->withInput();
        }

        if ($fees > 0 && $amountIn > 0 && $fees >= $amountIn) {
            return redirect()->back()
                ->withErrors([
                    'fees' => 'The fee being entered must be less than the Amount In value.'
                ])
                ->withInput();
        }

        if ($amountIn > 0 && $amountOut > 0) {
            return redirect()->back()
                ->withErrors([
                    'amountout' => 'Amount In and Amount Out cannot both be greater than zero.'
                ])
                ->withInput();
        }

        $formattedDateTime = Carbon::createFromFormat('d/m/Y', $request->date)
            ->setTimeFromTimeString(now()->format('H:i:s'))
            ->format('Y-m-d H:i:s');

        $postData = array_filter([
            'transactionid' => $transactionid,
            'paymentmethod' => $request->paymentmethod,
            'userid' => $clientid,
            'transid' => $request->transid,
            'date' => $formattedDateTime,
            'description' => $request->description,
            'amountin' => $request->amountin,
            'amountout' => $request->amountout,
            'fees' => $request->fees,
            'invoiceid' => $request->invoiceid,
            'rate' => $request->rate ?? '1.00000',
            'addcredit' => $request->has('addcredit') ? true : false,
        ], function ($value) {
            return $value !== null && $value !== '';
        });

        $response = $whmcs->call('UpdateTransaction', $postData);

        if (($response['result'] ?? '') !== 'success') {
            return redirect()->back()
                ->withErrors([
                    'api' => $response['message'] ?? 'Failed to update transaction.'
                ])
                ->withInput();
        }

        return redirect()
            ->route('admin.users.transaction.edit', [
                'clientid' => $clientid,
                'transactionid' => $transactionid
            ])
            ->with('success', 'Transaction updated successfully.');
    }
    public function editTransaction(WhmcsService $whmcs, $clientid, $transactionid)
    {

        $resp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientid,
        ]);

        $transactionResp = $whmcs->call('GetTransactions', [
            'clientid' => $clientid,
        ]);

        $transactions = $transactionResp['transactions']['transaction'] ?? [];


        $transactiondata = collect($transactions)
                            ->where('id', $transactionid)
                            ->first();

        // dd($transactiondata);
        $paymethodMethods = $whmcs->call('GetPaymentMethods');

        $paymentMethods = $paymethodMethods['paymentmethods']['paymentmethod'] ?? [];


        return view('backend.client.transaction.edit', [
            'client' => $resp['client'] ?? [],
            'transaction' => $transactiondata,
            'paymethodMethods' => $paymentMethods,
        ]);
    }


    public function addTransaction(Request $request, WhmcsService $whmcs, $clientid)
    {
        $resp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientid,
        ]);

        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        // dd($paymentMethodApi);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];



        return view('backend.client.transaction.addtransaction', [
            'client' => $resp['client'] ?? [],
            'paymethodMethods' => $paymethodMethods,

        ]);
    }
    public function storeTransaction(Request $request, WhmcsService $whmcs, $clientid)
    {
        $request->merge([
            'userid' => $clientid,
            'date' => $request->date ? trim($request->date) : null,
            'description' => $request->description ? trim($request->description) : null,
            'transid' => $request->transid ? trim($request->transid) : null,
            'invoiceid' => $request->invoiceid ? trim($request->invoiceid) : null,
            'amountin' => $request->amountin !== null ? trim($request->amountin) : null,
            'amountout' => $request->amountout !== null ? trim($request->amountout) : null,
            'fees' => $request->fees !== null ? trim($request->fees) : null,
            'paymentmethod' => $request->paymentmethod ? trim($request->paymentmethod) : null,
            'rate' => $request->rate ? trim($request->rate) : '1.00000',
        ]);

        $request->validate([
            'date' => ['required', 'date_format:d/m/Y'],
            'paymentmethod' => ['required', 'string'],

            'description' => ['nullable', 'string', 'max:255', 'required_without:invoiceid'],
            'invoiceid' => ['nullable', 'integer', 'min:1', 'required_without:description'],

            'amountin' => ['nullable', 'numeric', 'min:0'],
            'amountout' => ['nullable', 'numeric', 'min:0'],
            'fees' => ['nullable', 'numeric', 'min:0'],

            'transid' => ['nullable', 'string', 'max:191'],
            'rate' => ['nullable', 'numeric', 'min:0'],
            'addcredit' => ['nullable', 'in:1'],
        ], [
            'date.required' => 'Transaction date is required.',
            'date.date_format' => 'Date must be in dd/mm/yyyy format.',

            'paymentmethod.required' => 'Payment method is required.',

            'description.required_without' => 'Invoice ID or description is required.',
            'invoiceid.required_without' => 'Invoice ID or description is required.',

            'invoiceid.integer' => 'Invoice ID must be a valid number.',
            'invoiceid.min' => 'Invoice ID must be greater than 0.',

            'amountin.numeric' => 'Amount In must be a valid number.',
            'amountout.numeric' => 'Amount Out must be a valid number.',
            'fees.numeric' => 'Fees must be a valid number.',

            'amountin.min' => 'Amount In cannot be negative.',
            'amountout.min' => 'Amount Out cannot be negative.',
            'fees.min' => 'Fees cannot be negative.',
        ]);

        $amountIn = (float) ($request->amountin ?? 0);
        $amountOut = (float) ($request->amountout ?? 0);
        $fees = (float) ($request->fees ?? 0);

        if ($amountIn <= 0 && $amountOut <= 0) {
            return redirect()->back()
                ->withErrors([
                    'amountin' => 'Amount In or Amount Out is required.'
                ])
                ->withInput();
        }

        if ($fees > 0 && $amountIn <= 0) {
            return redirect()->back()
                ->withErrors([
                    'fees' => 'Fees cannot be added without Amount In.'
                ])
                ->withInput();
        }

        if ($fees > 0 && $amountIn > 0 && $fees >= $amountIn) {
            return redirect()->back()
                ->withErrors([
                    'fees' => 'The fee being entered must be less than the Amount In value.'
                ])
                ->withInput();
        }

        if ($amountIn > 0 && $amountOut > 0) {
            return redirect()->back()
                ->withErrors([
                    'amountout' => 'Amount In and Amount Out cannot both be greater than zero.'
                ])
                ->withInput();
        }

        $postData = array_filter([
            'paymentmethod' => $request->paymentmethod,
            'userid' => $clientid,
            'transid' => $request->transid,
            'date' => $request->date,
            'description' => $request->description,
            'amountin' => $request->amountin,
            'amountout' => $request->amountout,
            'fees' => $request->fees,
            'invoiceid' => $request->invoiceid,
            'rate' => $request->rate ?? '1.00000',
            'addcredit' => $request->has('addcredit') ? true : false,
        ], function ($value) {
            return $value !== null && $value !== '';
        });

        $response = $whmcs->call('AddTransaction', $postData);

        if (($response['result'] ?? '') !== 'success') {
            return redirect()->back()
                ->withErrors([
                    'api' => $response['message'] ?? 'Failed to add transaction.'
                ])
                ->withInput();
        }

        return redirect()
            ->route('admin.users.addtransaction', ['clientid' => $clientid])
            ->with('success', 'Transaction added successfully.');
    }
    public function transaction(Request $request, WhmcsService $whmcs, $clientid)
    {
        $resp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientid,
        ]);

        $transactions = $whmcs->call('GetTransactions', [
            'clientid' => $clientid,
        ]);

        $transactionsList = collect($transactions['transactions']['transaction'] ?? [])
                            ->where('amountout', 0)
                            ->sortByDesc('id')
                            ->values();

            // dd($transactionsList);

        $totalIn = $transactionsList->sum(fn($t) => (float) ($t['amountin'] ?? 0));
        $totalFees = $transactionsList->sum(fn($t) => (float) ($t['fees'] ?? 0));
        $totalOut = $transactionsList->sum(fn($t) => (float) ($t['amountout'] ?? 0));
        $balance = $totalIn - $totalOut - $totalFees;

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $transactionsList->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedTransactions = new LengthAwarePaginator(
            $currentItems,
            $transactionsList->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('backend.client.transaction.transaction', [
            'client' => $resp['client'] ?? [],
            'transactions' => $paginatedTransactions,
            'stats' => [
                'total_in' => $totalIn,
                'total_fees' => $totalFees,
                'total_out' => $totalOut,
                'balance' => $balance,
            ],
        ]);
    }
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

        // dd($respclientproducts);
        // dd($resp);
        $clientId = request()->route('clientId');
        $productsclient = $respclientproducts['products']['product'] ?? [];
        $latestProduct = collect($productsclient)
                        ->sortByDesc('id')
                        ->first();

        // dd($latestProduct);


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



        // dd($productsclient);
            return view('backend.client.product.oders', [
                'products'          => $products,
                'client'            => $client,
                'clientId'          => $clientId,
                'clients'           => $clients,
                'paymethodMethods'  => $paymethodMethods,
                'mainproducts'      => $grouped,
                'productsclient'    => $productsclient,
                'latestProduct'    => $latestProduct,
            ]);

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

    public function clientProductShow(WhmcsService $whmcs, Request $request)
    {

        $clientId  = (int) $request->route('clientid');
        $productId = (string) $request->route('productid');

        // dd($productId);

        $clientResp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientId,
        ]);
        $client = $clientResp['client'] ?? [];

        if (!isset($client['id']) && isset($client['userid'])) {
            $client['id'] = $client['userid'];
        }

        $resp = $whmcs->call('GetClients', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        $clients = $resp['clients']['client'] ?? [];

        if (!empty($clients) && isset($clients['id'])) {
            $clients = [$clients];
        }

        $respclientproducts = $whmcs->call('GetClientsProducts', [
            'clientid'    => $clientId,
            'limitstart'  => 0,
            'limitnum'    => 50,
        ]);

        $productsclient = $respclientproducts['products']['product'] ?? [];
        // dd($productsclient);

        if (!empty($productsclient) && isset($productsclient['id'])) {
            $productsclient = [$productsclient];
        }

        $latestProduct = collect($productsclient)->firstWhere('id', $productId)
            ?? collect($productsclient)->firstWhere('serviceid', $productId)
            ?? collect($productsclient)->sortByDesc('id')->first();

        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod'] ?? [];

        $respaproduct = $whmcs->call('GetProducts', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);

        $products = $respaproduct['products']['product'] ?? [];

        $groupMap = [];
        foreach (($respaproduct['productgroups']['group'] ?? []) as $g) {
            $groupMap[$g['gid']] = $g['name'] ?? ('Group #'.$g['gid']);
        }

        $grouped = [];
        foreach ($products as $p) {
            $gid = $p['gid'] ?? 0;
            $groupName = $groupMap[$gid] ?? ('Group #'.$gid);
            $grouped[$groupName][] = $p;
        }


        return view('backend.client.product.show', [
            'products'         => $products,
            'client'           => $client,
            'clientId'         => $clientId,
            'productId'        => $productId,
            'clients'          => $clients,
            'paymethodMethods' => $paymethodMethods,
            'mainproducts'     => $grouped,
            'productsclient'   => $productsclient,
            'latestProduct'    => $latestProduct,
        ]);
    }



    public function UpdateClientProduct(Request $request, WhmcsService $whmcs)
    {
        // dd($request->all());
        $clientId  = (int) $request->input('clientid');
        $serviceId = (string) $request->input('serviceid');

        $request->validate([
            'billingcycle' => 'required',
            'status'       => 'required|string',
            'nextduedate'  => 'required|string',
        ]);
        // dd($request->all());

        // pid[] fix
        $pid = $request->input('pid');
        if (is_array($pid)) {
            $pid = $pid[0] ?? null;
        }

        $payload = [
            'serviceid'          => $serviceId,
            'regdate'            => $request->input('regdate'),
            'pid'                => $pid,
            'qty'                => $request->input('qty'),

            'firstpaymentamount' => $request->input('firstpaymentamount'),
            'recurringamount'    => $request->input('recurringamount'),

            'domain'             => $request->input('domain'),
            'nextduedate'        => $request->input('nextduedate'),
            'billingcycle'       => $request->input('billingcycle'),

            'paymentmethod'      => $request->input('paymentmethod'),
            'status'             => $request->input('status'),

            'dedicatedip'        => $request->input('dedicatedip'),
            'notes'              => $request->input('notes'),
        ];
        // dd($payload);

        if ($request->filled('priceoverride')) {
            $payload['priceoverride'] = is_numeric($request->input('priceoverride'))
                ? (float) $request->input('priceoverride')
                : 0;
        }

        $resp = $whmcs->call('UpdateClientProduct', $payload);

        if (($resp['result'] ?? '') !== 'success') {

            return back()
                ->withInput()
                ->with('error', $resp['message'] ?? 'Product update failed')
                ->with('whmcs', $resp);
        }
        // dd('here');

        return back()
                    ->with('success', 'Product updated successfully')
                    ->with('whmcs', $resp);
    }



    public function invoices(Request $request, WhmcsService $whmcs ,$clientid)
    {

        $clientResp = $whmcs->call('GetClientsDetails', [
            'clientid' => $clientid,
        ]);
        $client = $clientResp['client'] ?? [];


        $invoicesResp = $whmcs->call('GetInvoices', [
            'userid'  => $clientid,
            'orderby' => 'id',
            'order'   => 'desc',
        ]);

        $invoices = $invoicesResp['invoices']['invoice'] ?? [];


        // dd($invoices);


        return view('backend.client.invoices.index', [
            'client'           => $client,
            'clientid'         => $clientid,
            'invoices'         => $invoices,
        ]);
    }





    public function invoiceAction(Request $request, WhmcsService $whmcs)
    {
        // dd($request->all());

        $request->validate([
            'invoice_id' => 'required|integer',
            'action'     => 'required|string',
        ]);

        $invoiceId = (int) $request->invoice_id;
        $action    = (string) $request->action;

        $invoice = $whmcs->call('GetInvoice', ['invoiceid' => $invoiceId]);


        $userId  = (int) ($invoice['userid'] ?? 0);
        $gateway = $invoice['paymentmethod'] ?? 'mailin';
        $status  = strtolower((string)($invoice['status'] ?? ''));
        $balance = (float) ($invoice['balance'] ?? $invoice['total'] ?? 0);

        switch ($action) {

            case 'mark_paid': {


                if ($invoice['status'] === 'paid' ) {
                            return response()->json(['message' => 'Invoice already paid.']);
                        }


                $resp = $whmcs->call('UpdateInvoice', [
                    'invoiceid' => $invoice['invoiceid'],
                    'status' => 'Paid',
                ]);
                $amount  = (float) ($invoice['balance'] ?? $invoice['total'] ?? 0);
                $gateway = $invoice['paymentmethod'] ?? 'mailin';

                $resp = $whmcs->call('AddInvoicePayment', [
                    'invoiceid' => $invoiceId,
                    'transid'   => 'MANUAL-' . strtoupper(\Illuminate\Support\Str::random(10)),
                    'gateway'   => $gateway,
                    'date'      => now()->format('Y-m-d'),
                    'amount'    => number_format($amount, 2, '.', ''),
                ]);
                return response()->json(['message' => 'Invoice marked as Paid.']);

            }

            case 'mark_unpaid': {
                $resp = $whmcs->call('UpdateInvoice', [
                    'invoiceid' => $invoiceId,
                    'status'    => 'Unpaid',
                ]);
                return response()->json(['message' => 'Invoice marked as Unpaid.']);
            }

            case 'mark_cancelled': {
                $resp = $whmcs->call('UpdateInvoice', [
                    'invoiceid' => $invoiceId,
                    'status'    => 'Cancelled',
                ]);
                return response()->json(['message' => 'Invoice marked as Cancelled.']);
            }

            case 'duplicate_invoice': {
                if ($userId <= 0) {
                    return response()->json(['message' => 'Invalid client id on invoice.'], 422);
                }

                 $items = $invoice['items']['item'] ?? [];
                if (!empty($items) && isset($items['description'])) {
                    $items = [$items];
                }

                if (empty($items)) {
                    return response()->json(['message' => 'No invoice items found to duplicate.'], 422);
                }

                $origDate    = $invoice['date'] ?? now()->format('Y-m-d');
                $origDueDate = $invoice['duedate'] ?? now()->format('Y-m-d');

                $payload = [
                    'userid'        => $userId,
                    'paymentmethod' => $gateway,
                    'status'        => 'Unpaid',
                    'date'          => $origDate,
                    'duedate'       => $origDueDate,
                    'sendinvoice'   => false,
                    'notes'         => trim(($invoice['notes'] ?? '') . "\nDuplicated from invoice #{$invoiceId}"),
                ];

                $i = 1;
                foreach ($items as $it) {
                    // dd($it);
                    $desc = (string) ($it['description'] ?? '');
                    if (trim($desc) === '') continue;

                    $amt = (string) ($it['amount'] ?? '0.00');

                    $taxed = $it['taxed'] ?? 0;
                    $taxed = in_array((string)$taxed, ['1','true','yes'], true) ? 1 : 0;

                    $payload["itemdescription{$i}"] = $desc;
                    $payload["itemamount{$i}"]      = $amt;
                    $payload["itemtaxed{$i}"]       = $taxed;

                    $i++;
                }
                // dd($payload);

                $create = $whmcs->call('CreateInvoice', $payload);

                if (($create['result'] ?? '') !== 'success') {
                    return response()->json([
                        'message' => $create['message'] ?? 'Failed to duplicate invoice.',
                        'debug'   => $create,
                    ], 422);
                }

                return response()->json([
                    'message'      => 'Invoice duplicated successfully.',
                    'newInvoiceId' => $create['invoiceid'] ?? null,
                ]);



            }

            // case 'send_reminder': {
            //     // SendEmail for invoice type: customtype=invoice, id=invoiceid :contentReference[oaicite:13]{index=13}
            //     // Template name MUST exist in WHMCS Email Templates.
            //     $resp = $whmcs->call('SendEmail', [
            //         'customtype'  => 'invoice',
            //         'id'          => $invoiceId,
            //         'messagename' => 'Invoice Payment Reminder', // change if your template name differs
            //     ]);

            //     if (($resp['result'] ?? '') !== 'success') {
            //         return response()->json([
            //             'message' => $resp['message'] ?? 'Failed to send reminder.',
            //             'debug'   => $resp,
            //         ], 422);
            //     }

            //     return response()->json(['message' => 'Reminder email sent successfully.']);
            // }

            // case 'merge': {
            //     // No official public API command for merging invoices; it’s an admin feature. :contentReference[oaicite:14]{index=14}
            //     return response()->json([
            //         'message' => 'Merge is not available via standard WHMCS API. Need custom module/localAPI implementation.',
            //     ], 422);
            // }

            // case 'mass_pay': {
            //     // Mass Pay is an admin feature; no standard API command exposed. :contentReference[oaicite:15]{index=15}
            //     return response()->json([
            //         'message' => 'Mass Pay is not available via standard WHMCS API. Need custom module/localAPI implementation.',
            //     ], 422);
            // }

            // case 'delete': {
            //     // WHMCS API can't delete entire invoice (standard API). :contentReference[oaicite:16]{index=16}
            //     // So we cancel instead (safe alternative).
            //     $resp = $whmcs->call('UpdateInvoice', [
            //         'invoiceid' => $invoiceId,
            //         'status'    => 'Cancelled',
            //     ]); // :contentReference[oaicite:17]{index=17}

            //     if (($resp['result'] ?? '') !== 'success') {
            //         return response()->json([
            //             'message' => $resp['message'] ?? 'Failed to cancel invoice.',
            //             'debug'   => $resp,
            //         ], 422);
            //     }

            //     return response()->json([
            //         'message' => 'Invoice cancelled (API does not support deleting invoices).',
            //     ]);
            // }

            default:
                return response()->json(['message' => 'Unsupported action: ' . $action], 422);
        }
    }









}
