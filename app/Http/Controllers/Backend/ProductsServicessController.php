<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\WhmcsService;
use Illuminate\Http\Request;

class ProductsServicessController extends Controller
{
    public function getSharedHostings(WhmcsService $whmcs)
    {
        $resp = $whmcs->call('GetClientsProducts', [
            'limitstart' => 0,
            'limitnum'   => 200,
            'serviceid'  => '',
        ]);

        $products = $resp['products']['product'] ?? [];

        $products = collect($resp['products']['product'] ?? [])
            ->sortByDesc('id')
            ->values()
            ->toArray();
        $productCache = [];
        $sharedProducts = [];

        foreach ($products as $key => $p) {
            $pid = $p['pid'] ?? null;

            if (!$pid) {
                continue;
            }

            if (!isset($productCache[$pid])) {
                $productDetails = $whmcs->call('GetProducts', [
                    'pid' => $pid,
                ]);

                $productCache[$pid] = $productDetails['products']['product'][0] ?? null;
            }

            $p['product_details'] = $productCache[$pid];

            if (($p['product_details']['type'] ?? '') === 'hostingaccount') {
                $sharedProducts[] = $p;
            }
        }
        // dd($sharedProducts);

        return view('backend.client.productservices.sharedhostings.index', [
            'products' => $sharedProducts
        ]);
    }
}
