<?php

namespace App\Http\Controllers;

use App\ItemApprover;
use App\Models\User;
use App\PurchaseApprover;
use App\Subsidiary;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseApproverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $approvers = User::where('status', null)->get();
        $subsidiaries = Subsidiary::get();

        $purchase_approvers = PurchaseApprover::get();
        $item_approvers = ItemApprover::get();

        return view('purchase_approver.index', compact('approvers', 'purchase_approvers', 'subsidiaries', 'item_approvers'));
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
        $purchase_approver = PurchaseApprover::query()->delete();

        foreach($request->approver as $key=>$approver)
        {
            $purchase_approver = new PurchaseApprover();
            $purchase_approver->user_id = $approver;
            $purchase_approver->level = $key+1;
            $purchase_approver->save();
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

    public function storeItemApprover(Request $request)
    {
        // dd($request->all());
        foreach($request->employee as $key=>$employee)
        {
            $item_approver = new ItemApprover;
            $item_approver->user_id = $employee;
            $item_approver->level = $key+1;
            $item_approver->subsidiary_id = $request->subsidiary;
            $item_approver->save();
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }
}
