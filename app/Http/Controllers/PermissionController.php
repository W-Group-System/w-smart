<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Permissions;
use App\User;
use App\Roles;
use App\Features;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        try {
        $permissions = Permissions::all();

        return response()->json([
            'status' => 'success',
            'data' => $permissions,
        ], 200);
	    } catch (\Exception $e) {
	        return response()->json([
	            'status' => 'error',
	            'message' => 'Failed to fetch permissions.',
	            'error' => $e->getMessage(),
	        ], 500); 
	    }
    }
    public function getFeatures(Request $request)
    {
        try {
        $features = Features::all();

        return response()->json([
            'status' => 'success',
            'data' => $features,
        ], 200);
	    } catch (\Exception $e) {
	        return response()->json([
	            'status' => 'error',
	            'message' => 'Failed to fetch permissions.',
	            'error' => $e->getMessage(),
	        ], 500); 
	    }
    }
    public function getRoles(Request $request)
    {
        try {
	        $roles = Roles::all();

	        return response()->json([
	            'status' => 'success',
	            'data' => $roles,
	        ], 200);
	    } catch (\Exception $e) {
	        return response()->json([
	            'status' => 'error',
	            'message' => 'Failed to fetch permissions.',
	            'error' => $e->getMessage(),
	        ], 500); 
	    }
    }
    public function createRole(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'role' => 'required|string|max:255',
            ]);

            // Create a new role
            $new_role = new Roles();
            $new_role->role = $request->role; 
            $new_role->save();

            return response()->json([
                'status' => 'success',
                'data' => $new_role,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create role: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create role.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function createPermission(Request $request)
    {
        try {
            $request->validate([
            	'roleid' => 'required|integer',
               	'role' => 'required|string|max:100',    
               	'featureid' => 'required|integer', 
               	'feature' => 'required|string|max:100',  
           	]);

            $new_permission = new Permissions();
            $new_permission->roleid = $request->roleid; 
            $new_permission->role = $request->role; 
            $new_permission->featureid = $request->featureid; 
            $new_permission->feature = $request->feature; 
            $new_permission->save();

            return response()->json([
                'status' => 'success',
                'data' => $new_permission,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create permission: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create permission.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function deleteRole($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return Response::json(['message' => 'Role not found'], 404);
        }

        $role->delete();

        return Response::json(['message' => 'Role deleted successfully'], 200);
    }
}
