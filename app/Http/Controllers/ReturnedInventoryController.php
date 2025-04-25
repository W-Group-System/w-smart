<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\ReturnItem;
use App\Returns;
use App\Uoms;
use App\WithdrawalItems;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReturnedInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returned_inventories = Returns::with('requestor','subsidiary','uom')->get();
        
        return view('inventory_returned', compact('returned_inventories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uoms = Uoms::get();
        // $inventories = Inventory::where('status',null)->get();
        $withdrawal_items = WithdrawalItems::with('inventory', 'uom')->get()->unique('inventory_id');
        
        return view('returned_inventory.new_return_inventory', compact('uoms', 'withdrawal_items'));
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
        $returned_inventory = new Returns;
        $returned_inventory->requestor_id = $request->request_name;
        $returned_inventory->subsidiary_id = $request->subsidiary;
        $returned_inventory->remarks = $request->remarks;
        $returned_inventory->status = 'Pending';
        $returned_inventory->save();

        foreach($request->item as $key => $item)
        {
            $withdrawals_items = new ReturnItem;
            $withdrawals_items->return_id = $returned_inventory->id;
            $withdrawals_items->inventory_id = $item;
            $withdrawals_items->uom_id = $request->uom[$key];
            $withdrawals_items->reason = $request->reason[$key];
            $withdrawals_items->request_qty = $request->requestQty[$key];
            $withdrawals_items->save();

            $inventory = Inventory::where('inventory_id', $item)->first();
            $inventory->qty = (float)$inventory->qty + (float)$request->requestQty[$key];
            $inventory->save();
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return redirect('inventory/returned');
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

    public function refreshWithdrawalInventory(Request $request)
    {
        // dd($request->all());
        $total_withdrawal_qty = WithdrawalItems::with('inventory')->where('inventory_id', $request->id)->pluck('request_qty')->sum();
        $total_returned_qty = ReturnItem::where('inventory_id', $request->id)->pluck('request_qty')->sum();

        $qty = $total_withdrawal_qty - $total_returned_qty;
        
        $inventories = Inventory::with('category')->where('inventory_id', $request->id)->first();
        
        return response()->json([
            'qty' => $qty,
            'inventories' => $inventories,
            'category' => $inventories->category
        ]);
    }
}
