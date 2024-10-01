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
            ], 200);
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
            ], 200);
        } catch (\Exception $e) {
            Log::error('Failed to create permission: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create permission.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function delete(Request $request)
    {

       try {
           // Find the user by the provided user_id
           $user = User::findOrFail($request->id);

           // Find the current role of the user
           $role = Roles::find($user->role);

           // Update the user's role to the new_role_id
           $user->role = $request->newrole;
           $user->save();

           // Delete the old role
           if ($role) {
               $role->delete();
           }

           // Success response
           return response()->json([
               'status' => 'success',
               'message' => 'Role deleted successfully',
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           // Catch case where the user is not found
           return response()->json([
               'status' => 'error',
               'message' => 'User not found.',
               'error' => $e->getMessage(),
            ], 404);

        } catch (\Exception $e) {
           // Catch any other general exception
            return response()->json([
               'status' => 'error',
               'message' => 'Failed to delete role.',
               'error' => $e->getMessage(),
            ], 500);
       }
    }

}
