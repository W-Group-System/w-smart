<?php

namespace App\Http\Controllers;

use App\PurchaseRequest;
use App\RequestForQuotation;
use App\RfqEmail;
use App\RfqFile;
use App\RfqItem;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RequestForQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $purchased_request = PurchaseRequest::findOrFail($request->purchase_request_id);
        $purchased_request->status = 'RFQ';
        $purchased_request->save();

        if ($request->has('vendor_name'))
        {
            RfqEmail::where('purchase_request_id', $request->purchase_request_id)->delete();

            foreach($request->vendor_name as $key=>$vendor_name)
            {
                $rfq = new RfqEmail();
                $rfq->purchase_request_id = $request->purchase_request_id;
                $rfq->vendor_id = $vendor_name;
                $rfq->vendor_email = $request->vendor_email[$key];
                $rfq->save();

                if ($request->has('item_checkbox'))
                {
                    RfqItem::where('purchase_request_id',$request->purchase_request_id)->delete();

                    foreach($request->item_checkbox as $item_checkbox)
                    {
                        $rfq_item = new RfqItem();
                        $rfq_item->purchase_request_id = $request->purchase_request_id;
                        $rfq_item->purchase_item_id = $item_checkbox;
                        $rfq_item->save();
                    }
                }
                else
                {
                    RfqItem::where('purchase_request_id', $request->purchase_request_id)->delete();
                }

                if ($request->has('file_checkbox'))
                {
                    RfqFile::where('purchase_request_id',$request->purchase_request_id)->delete();

                    foreach($request->file_checkbox as $files)
                    {
                        $rfq_file = new RfqFile();
                        $rfq_file->purchase_request_id = $request->purchase_request_id;
                        $rfq_file->purchase_request_file_id = $files;
                        $rfq_file->save();
                    }
                }
                else
                {
                    RfqFile::where('purchase_request_id',$request->purchase_request_id)->delete();
                }
            }
            
            Alert::success('Successfully Saved')->persistent('Dismiss');
            return back();
        }

        
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
