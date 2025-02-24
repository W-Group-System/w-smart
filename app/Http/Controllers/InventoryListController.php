<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventoryListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::with('uom')->get();

        return view('inventory_list', compact('inventories'));
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
        // dd($request->all());
        $inventory = new Inventory();
        $inventory->item_code = $request->item_code;
        $inventory->item_description = $request->item_description;
        $inventory->subsidiary = $request->subsidiary;
        $inventory->uomp = $request->primary_uom;
        $inventory->uoms = $request->secondary_uom;
        $inventory->uomt = $request->tertiary_uom;
        $inventory->cost = $request->cost;
        $inventory->qty = $request->quantity;
        $inventory->remarks = $request->remarks;
        $inventory->usage = $request->usage;
        $inventory->save();

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
