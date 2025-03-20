<?php

namespace App\Http\Controllers;

use App\Features;
use App\Models\User;
use App\Roles;
use App\Subfeatures;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::with('permission','permission.feature')->get();
        $features = Features::get();
        $subfeatures = Subfeatures::get();
        $employees = User::whereNull('status')->get();

        return view('settings_role', compact('roles','features','employees', 'subfeatures'));
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
        dd($request->all());
        // $role = new Roles();
        // $role->role = $request->role;
        // $role->save();

        // foreach($request->permission as $key=>$permission)
        // {
        //     $role_permission = new Permissions();
        //     $role_permission->roleid = $role->id;
        //     $role_permission->role = $role->role;
        //     $role_permission->featureid = $permission;
        //     $role_permission->save();
        // }

        // Alert::success('Successfully Saved')->persistent('Dismiss');
        // return back();
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
