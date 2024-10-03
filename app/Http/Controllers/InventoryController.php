<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Inventory;
use App\Subsidiary;
use RealRashid\SweetAlert\Facades\Alert;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $subsidiary = $request->subsidiary;
            $subsidiaryid = $request->subsidiaryid;
            $searchTerm = $request->search;

            $perPage = $request->get('per_page', 10);

            $query = Inventory::query();

            // Apply date range filter if provided
            if ($startDate && $endDate) {
                $query->where('subsidiaryid', $subsidiaryid)
                      ->whereBetween('date', [$startDate, $endDate]);
            }

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('item_description', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('item_code', 'LIKE', '%' . $searchTerm . '%');
                });
            }

            $inventory = $query->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => $inventory->items(),
                'pagination' => [
                    'current_page' => $inventory->currentPage(),
                    'total_pages' => $inventory->lastPage(),
                    'total_items' => $inventory->total(),
                    'per_page' => $inventory->perPage(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch inventory.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
   	public function getSubsidiary(Request $request)
   	{
        try {
        $subsidiary = Subsidiary::all();

        return response()->json([
            'status' => 'success',
            'data' => $subsidiary,
        ], 200);
	    } catch (\Exception $e) {
	        return response()->json([
	            'status' => 'error',
	            'message' => 'Failed to fetch permissions.',
	            'error' => $e->getMessage(),
	        ], 500); 
	    }
   	}
   	public function createInventory(Request $request)
   	{
      	try {
           	$request->validate([
               'date' => 'required|date',
               'item_code' => 'required|string|max:100',
               'item_description' => 'required|string|max:255',
               'item_category' => 'required|string|max:100',
               'uom' => 'required|string|max:10',
               'qty' => 'required|numeric|min:0',
               'cost' => 'required|numeric|min:0',
               'usage' => 'required|numeric|min:0',
               'subsidiary' => 'required|string|max:100',
               'subsidiaryid' => 'required|numeric|min:0',
           	]);

           	$new_inventory = new Inventory();
           	$new_inventory->date = $request->date; 
           	$new_inventory->item_code = $request->item_code; 
           	$new_inventory->item_description = $request->item_description; 
           	$new_inventory->item_category = $request->item_category; 
           	$new_inventory->uom = $request->uom; 
           	$new_inventory->qty = $request->qty; 
           	$new_inventory->cost = $request->cost; 
           	$new_inventory->usage = $request->usage; 
            $new_inventory->subsidiaryid = $request->subsidiaryid; 
            $new_inventory->subsidiary = $request->subsidiary; 
           	$new_inventory->save();
           	return response()->json([
               'status' => 'success',
               'data' => $new_inventory,
           	], 201);
       	} catch (\Exception $e) {
           	Log::error('Failed to create inventory: ' . $e->getMessage());
           	return response()->json([
               'status' => 'error',
               'message' => 'Failed to create inventory.',
               'error' => $e->getMessage(),
           	], 500);
       	}
   	}
    public function search(Request $request)
    {
        $searchTerm = $request->search;
        $perPage = $request->get('per_page', 10);
        $subsidiaryid = $request->subsidiaryid;
        try {
            $query = Inventory::query();
            $query->where('subsidiaryid', $subsidiaryid)->where(function ($q) use ($searchTerm) {
                $q->where('item_description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('item_code', 'LIKE', '%' . $searchTerm . '%');
            });

            $inventory = $query->paginate($perPage);
            return response()->json([
                'status' => 'success',
                'data' => $inventory->items(),
                'pagination' => [
                   'current_page' => $inventory->currentPage(),
                   'total_pages' => $inventory->lastPage(),
                   'total_items' => $inventory->total(),
                   'per_page' => $inventory->perPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch permissions.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }
}
