<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\WhmcsService;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    public function userList(WhmcsService $whmcs)
    {

        $resp = $whmcs->call('GetAdminUsers', [
            'limitstart' => 0,
            'limitnum'   => 50,
        ]);
        // dd($resp);

        $users = $resp['admin_users'];

        // dd($users);

        return view('backend.client.masageusers.index',compact('users'));

    }
}
