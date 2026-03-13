<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\WhmcsService;
use Illuminate\Http\Request;

class DomainRegistrationCOntroller extends Controller
{

    public function domainRegistration( WhmcsService $whmcs)
    {
        $resp = $whmcs->call('GetClientsDomains', [
            'limitstart' => 0,
            'limitnum'   => 25,
        ]);

        $domains = $resp['domains']['domain'] ?? [];

        foreach ($domains as $key => $d) {

            // Client Details
            $userDetails = $whmcs->call('GetClientsDetails', [
                'clientid' => $d['userid'],
            ]);

            $domains[$key]['client'] = $userDetails['client'] ?? [];


            // Order Details
            $orderDetails = $whmcs->call('GetOrders', [
                'id' => $d['orderid'],
            ]);

            $domains[$key]['order'] = $orderDetails['orders']['order'][0] ?? [];
        }

        $mainDomains = collect($domains)
                        ->sortByDesc('id')
                        ->values();

        // dd($domains);

        return view('backend.client.domainregistrations.index', compact('mainDomains'));

    }
}
