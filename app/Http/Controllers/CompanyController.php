<?php

namespace App\Http\Controllers;

use App\User;
use App\Subsidiary;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        // try {
        //     $company = Subsidiary::all();
        //     return response()->json([
        //         'status' => 'success',
        //         'data' => $company,
        //     ], 200);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Failed to retrieve company.',
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }

        $company = Subsidiary::paginate(10);

        return view('company', compact('company'));
    }

    public function createCompany(Request $request)
    {
        $newCompany = new Subsidiary();
        $newCompany->subsidiary_name = $request->subsidiary;
        $newCompany->address = $request->address;
        $newCompany->save();

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    public function update(Request $request,$id)
    {
        $company = Subsidiary::findOrFail($id);
        $company->subsidiary_name = $request->subsidiary;
        $company->address = $request->address;
        $company->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
    }
}
