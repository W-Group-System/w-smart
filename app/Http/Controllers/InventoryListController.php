<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Inventory;
use App\Subcategories;
use App\Uoms;
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
        
        // Dropdown
        $categories = Categories::with('subCategory')->get();
        $uoms = Uoms::get();

        return view('inventory_list', compact('inventories','categories','uoms'));
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
        $category = Categories::where('id', $request->category)->first();
        $subcategory = Subcategories::where('id', $request->sub_category)->first();

        $inventory_code = Inventory::orderBy('inventory_id', 'desc')->first();
        $item_code = "";
        if($inventory_code)
        {
            $item_code = str_pad($category->category_series, 2, "0", STR_PAD_LEFT).'-'.str_pad($subcategory->subcategory_series, 3, "0", STR_PAD_LEFT).'-'.str_pad(($inventory_code->inventory_id + 1), 4, "0", STR_PAD_LEFT);
        }
        else
        {
            $item_code = str_pad($category->category_series, 2, "0", STR_PAD_LEFT).'-'.str_pad($subcategory->subcategory_series, 3, "0", STR_PAD_LEFT).'-'."0001";
        }

        $inventory = new Inventory();
        $inventory->item_code = $item_code;
        $inventory->item_description = $request->item_description;
        $inventory->subsidiary = $request->subsidiary;
        // $inventory->uomp = $request->primary_uom;
        // $inventory->uoms = $request->secondary_uom;
        // $inventory->uomt = $request->tertiary_uom;
        $inventory->uom_id = $request->primary_uom;
        $inventory->cost = $request->cost;
        $inventory->qty = $request->quantity;
        $inventory->remarks = $request->remarks;
        $inventory->usage = $request->usage;
        $inventory->category_id = $request->category;
        $inventory->subcategory_id = $request->sub_category;
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
        // dd($request->all(),$id);
        $inventory = Inventory::findOrFail($id);
        // $inventory->item_code = $item_code;
        $inventory->item_description = $request->item_description;
        $inventory->subsidiary = $request->subsidiary;
        // $inventory->uomp = $request->primary_uom;
        // $inventory->uoms = $request->secondary_uom;
        // $inventory->uomt = $request->tertiary_uom;
        $inventory->uom_id = $request->primary_uom;
        $inventory->cost = $request->cost;
        $inventory->qty = $request->quantity;
        $inventory->remarks = $request->remarks;
        $inventory->usage = $request->usage;
        $inventory->category_id = $request->category;
        $inventory->subcategory_id = $request->sub_category;
        $inventory->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
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

    public function refreshSubCategory(Request $request)
    {
        // dd($request->all());
        $subcategories = Subcategories::where('category_id', $request->category_id)->get();
    
        $option = "";
        foreach($subcategories as $subcategory)
        {
            $option .= "<option value=".$subcategory->id.">".$subcategory->name."</option>";
        }

        return $option;
    }

    public function deactivate(Request $request,$id)
    {
        // dd($request->all());
        $subsidiary = Inventory::findOrFail($id);
        $subsidiary->status = 'Inactive';
        $subsidiary->save();

        Alert::success('Successfully Deactivated')->persistent('Dismiss');
        return back();
    }

    public function activate(Request $request,$id)
    {
        // dd($request->all());
        $subsidiary = Inventory::findOrFail($id);
        $subsidiary->status = null;
        $subsidiary->save();

        Alert::success('Successfully Activated')->persistent('Dismiss');
        return back();
    }
}
