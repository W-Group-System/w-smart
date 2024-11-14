<?php

namespace App\Http\Controllers;

use App\User;
use App\Subsidiary;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        try {
            $company = Subsidiary::all();
            return response()->json([
                'status' => 'success',
                'data' => $company,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve company.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createCompany(Request $request)
    {
        $newCompany = new Subsidiary();
        $newCompany->subsidiary_name = $request->subsidiary;
        $newCompany->save();

        return response()->json(['message' => 'Company registered successfully'], 201);
    }
}
