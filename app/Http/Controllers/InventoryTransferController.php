<?php

namespace App\Http\Controllers;

use App\Approver;
use App\Inventory;
use App\InventoryTransfer;
use App\Subsidiary;
use App\Transfer;
use App\TransferApprover;
use App\Uoms;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventoryTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uoms = Uoms::get();
        $inventories = Inventory::get();
        $subsidiaries = Subsidiary::with('approvers')->get();
        $transfers = Transfer::with('transferFrom','transferTo','category')->get();
        
        return view('inventory_transfer', compact('uoms','inventories','subsidiaries','transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transfer = new Transfer();
        $transfer->transfer_from = $request->transfer_from;
        $transfer->transfer_to = $request->transfer_to;
        $transfer->remarks = $request->remarks;
        $transfer->save();

        foreach($request->item_code as $key=>$item_code)
        {
            $inventory_transfer = new InventoryTransfer();
            $inventory_transfer->transfer_id = $transfer->id;
            $inventory_transfer->inventory_id = $item_code;
            $inventory_transfer->uom_id = $request->uom[$key];
            $inventory_transfer->request_qty = $request->request_qty[$key];
            $inventory_transfer->save();
        }
        
        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
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
