<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->has('role')) {
                $role = $request->input('role');
                $users = User::where('role', $role)->get();
            } else {
                $users = User::all();
            }

            return response()->json([
                'status' => 'success',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve users.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|integer',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        $user->role = $request->input('role');
        $user->save();

        // Return a success response with the updated user
        return response()->json([
            'status' => 'success',
            'message' => 'User role updated successfully.',
            'data' => $user
        ]);
    }
    public function getUserSuggestions(Request $request)
    {
        try {
            $searchTerm = $request->input('searchTerm');

            $users = User::where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->leftJoin('roles', 'users.role', '=', 'roles.id')  
                ->select('users.id', 'users.name', 'users.email', 'users.role as role_id', 'roles.role as role_name') 
                ->limit(10)
                ->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No users found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch users.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function updateUser(Request $request, $id)
    {

        // Validate incoming request data
/*        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed', 
            'subsidiary' => 'required|string|max:255', 
            'subsidiaryid' => 'required|string|max:255', 
        ]);*/

        // Find the user by ID
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        // Update the user's details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->subsidiary = $request->input('subsidiary');
        $user->subsidiaryid = $request->input('subsidiaryid');

        if ($request->has('password') && $request->input('password') !== null) {
            $user->password = Hash::make($request->input('password'));
        }

        // Save the updated user
        $user->save();

        // Return a success response with the updated user data
        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
        ]);
    }

    public function deleteUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        // Delete the user
        $user->delete();

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
        ]);
    }
}
