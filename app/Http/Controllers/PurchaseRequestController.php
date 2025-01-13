<?php

namespace App\Http\Controllers;

use App\Department;
use App\Models\User;
use App\PurchaseItem;
use App\PurchaseRequest;
use App\PurchaseRequestFile;
use App\Subsidiary;
use App\Vendor;
use App\VendorContact;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = User::where('status','Active')->pluck('name','id');
        $purchase_requests = PurchaseRequest::with('user','department','assignedTo')
            ->when($start_date || $end_date, function($query) use ($start_date,$end_date){
                $query->whereBetween('created_at',[$start_date.' 00:00:01',$end_date.' 23:59:59']);
            })
            ->paginate(10);
        $get_pr_no = PurchaseRequest::orderBy('id','desc')->first();
        
        return view('purchased_request', compact('users','purchase_requests','get_pr_no','start_date','end_date'));
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
        $purchase_request = new PurchaseRequest;
        $purchase_request->due_date = $request->requestDueDate;
        $purchase_request->user_id = $request->requestor_name;
        $purchase_request->assigned_to = $request->assigned_to;
        $purchase_request->subsidiary = $request->subsidiary;
        $purchase_request->status = 'Pending';
        $purchase_request->department_id = $request->department;
        $purchase_request->remarks = $request->remarks;
        $purchase_request->save();

        foreach($request->item_code as $key=>$item_code)
        {
            $purchase_item = new PurchaseItem;
            $purchase_item->purchase_request_id = $purchase_request->id;
            $purchase_item->item_code = $item_code;
            $purchase_item->item_category = $request->item_category[$key];
            $purchase_item->item_description = $request->item_description[$key];
            $purchase_item->item_quantity = $request->item_quantity[$key];
            $purchase_item->unit_of_measurement = $request->unit_of_measurement[$key];
            $purchase_item->save();
        }

        if ($request->has('attachments'))
        {
            $attachments = $request->file('attachments');
            foreach($attachments as $attachment)
            {
                $name = time().'_'.$attachment->getClientOriginalName();
                $extention = $attachment->getClientOriginalExtension();
                $attachment->move(public_path('purchase_request_files'),$name);
    
                $file_name = '/purchase_request_files/'.$name;
                
                $purchase_request_file = new PurchaseRequestFile;
                $purchase_request_file->purchase_request_id = $purchase_request->id;
                $purchase_request_file->document_type = $extention;
                $purchase_request_file->file = $file_name;
                $purchase_request_file->save();
            }
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
        $purchase_requests = PurchaseRequest::with('user','department','assignedTo','purchaseItems','purchaseRequestFiles')->findOrFail($id);
        $users = User::where('status','Active')->pluck('name','id');
        $vendor_list = Vendor::pluck('vendor_name','id');

        return view('purchase_request.view_purchase_request', compact('purchase_requests','users','vendor_list'));
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
        // dd($request->all(), $id);
        $purchase_request = PurchaseRequest::findOrFail($id);
        $purchase_request->due_date = $request->requestDueDate;
        $purchase_request->user_id = $request->requestor_name;
        // $purchase_request->assigned_to = $request->assigned_to;
        $purchase_request->subsidiary = $request->subsidiary;
        $purchase_request->status = 'Pending';
        $purchase_request->department_id = $request->department;
        $purchase_request->remarks = $request->remarks;
        $purchase_request->save();

        $purchase_item = PurchaseItem::where('purchase_request_id', $id)->delete();
        foreach($request->item_code as $key=>$item_code)
        {
            $purchase_item = new PurchaseItem;
            $purchase_item->purchase_request_id = $id;
            $purchase_item->item_code = $item_code;
            $purchase_item->item_category = $request->item_category[$key];
            $purchase_item->item_description = $request->item_description[$key];
            $purchase_item->item_quantity = $request->item_quantity[$key];
            $purchase_item->unit_of_measurement = $request->unit_of_measurement[$key];
            $purchase_item->save();
        }

        if ($request->has('attachments'))
        {
            $attachments = $request->file('attachments');
            foreach($attachments as $attachment)
            {
                $name = time().'_'.$attachment->getClientOriginalName();
                $extention = $attachment->getClientOriginalExtension();
                $attachment->move(public_path('purchase_request_files'),$name);

                $file_name = '/purchase_request_files/'.$name;
                
                $purchase_request_file = new PurchaseRequestFile;
                $purchase_request_file->purchase_request_id = $id;
                $purchase_request_file->document_type = $extention;
                $purchase_request_file->file = $file_name;
                $purchase_request_file->save();
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

    public function updateFiles(Request $request,$id)
    {
        $file = $request->file('file');
        $name = time().'_'.$file->getClientOriginalName();
        $extention = $file->getClientOriginalExtension();
        $file->move(public_path('purchase_request_files'),$name);
        
        $pr_files = PurchaseRequestFile::findOrFail($id);
        $pr_files->document_type = $extention;
        $pr_files->file = '/purchase_request_files/'.$name;
        $pr_files->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
    }

    public function deleteFiles(Request $request,$id)
    {
        // dd($request->all(),$id);
        $pr_files = PurchaseRequestFile::findOrFail($id);
        $pr_files->delete();

        Alert::success('Successfully Deleted')->persistent('Dismiss');
        return back();
    }

    public function editAssigned(Request $request,$id)
    {
        // dd($request->all(),$id);
        $purchase_request = PurchaseRequest::findOrFail($id);
        $purchase_request->assigned_to = $request->assigned_to;
        $purchase_request->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
    }

    public function refreshVendorEmail(Request $request)
    {
        $vendor_contact = VendorContact::where('vendor_id', $request->vendor_id)->get()->pluck('work_email')->toArray();
        
        return $vendor_contact;
    }

    public function return(Request $request,$id)
    {
        $purchase_request = PurchaseRequest::findOrFail($id);
        $purchase_request->return_remarks = $request->remarks;
        // $purchase_request->status = 'Returned';
        $purchase_request->save();

        Alert::success('Successfully Returned')->persistent('Dismiss');
        return back();
    }
}
