<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;
use Illuminate\Support\Facades\Log;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $searchTerm = $request->input('search');
            $subsidiary = $request->input('subsidiary');
            $perPage = $request->input('per_page', 10);

            $query = Equipment::query();

            if ($searchTerm) {
                $query->where('asset_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('asset_code', 'LIKE', '%' . $searchTerm . '%');
            }

            if ($subsidiary) {
                $query->where('subsidiaryid', $subsidiary);
            }

            $equipment = $query->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => $equipment->items(),
                'pagination' => [
                    'current_page' => $equipment->currentPage(),
                    'total_pages' => $equipment->lastPage(),
                    'total_items' => $equipment->total(),
                    'per_page' => $equipment->perPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Failed to fetch equipment: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch equipment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createEquipment(Request $request)
    {
        try {
            $request->validate([
                'asset_name' => 'required|string|max:255',
                'asset_code' => 'required|string|max:100|unique:equipments',
                'date_purchased' => 'required|date',
                'date_acquired' => 'required|date',
                'type' => 'required|string|max:100',
                'status' => 'required|string|max:255',
                'subsidiary' => 'required|string|max:255',
                'subsidiary_id' => 'required|integer',
                'asset_value' => 'required|numeric|min:0',
            ]);

            $equipment = new Equipment();
            $equipment->asset_name = $request->asset_name;
            $equipment->asset_code = $request->asset_code;
            $equipment->date_purchased = $request->date_purchased;
            $equipment->date_acquired = $request->date_acquired;
            $equipment->date_installation = $request->date_installation;
            $equipment->date_transferred = $request->date_transferred;
            $equipment->date_repaired = $request->date_repaired;
            $equipment->type = $request->type;
            $equipment->location = $request->location;
            $equipment->category = "Equipments";
            $equipment->category_id = 9;
            $equipment->subcategory = $request->subcategory;
            $equipment->subcategory_id = $request->subcategory_id;
            $equipment->status = $request->status;
            $equipment->subsidiary = $request->subsidiary;
            $equipment->subsidiaryid = $request->subsidiary_id;
            $equipment->remarks = $request->remarks;
            $equipment->assigned_to = $request->assigned_to;
            $equipment->estimated_useful_life = $request->estimated_useful_life;
            $equipment->serial_number = $request->serial_number;
            $equipment->equipment_model = $request->equipment_model;
            $equipment->warranty = $request->warranty;
            $equipment->po_number = $request->po_number;
            $equipment->brand = $request->brand;
            $equipment->specifications = $request->specifications;
            $equipment->asset_value = $request->asset_value;
            $equipment->item_code = $request->item_code;
            $equipment->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Equipment created successfully.',
                'data' => $equipment,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create equipment: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create equipment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
