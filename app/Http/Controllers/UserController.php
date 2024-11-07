<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;

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
}
