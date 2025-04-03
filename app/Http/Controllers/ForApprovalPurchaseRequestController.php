<?php

namespace App\Http\Controllers;

use App\PurchaseOrderApprover;
use App\PurchaseRequest;
use App\PurchaseRequestApprover;
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

        // $purchase_requests = PurchaseRequest::where('status', 'Pending')->get();
        $purchase_request_approval = PurchaseRequestApprover::with('purchase_request')->where('status','Pending')->where('user_id', auth()->user()->id)->get();
        $purchase_order_approval = PurchaseOrderApprover::with('purchaseOrder')->where('status','Pending')->where('user_id', auth()->user()->id)->get();

        return view('purchase_request.for_approval', compact('start_date','end_date','purchase_request_approval', 'purchase_order_approval'));
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
            $purchase_requests_approvers = PurchaseRequestApprover::where('purchase_request_id', $id)->where('status','Pending')->first();
            $purchase_requests_approvers->status = 'Approved';
            $purchase_requests_approvers->save();

            $pr_approvers = PurchaseRequestApprover::where('status', 'Waiting')->orderBy('level','asc')->get();
            if($pr_approvers->isNotEmpty())
            {
                foreach($pr_approvers as $key=>$pr_approver)
                {
                    if ($key == 0)
                    {
                        $pr_approver->status = 'Pending';
                    }
                    else
                    {
                        $pr_approver->status = 'Waiting';
                    }
    
                    $pr_approver->save();
                }
            }
            else
            {
                $purchase_requests->status = 'For RFQ';
            }
            
            Alert::success('Successfully Approved')->persistent('Dismiss');
        }
        elseif($request->action == 'Returned')
        {
            $purchase_requests_approvers = PurchaseRequestApprover::where('purchase_request_id', $id)->whereIn('status',['Pending', 'Approved'])->get();
            foreach($purchase_requests_approvers as $key=>$pr_approver)
            {
                $pr_approver->status = 'Waiting';
                $pr_approver->save();
            }

            $purchase_requests->status = 'Returned';
            $purchase_requests->is_returned = 1;

            Alert::success('Successfully Returned')->persistent('Dismiss');
        }

        $purchase_requests->save();

        return redirect('procurement/for-approval-pr');
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
