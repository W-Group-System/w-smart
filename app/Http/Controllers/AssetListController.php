<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Equipment;
use App\Subsidiary;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AssetListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subsidiaries = Subsidiary::get();
        $categories = Categories::get();
        $equipments = Equipment::with('subsidiary', 'category')->get();

        return view('equipment_list', compact('subsidiaries','categories','equipments'));
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
        $equipment = new Equipment();
        $equipment->date_purchased = $request->date_purchased;
        $equipment->date_installation = $request->date_installation;
        $equipment->date_acquired = $request->date_acquired;
        $equipment->date_transferred = $request->date_transferred;
        $equipment->date_repaired = $request->date_repaired;
        $equipment->asset_code = $request->asset_code;
        $equipment->asset_name = $request->asset_name;
        $equipment->category_id = $request->category;
        $equipment->subsidiary_id = $request->subsidiary;
        $equipment->location = $request->location;
        $equipment->estimated_useful_life = $request->estimated_useful_life;
        $equipment->type = $request->type;
        $equipment->status = $request->status;
        $equipment->remarks = $request->remarks;
        $equipment->assigned_to = $request->assigned_to;
        $equipment->serial_number = $request->serial_number;
        $equipment->equipment_model = $request->equipment_model;
        $equipment->warranty = $request->warranty;
        $equipment->po_number = $request->po_number;
        $equipment->brand = $request->brand;
        $equipment->specifications = $request->specifications;
        $equipment->asset_value = $request->asset_value;
        $equipment->item_code = $request->item_code;
        
        $file = $request->file('photo');
        $name = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('asset_photo'), $name);
        $file_name = '/asset_photo/'.$name;

        $equipment->photo = $file_name;
        $equipment->save();

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
        $equipment = Equipment::findOrFail($id);

        return view('asset_list.view_asset_list', compact('equipment'));
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
        $equipment = Equipment::findOrFail($id);
        $equipment->date_purchased = $request->date_purchased;
        $equipment->date_installation = $request->date_installation;
        $equipment->date_acquired = $request->date_acquired;
        $equipment->date_transferred = $request->date_transferred;
        $equipment->date_repaired = $request->date_repaired;
        $equipment->asset_code = $request->asset_code;
        $equipment->asset_name = $request->asset_name;
        $equipment->category_id = $request->category;
        $equipment->subsidiary_id = $request->subsidiary;
        $equipment->location = $request->location;
        $equipment->estimated_useful_life = $request->estimated_useful_life;
        $equipment->type = $request->type;
        $equipment->status = $request->status;
        $equipment->remarks = $request->remarks;
        $equipment->assigned_to = $request->assigned_to;
        $equipment->serial_number = $request->serial_number;
        $equipment->equipment_model = $request->equipment_model;
        $equipment->warranty = $request->warranty;
        $equipment->po_number = $request->po_number;
        $equipment->brand = $request->brand;
        $equipment->specifications = $request->specifications;
        $equipment->asset_value = $request->asset_value;
        $equipment->item_code = $request->item_code;
        
        if ($request->has('photo'))
        {
            $file = $request->file('photo');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('asset_photo'), $name);
            $file_name = '/asset_photo/'.$name;

            $equipment->photo = $file_name;
        }

        $equipment->save();

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
}
