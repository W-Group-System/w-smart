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
}
