<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Uoms;
use App\Withdrawal;
use App\WithdrawalItems;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WithdrawalRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Dropdown
        $withdrawals = Withdrawal::with('requestor', 'withdrawalItem')->get();
        
        return view('inventory_withdrawal', compact('withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uoms = Uoms::get();
        $inventories = Inventory::where('status',null)->get();

        return view('withdrawal_request.new_withdrawal_request', compact('inventories', 'uoms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $withdrawals = new Withdrawal;
        $withdrawals->requestor_id = $request->request_name;
        $withdrawals->subsidiary_id = $request->subsidiary;
        $withdrawals->remarks = $request->remarks;
        $withdrawals->status = 'Pending';
        $withdrawals->save();

        foreach($request->item as $key => $item)
        {
            $withdrawals_items = new WithdrawalItems;
            $withdrawals_items->withdrawal_id = $withdrawals->id;
            $withdrawals_items->inventory_id = $item;
            $withdrawals_items->uom_id = $request->uom[$key];
            $withdrawals_items->reason = $request->reason[$key];
            $withdrawals_items->request_qty = $request->requestQty[$key];
            $withdrawals_items->save();

            $inventory = Inventory::where('inventory_id', $item)->first();
            $inventory->qty = (float)$inventory->qty - (float)$request->requestQty[$key];
            $inventory->save();
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return redirect('inventory/withdrawal');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
