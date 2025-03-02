<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\TransferAsset;
use App\TransferAssetFile;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TransferAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfer_assets = TransferAsset::get();

        return view('equipment_transfer', compact('transfer_assets'));
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
        $transfer_asset = new TransferAsset();
        $transfer_asset->transfer_from = $request->transfer_from;
        $transfer_asset->transfer_to = $request->transfer_to;
        $transfer_asset->transfer_from_name = $request->transfer_from_name;
        $transfer_asset->transfer_to_name = $request->transfer_to_name;
        $transfer_asset->purpose = $request->purpose;
        $transfer_asset->date_of_transfer = $request->date_of_transfer;
        $transfer_asset->asset_name = $request->asset_name;
        $transfer_asset->asset_code = $request->asset_code;
        $transfer_asset->remarks = $request->remarks;
        $transfer_asset->requested_by = auth()->user()->id;
        $transfer_asset->save();

        $transfer_asset_files = $request->file('files');
        foreach($transfer_asset_files as $file)
        {
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('transfer_asset_files'), $name);
            $file_name = '/transfer_asset_files/'.$name;

            $transfer_asset_file = new TransferAssetFile();
            $transfer_asset_file->transfer_asset_id = $transfer_asset->id;
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
        $transfer_asset = TransferAsset::findOrFail($id);
        $transfer_asset->transfer_from = $request->transfer_from;
        $transfer_asset->transfer_to = $request->transfer_to;
        $transfer_asset->transfer_from_name = $request->transfer_from_name;
        $transfer_asset->transfer_to_name = $request->transfer_to_name;
        $transfer_asset->purpose = $request->purpose;
        $transfer_asset->date_of_transfer = $request->date_of_transfer;
        $transfer_asset->asset_name = $request->asset_name;
        $transfer_asset->asset_code = $request->asset_code;
        $transfer_asset->remarks = $request->remarks;
        $transfer_asset->save();

        if ($request->has('files'))
        {
            $transfer_asset_files = $request->file('files');
            $transfer_asset_file = TransferAssetFile::where('transfer_asset_id', $id)->delete();
            foreach($transfer_asset_files as $file)
            {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('transfer_asset_files'), $name);
                $file_name = '/transfer_asset_files/'.$name;
    
                $transfer_asset_file = new TransferAssetFile();
                $transfer_asset_file->transfer_asset_id = $transfer_asset->id;
                $transfer_asset_file->file = $file_name;
                $transfer_asset_file->save();
            }
        }

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
