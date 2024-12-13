<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoutesController extends Controller
{
    public function settingsRoles()
    {
        return view('settings_role');
    }

    public function inventoryList()
    {
        return view('inventory_list');
    }

    public function inventoryTransfer()
    {
        return view('inventory_transfer');
    }

    public function inventoryWithdrawal()
    {
        return view('inventory_withdrawal');
    }

    public function inventoryReturned()
    {
        return view('inventory_returned');
    }
    public function category()
    {
        return view('category');
    }
    public function uom()
    {
        return view('uom');
    }

    public function equipmentList()
    {
        return view('equipment_list');
    }

    public function equipmentTransfer()
    {
        return view('equipment_transfer');
    }

    public function equipmentDisposal()
    {
        return view('equipment_disposal');
    }
    public function userManagement()
    {
        return view('user_management');
    }
    public function companyManagement()
    {
        return view('company');
    }

    public function purchaseRequest()
    {
        return view('purchased_request');
    }
}
