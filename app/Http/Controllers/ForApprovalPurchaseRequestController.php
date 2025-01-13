<?php

namespace App\Http\Controllers;

use App\PurchaseRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ForApprovalPurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $purchase_requests = PurchaseRequest::where('status', 'Pending')->paginate(10);

        return view('purchase_request.for_approval', compact('start_date','end_date','purchase_requests'));
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
        //
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
        $purchase_requests = PurchaseRequest::findOrFail($id);
        
        if ($request->action == 'Approved')
        {
            $purchase_requests->status = 'For RFQ';
            Alert::success('Successfully Approved')->persistent('Dismiss');
        }
        elseif($request->action == 'Returned')
        {
            $purchase_requests->status = 'Returned';
            Alert::success('Successfully Returned')->persistent('Dismiss');
        }

        $purchase_requests->save();

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
