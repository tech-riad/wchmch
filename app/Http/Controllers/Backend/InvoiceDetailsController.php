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
    public function invoicePaymentAdd(Request $request, WhmcsService $whmcs )
    {
        dd($request->all());
        $invoiceid = $request->invoiceid;

        // dd($invoiceid);

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
        $paymethodMethods = $paymentMethodApi['paymentmethods']['paymentmethod']?? [];






        return view('backend.client.invoices.invoicedetails',compact('invoice','client','paymethodMethods'));
    }

}
