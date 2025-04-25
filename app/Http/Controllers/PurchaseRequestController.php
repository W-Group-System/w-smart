<?php

namespace App\Http\Controllers;

use App\Classification;
use App\Department;
use App\EstimatedTotalAmount;
use App\Inventory;
use App\Models\User;
use App\PurchaseApprover;
use App\PurchaseItem;
use App\PurchaseRequest;
use App\PurchaseRequestApprover;
use App\PurchaseRequestFile;
use App\Subsidiary;
use App\SupplierAccreditation;
use App\Uoms;
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

        // Dropdown
        $users = User::where('status','Active')->pluck('name','id');
        $inventory_list = Inventory::where('status',null)->get();

        $purchase_requests = PurchaseRequest::with('user','department','assignedTo')
            ->when($start_date || $end_date, function($query) use ($start_date,$end_date){
                $query->whereBetween('created_at',[$start_date.' 00:00:01',$end_date.' 23:59:59']);
            })
            // ->paginate(10);
            ->get();
        $get_pr_no = PurchaseRequest::orderBy('id','desc')->first();

        return view('purchased_request', compact('users','purchase_requests','get_pr_no','start_date','end_date','inventory_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventory_list = Inventory::where('status',null)->get();
        $classifications = Classification::where('status', null)->get();
        $purchase_approvers = PurchaseApprover::orderBy('level','asc')->get();
        $uoms = Uoms::get();

        return view('purchase_request.new_purchase_request', compact('inventory_list', 'classifications', 'purchase_approvers', 'uoms'));
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
        $purchase_request->classification_id = $request->classification;
        $purchase_request->save();

        foreach($request->inventory_id as $key=>$inventory)
        {
            $purchase_item = new PurchaseItem;
            $purchase_item->purchase_request_id = $purchase_request->id;
            $purchase_item->inventory_id = $inventory;
            $purchase_item->unit_of_measurement = $request->unit_of_measurement[$key];
            $purchase_item->estimated_amount = $request->estimated_amount[$key];
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

        $purchase_approvers = PurchaseApprover::orderBy('level','asc')->get();
        foreach($purchase_approvers as $key=>$purchase_approver)
        {
            $pr_approver = new PurchaseRequestApprover();
            $pr_approver->purchase_request_id = $purchase_request->id;
            $pr_approver->user_id = $purchase_approver->user_id;
            $pr_approver->level = $purchase_approver->level;
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

        $get_qty = Inventory::whereIn('inventory_id', $request->inventory_id)->get()->pluck('qty')->toArray();
        $estimated_amount = $request->estimated_amount;

        $total_array = [];
        foreach($estimated_amount as $key=>$est_amt)
        {
            $total_array[] = $est_amt * $get_qty[$key];
        }
        $total = collect($total_array)->sum();
        
        $estimated_amount = new EstimatedTotalAmount;
        $estimated_amount->total_amount = $total;
        $estimated_amount->purchase_request_id = $purchase_request->id;
        $estimated_amount->save();

        Alert::success('Successfully Saved')->persistent('Dismiss');
        // return back();

        return redirect('procurement/purchase-request');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase_request = PurchaseRequest::with('user','department','assignedTo','purchaseItems','purchaseRequestFiles', 'purchaseRequestApprovers')->findOrFail($id);
        $users = User::where('status',null)->get();
        $suppliers = SupplierAccreditation::get();
        
        return view('purchase_request.view_purchase_request', compact('purchase_request','users','suppliers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase_request = PurchaseRequest::with('user','department','assignedTo','purchaseItems','purchaseRequestFiles', 'purchaseRequestApprovers')->findOrFail($id);
        $inventory_list = Inventory::where('status',null)->get();
        $classifications = Classification::where('status', null)->get();
        $purchase_approvers = PurchaseApprover::orderBy('level','asc')->get();
        $uoms = Uoms::get();
        
        return view('purchase_request.edit_purchase_request',compact('purchase_request','inventory_list','classifications','purchase_approvers', 'uoms'));
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
        $purchase_request->classification_id = $request->classification;
        $purchase_request->save();

        if ($request->has('inventory_id'))
        {
            $purchase_item = PurchaseItem::where('purchase_request_id', $id)->delete();
            foreach($request->inventory_id as $key=>$inventory)
            {
                $purchase_item = new PurchaseItem;
                $purchase_item->purchase_request_id = $purchase_request->id;
                $purchase_item->inventory_id = $inventory;
                $purchase_item->unit_of_measurement = $request->unit_of_measurement[$key];
                $purchase_item->save();
            }
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

        $purchase_request_approvers = PurchaseRequestApprover::orderBy('level','asc')->first();
        $purchase_request_approvers->status = 'Pending';
        $purchase_request_approvers->save();

        $get_qty = Inventory::whereIn('inventory_id', $request->inventory_id)->get()->pluck('qty')->toArray();
        $estimated_amount = $request->estimated_amount;

        $total_array = [];
        foreach($estimated_amount as $key=>$est_amt)
        {
            $total_array[] = $est_amt * $get_qty[$key];
        }
        $total = collect($total_array)->sum();

        $estimated_amount = EstimatedTotalAmount::where('purchase_request_id', $id)->first();
        $estimated_amount->total_amount = $total;
        // $estimated_amount->purchase_request_id = $purchase_request->id;
        $estimated_amount->save();


        Alert::success('Successfully Updated')->persistent('Dismiss');
        return redirect('procurement/purchase-request');
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
        $suppliers = SupplierAccreditation::where('id', $request->vendor_id)->get();
        
        return $suppliers;
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

    public function refreshInventory(Request $request)
    {
        $inventory = Inventory::with('category')->findOrFail($request->id);
        
        return response()->json([
            'item_description' => $inventory->item_description,
            'item_code' => $inventory->item_code,
            'qty' => $inventory->qty,
            'category' => $inventory->category,
            'cost' => $inventory->cost
        ]);
    }
}
