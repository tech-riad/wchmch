<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\WhmcsService;
use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
    public function invoiceDetails(Request $request, WhmcsService $whmcs )
    {
        $invoiceid = $request->invoiceid;

        $invoice = $whmcs->call('GetInvoice', [
            'invoiceid' => $invoiceid,
        ]);

        // dd($invoice);
        $client = $whmcs->call('GetClientsDetails', [
            'clientid' => $invoice['userid'],
            'stats' => true,
        ]);
        // dd($client);

        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        // dd($paymentMethodApi);

        // dd($paymentMethodApi);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];


        return view('backend.client.invoices.invoicedetails',compact('invoice','client','paymethodMethods'));
    }
    public function invoiceEdit(Request $request, WhmcsService $whmcs )
    {
        $invoiceid = $request->invoiceid;

        $invoice = $whmcs->call('GetInvoice', [
            'invoiceid' => $invoiceid,
        ]);

        // dd($invoice);
        $client = $whmcs->call('GetClientsDetails', [
            'clientid' => $invoice['userid'],
            'stats' => true,
        ]);
        // dd($client);

        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        // dd($paymentMethodApi);

        // dd($paymentMethodApi);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];


        return view('backend.client.invoices.edit',compact('invoice','client','paymethodMethods'));
    }
    public function invoiceUpdate(Request $request, WhmcsService $whmcs )
    {
        // dd($request->route('invoiceid'));

    $invoiceid =  $request->route('invoiceid');
        $items = $request->input('items', []);
        $deleteCsv = $request->input('deletelineids', '');
        $deletelineids = collect(explode(',', $deleteCsv))
            ->filter(fn($v) => is_numeric($v) && (int)$v > 0)
            ->map(fn($v) => (int)$v)
            ->values()
            ->all();

        $itemdescription = [];
        $itemamount      = [];
        $itemtaxed       = [];

        $newitemdescription = [];
        $newitemamount      = [];
        $newitemtaxed       = [];

        foreach ($items as $row) {
            $desc = trim((string)($row['description'] ?? ''));
            $amt  = trim((string)($row['amount'] ?? ''));

            if ($desc === '' && $amt === '') {
                continue;
            }

            if ($desc === '' || $amt === '') {
                return redirect()->back()->with('error', 'Each line must have both Description and Amount.');
            }

            $amtNum = (float) preg_replace('/[^0-9.\-]/', '', $amt);

            $taxed = isset($row['taxed']) ? true : false;

            $lineId = isset($row['itemid']) && is_numeric($row['itemid']) ? (int)$row['itemid'] : null;

            if ($lineId) {
                $itemdescription[$lineId] = $desc;
                $itemamount[$lineId]      = $amtNum;
                $itemtaxed[$lineId]       = $taxed;
            } else {
                $newitemdescription[] = $desc;
                $newitemamount[]      = $amtNum;
                $newitemtaxed[]       = $taxed;
            }
        }

        $payload = [
            'invoiceid' => (int)$invoiceid,
        ];

        if (!empty($itemdescription)) {
            $payload['itemdescription'] = $itemdescription;
            $payload['itemamount']      = $itemamount;
            $payload['itemtaxed']       = $itemtaxed;
        }

        if (!empty($newitemdescription)) {
            $payload['newitemdescription'] = $newitemdescription;
            $payload['newitemamount']      = $newitemamount;
            $payload['newitemtaxed']       = $newitemtaxed;
        }

        if (!empty($deletelineids)) {
            $payload['deletelineids'] = $deletelineids;
        }

        $resp = $whmcs->call('UpdateInvoice', $payload);

        if (($resp['result'] ?? '') !== 'success') {
            return redirect()->back()->with('error', $resp['message'] ?? 'Invoice update failed.');
        }

        return redirect()->back()->with('success', 'Invoice updated successfully.');
    }
    public function invoicePaymentAdd(Request $request, WhmcsService $whmcs )
    {
        // dd($request->all());
        $invoiceid = $request->invoiceid;


        $invoice = $whmcs->call('GetInvoice', [
            'invoiceid' => $invoiceid,
        ]);

        // dd($invoice);
        $client = $whmcs->call('GetClientsDetails', [
            'clientid' => $invoice['userid'],
            'stats' => true,
        ]);


        $paymentMethodApi = $whmcs->call('GetPaymentMethods', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];


        $addInvoicePayment = $whmcs->call('AddInvoicePayment', [
            'invoiceid' => $invoiceid,
            'transid' => $request->transid,
            'gateway' => $request->paymentmethod,
            'date' => $request->date,
        ]);
        $addInvoicePayment = $whmcs->call('AddInvoicePayment', [
            'invoiceid' => $invoiceid,
            'status' => 'Paid',

        ]);

        return redirect()->back()->with('success', 'Payment added successfully');
    }

}
