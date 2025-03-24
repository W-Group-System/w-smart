<?php

namespace App\Http\Controllers;

use App\Features;
use App\Models\User;
use App\Roles;
use App\Subfeatures;
use App\UserAccessModule;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::get();
        $features = Features::with('subfeature')->get();
        $employees = User::doesntHave('role_name')->whereNull('status')->get();

        $user_has_roles = User::has('role_name')->whereNull('status')->get();

        return view('settings_role', compact('roles','features','employees', 'user_has_roles'));
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
        $role = new Roles();
        $role->role = $request->role;
        $role->save();

        foreach($request->subfeature as $key=>$subfeature)
        {
            foreach($subfeature as $sub)
            {
                $user_access_modules = new UserAccessModule;
                $user_access_modules->role_id = $role->id;
                $user_access_modules->feature_id = $key;
                $user_access_modules->subfeature_id = $sub;
                $user_access_modules->save();
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
        // dd($request->all(), $id);
        $role = Roles::findOrFail($id);
        $role->role = $request->role;
        $role->save();

        $user_access_modules = UserAccessModule::where('role_id', $id)->delete();
        foreach($request->subfeature as $key=>$subfeature)
        {
            foreach($subfeature as $sub)
            {
                $user_access_modules = new UserAccessModule;
                $user_access_modules->role_id = $role->id;
                $user_access_modules->feature_id = $key;
                $user_access_modules->subfeature_id = $sub;
                $user_access_modules->save();
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

    public function assign(Request $request)
    {
        $user = User::findOrFail($request->employee);
        $user->role = $request->role;
        $user->save();

        Alert::success('Successfully Assigned')->persistent('Dismiss');
        return back();
    }
}
