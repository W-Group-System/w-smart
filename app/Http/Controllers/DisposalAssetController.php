<?php

namespace App\Http\Controllers;

use App\DisposalAsset;
use App\DisposalAssetFile;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DisposalAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disposal_assets = DisposalAsset::get();

        return view('equipment_disposal', compact('disposal_assets'));
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
        $equipment_disposal = new DisposalAsset();
        $equipment_disposal->transfer_from = $request->transfer_from;
        $equipment_disposal->transfer_to = $request->transfer_to;
        $equipment_disposal->purpose = $request->purpose;
        $equipment_disposal->date_of_transfer = $request->date_of_transfer;
        $equipment_disposal->asset_name = $request->asset_name;
        $equipment_disposal->asset_code = $request->asset_code;
        $equipment_disposal->remarks = $request->remarks;
        $equipment_disposal->requested_by = auth()->user()->id;
        $equipment_disposal->save();

        $equipment_disposal_files = $request->file('files');
        foreach($equipment_disposal_files as $file)
        {
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('disposal_asset_files'), $name);
            $file_name = '/disposal_asset_files/'.$name;

            $transfer_asset_file = new DisposalAssetFile();
            $transfer_asset_file->disposal_asset_id = $equipment_disposal->id;
            $transfer_asset_file->file = $file_name;
            $transfer_asset_file->save();
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
