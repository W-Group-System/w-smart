<?php

namespace App\Http\Controllers;

use App\Department;
use App\Models\User;
use App\Subsidiary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = Department::with('departmentHead')->paginate(10);
        $subsidiary = Subsidiary::get();
        $dept_head = User::where('position','Department Head')->get();

        return view('department', compact('departments','subsidiary','dept_head'));
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
        $department = new Department();
        $department->code = $request->dept_code;
        $department->name = $request->dept_name;
        $department->subsidiary_id = $request->subsidiary;
        // $department->status = 'Active';
        $department->department_head = $request->department_head;
        $department->save();

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
        $department = Department::findOrFail($id);
        $department->code = $request->dept_code;
        $department->name = $request->dept_name;
        $department->subsidiary_id = $request->subsidiary;
        $department->department_head = $request->department_head;
        $department->save();

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

    public function deactive ($id)
    {
        $department = Department::findOrFail($id);
        $department->status = 'Inactive';
        $department->save();

        Alert::success('Successfully Deactivated')->persistent('Dismiss');
        return back();
    }
    
    public function active($id)
    {
        $department = Department::findOrFail($id);
        $department->status = null;
        $department->save();

        Alert::success('Successfully Activated')->persistent('Dismiss');
        return back();
    }
}
