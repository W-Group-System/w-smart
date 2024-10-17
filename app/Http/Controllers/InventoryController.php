<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Inventory;
use App\Transfer;
use App\Subsidiary;
use App\Withdrawal;
use App\WithdrawalItems;
use App\Categories;
use App\Subcategories;
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

            if ($startDate && $endDate) {
                // Format the start and end dates
                $startDateTime = date('Y-m-d 00:00:00', strtotime($startDate)); // Start of the day
                $endDateTime = date('Y-m-d 23:59:59', strtotime($endDate)); // End of the day

                $query->where('subsidiaryid', $subsidiaryid)
                      ->where('date', '>=', $startDateTime)
                      ->where('date', '<=', $endDateTime);
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
               'category_id' => 'required|integer',
               'item_category' => 'required|string|max:100',
               'primaryUOM' => 'required|string|max:10',
               'secondaryUOM' => 'required|string|max:10',
               'tertiaryUOM' => 'required|string|max:10',
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
           	$new_inventory->category_id = $request->category_id; 
            $new_inventory->item_category = $request->item_category; 
            $new_inventory->subcategory_id = $request->subcategory_id; 
            $new_inventory->subcategory_name = $request->subcategory_name; 
           	$new_inventory->uomp = $request->primaryUOM; 
            $new_inventory->uoms = $request->secondaryUOM; 
            $new_inventory->uomt = $request->tertiaryUOM; 
           	$new_inventory->qty = $request->qty; 
           	$new_inventory->cost = $request->cost; 
           	$new_inventory->usage = $request->usage; 
            $new_inventory->subsidiaryid = $request->subsidiaryid; 
            $new_inventory->subsidiary = $request->subsidiary; 
            $new_inventory->remarks = $request->remarks; 
           	$new_inventory->save();
           	return response()->json([
               'status' => 'success',
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
    public function searchItem(Request $request)
    {
        $itemCode = $request->query('item_code');
        $subsidiaryId = $request->query('subsidiary_id');

        try {
            $item = Inventory::where('item_code', $itemCode)
                ->where('subsidiaryid', $subsidiaryId)
                ->first();

            if ($item) {
                return response()->json([
                    'status' => 'success',
                    'data' => $item,
                ], 200);
            } else {
                $otherSubsidiaryItem = Inventory::where('item_code', $itemCode)->first();

                if ($otherSubsidiaryItem) {
                    return response()->json([
                        'status' => 'warning',
                        'message' => "ItemCode '{$itemCode}' is found in subsidiary '{$otherSubsidiaryItem->subsidiary}'.",
                        'data' => $otherSubsidiaryItem,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Item not found in any subsidiary.',
                    ], 404);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch item details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchTransfers(Request $request)
    {
        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $subsidiaryid = $request->subsidiaryid;
            $perPage = $request->get('per_page', 10);

            $subsidiary = Subsidiary::where('subsidiary_id', $subsidiaryid)->first();
            $query = Transfer::query();

            Log::info('Fetching transfers with parameters:', [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'subsidiary_id' => $subsidiaryid,
                'subsidiary_name' => $subsidiary ? $subsidiary->subsidiary_name : null,
            ]);

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }

            if ($subsidiary) {
                $query->where('transfer_to', $subsidiary->subsidiary_name);
            } else {
                Log::warning("No subsidiary found for ID: {$subsidiaryid}");
            }

            Log::info('Executing Transfer Query:', [
                'query' => $query->toSql(),
                'bindings' => $query->getBindings(),
            ]);


            $transfers = $query->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => $transfers->items(),
                'pagination' => [
                    'current_page' => $transfers->currentPage(),
                    'total_pages' => $transfers->lastPage(),
                    'total_items' => $transfers->total(),
                    'per_page' => $transfers->perPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch transfer records.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function requestTransfer(Request $request)
    {
        try {
            $request->validate([
                'transact_id' => 'required|string|max:50',
                'items' => 'required|array|min:1',
                'items.*.item_code' => 'required|string|max:50',
                'items.*.qty' => 'required|numeric|min:0.01',
                'transfer_from' => 'required|integer|exists:subsidiaries,subsidiary_id',
                'transfer_to' => 'required|integer|exists:subsidiaries,subsidiary_id|different:transfer_from',
                'remarks' => 'nullable|string|max:255',
                'approver_roles' => 'required|array|min:1',
                'approver_roles.*' => 'integer',
            ]);

            $transactId = $request->transact_id;
            $transferFromId = $request->transfer_from;
            $transferToId = $request->transfer_to;
            $transferFromName = Subsidiary::where('subsidiary_id', $transferFromId)->value('subsidiary_name');
            $transferToName = Subsidiary::where('subsidiary_id', $transferToId)->value('subsidiary_name');
            $remarks = $request->remarks;
            $approverRoles = $request->approver_roles;

            $approverRolesString = implode(',', $approverRoles);

            $transferLogs = [];

            foreach ($request->items as $item) {
                $itemCode = $item['item_code'];
                $qty = $item['qty'];

                $inventory = Inventory::where('item_code', $itemCode)
                    ->where('subsidiaryid', $transferFromId)
                    ->first();

                if (!$inventory) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Item '{$itemCode}' not found in the specified subsidiary.",
                    ], 404);
                }

                $existingTargetInventory = Inventory::where('item_code', $itemCode)
                    ->where('subsidiaryid', $transferToId)
                    ->first();

                $transferCode = $existingTargetInventory ? $itemCode : null;

                if (!$existingTargetInventory || $existingTargetInventory->uomp !== $item['uomp']) {
                    $existingTransfer = Transfer::where('transfer_code', $itemCode)
                        ->where('transfer_from', $transferToName)
                        ->first();

                    if ($existingTransfer) {
                        $transferCode = $existingTransfer->item_code;
                    } else {
                        $existingInventoryCodes = Inventory::where('item_code', 'LIKE', 'ITEM-' . now()->format('Ymd') . '%')
                            ->pluck('item_code');
                    
                        $existingTransferCodes = Transfer::where('transfer_code', 'LIKE', 'ITEM-' . now()->format('Ymd') . '%')
                            ->pluck('transfer_code');
                    
                        $combinedCodes = $existingInventoryCodes->merge($existingTransferCodes);
                    
                        $maxSequence = $combinedCodes->map(function ($code) {
                            return (int) substr($code, strrpos($code, '-') + 1);
                        })->max();
                    
                        $nextSequence = str_pad($maxSequence + 1, 5, '0', STR_PAD_LEFT);
                        $transferCode = 'ITEM-' . now()->format('Ymd') . '-' . $nextSequence;
                    }
                }

                $newTransferLog = new Transfer();
                $newTransferLog->transact_id = $transactId;
                $newTransferLog->inventory_id = $inventory->inventory_id;
                $newTransferLog->transfer_from = $transferFromName;
                $newTransferLog->transfer_to = $transferToName;
                $newTransferLog->item_code = $itemCode;
                $newTransferLog->transfer_code = $transferCode;
                $newTransferLog->item_description = $inventory->item_description;
                $newTransferLog->item_category = $inventory->item_category;
                $newTransferLog->qty = $qty;
                $newTransferLog->uomp = $item['uomp']; 
                $newTransferLog->uoms = $item['uoms']; 
                $newTransferLog->uomt = $item['uomt']; 
                $newTransferLog->cost = $inventory->cost;
                $newTransferLog->usage = $inventory->usage;
                $newTransferLog->status = 'Pending';
                $newTransferLog->requester_id = auth()->id() ?? 0;
                $newTransferLog->requester_name = auth()->user()->name ?? 'N/A';
                $newTransferLog->remarks = $remarks;
                $newTransferLog->approver_roles = $approverRolesString;
                $newTransferLog->save();

                $transferLogs[] = $newTransferLog;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Transfer request has been logged and is pending approval.',
                'data' => $transferLogs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create transfer request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function approveTransfer(Request $request, $transactId)
    {
        try {
            $transfer = Transfer::where('transfer_id', $transactId)->firstOrFail();

            if ($transfer->status !== 'Pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This transfer is not pending and cannot be approved.',
                ], 400);
            }

            $itemCode = $transfer->item_code;
            $transferCode = $transfer->transfer_code;
            $qty = $transfer->qty;
            $transferFromId = Subsidiary::where('subsidiary_name', $transfer->transfer_from)->value('subsidiary_id');
            $transferToId = Subsidiary::where('subsidiary_name', $transfer->transfer_to)->value('subsidiary_id');

            $inventory = Inventory::where('item_code', $itemCode)
                ->where('subsidiaryid', $transferFromId)
                ->first();

            if (!$inventory) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Item '{$itemCode}' not found in the specified subsidiary.",
                ], 404);
            }

            if ($inventory->qty < $qty) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Insufficient quantity for item '{$itemCode}' in subsidiary '{$transfer->transfer_from}'.",
                    'available_qty' => $inventory->qty,
                ], 400);
            }

            $inventory->qty -= $qty;
            $inventory->save();

            $targetInventory = Inventory::where('item_code', $itemCode)
                ->where('subsidiaryid', $transferToId)
                ->first();

            if (!$targetInventory) {
                $targetInventory = Inventory::where('item_code', $transferCode)
                    ->where('subsidiaryid', $transferToId)
                    ->first();
            }

            if ($targetInventory) {
                $targetInventory->qty += $qty;
                $targetInventory->save();
            } else {
                Inventory::create([
                    'item_code' => $transferCode,
                    'item_description' => $inventory->item_description,
                    'item_category' => $inventory->item_category,
                    'uomp' => $inventory->uomp,
                    'uoms' => $inventory->uoms,
                    'uomt' => $inventory->uomt,
                    'qty' => $qty,
                    'cost' => $inventory->cost,
                    'usage' => $inventory->usage,
                    'subsidiaryid' => $transferToId,
                    'subsidiary' => $transfer->transfer_to,
                    'date' => now(),
                ]);
            }

            $transfer->status = 'Approved';
            $transfer->approved_by = $request->input('approved_by');
            $transfer->updated_at = now();
            $transfer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Transfer has been approved and completed.',
                'data' => $transfer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to approve transfer.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getInventorySuggestions(Request $request)
    {
        try {
            $subsidiaryId = $request->input('subsidiaryId');
            $searchTerm = $request->input('searchTerm');

            $inventory = Inventory::where('subsidiaryid', $subsidiaryId);

            if ($searchTerm) {
                $inventory->where('item_code', 'LIKE', '%' . $searchTerm . '%');
            }

            
            $results = $inventory->limit(10)->get();

            return response()->json([
                'status' => 'success',
                'data' => $results,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch inventory.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function fetchWithdraw(Request $request)
    {
        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $subsidiaryid = $request->subsidiaryid;
            $perPage = $request->get('per_page', 10);

            $withdrawQuery = Withdrawal::query();
            $withdrawItemsQuery = WithdrawalItems::query();
            Log::info('Fetching withdrawal with parameters:', [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'subsidiary_id' => $subsidiaryid,
            ]);

            if ($startDate && $endDate) {
                $withdrawQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }

            if ($subsidiaryid) {
                $withdrawQuery->where('subsidiaryid', $subsidiaryid);
            } else {
                Log::warning("No subsidiary found for ID: {$subsidiaryid}");
            }

            Log::info('Executing Transfer Query:', [
                'query' => $withdrawQuery->toSql(),
                'bindings' => $withdrawQuery->getBindings(),
            ]);

            $withdrawQueryResult = $withdrawQuery->first();
            if ($withdrawQueryResult) {
                $withdrawItemsQuery->where('withdrawal_id', $withdrawQueryResult->id);
                $withdrawQueryResult = Withdrawal::query()
                    ->join('withdrawal_items', 'withdrawals.id', '=', 'withdrawal_items.withdrawal_id')
                    ->select('withdrawals.*', 'withdrawal_items.*')
                    ->paginate($perPage);
                return response()->json([
                    'status' => 'success',
                    'data' => $withdrawQueryResult->items(),
                    'pagination' => [
                        'current_page' => $withdrawQueryResult->currentPage(),
                        'total_pages' => $withdrawQueryResult->lastPage(),
                        'total_items' => $withdrawQueryResult->total(),
                        'per_page' => $withdrawQueryResult->perPage(),
                    ]
                ], 200);
            }
            else {
                return response()->json([
                    'status' => 'success',
                    'data' => [],
                    'pagination' => [
                        'current_page' => 1,
                        'total_pages' => 1,
                        'total_items' => 0,
                        'per_page' => $perPage,
                    ]
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch withdrawal records.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function requestWithdraw(Request $request)
    {
        try {
            $request->validate([
                'requestor_name' => 'required|string|max:50',
                'requestor_number' => 'required|string|max:50',
                'requestor_id' => 'required|string|max:50',
                'remarks' => 'nullable|string|max:50',
                'subsidiaryid' => 'required|integer|exists:subsidiaries,subsidiary_id',
                'subsidiaryname' => 'required|string|max:100|exists:subsidiaries,subsidiary_name',
                'items' => 'required|array|min:1',
                'items.*.item_code' => 'required|string|max:50',
                'items.*.item_description' => 'required|string|max:255',
                'items.*.item_category' => 'required|string|max:100',
                'items.*.uom' => 'required|string|max:50',
                'items.*.reason' => 'required|string|max:50',
                'items.*.qty' => 'required|numeric|min:0.01',
            ]);

            $requestId = $request->requestor_number;
            $requestorName = $request->requestor_name;
            $requestorId = $request->requestor_id;
            $remarks = $request->remarks;
            $subsidiaryid = $request->subsidiaryid;

            $withdrawal = new Withdrawal();
            $withdrawal->request_number = $requestId;
            $withdrawal->requestor_name = $requestorName;
            $withdrawal->requestor_id = $requestorId;
            $withdrawal->remarks = $remarks;
            $withdrawal->subsidiaryid = $subsidiaryid;

            $withdrawal->save();
            $savedWithdrawal = $withdrawal->fresh();
            $withdrawalLog = [];

            foreach ($request->items as $item) {
                $itemCode = $item['item_code'];
                $qty = $item['qty'];
                $uom = $item['uom'];
                $reason = $item['reason'];
                $item_description = $item['item_description'];
                $item_category = $item['item_category'];

                $inventory = Inventory::where('item_code', $itemCode)
                    ->where('subsidiaryid', $subsidiaryid)
                    ->first();

                if (!$inventory) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Item '{$itemCode}' not found in the specified subsidiary.",
                    ], 404);
                }
                else{
                    $newWithdrawalLog = new WithdrawalItems();
                    $newWithdrawalLog->withdrawal_id = $savedWithdrawal->id;
                    $newWithdrawalLog->item_code = $itemCode;
                    $newWithdrawalLog->item_description = $item_description;
                    $newWithdrawalLog->category = $item_category;
                    $newWithdrawalLog->requested_qty = $qty;
                    $newWithdrawalLog->uom = $uom;
                    $newWithdrawalLog->reason = $reason;
                    $newWithdrawalLog->status = 0;
                    $newWithdrawalLog->save();
                    $withdrawalLog[] = $newWithdrawalLog;    
                }  
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Withdrawal request has been logged and is pending approval.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create withdrawal request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function approveWithdraw(Request $request, $id)
    {
        try {
            $withdraw = WithdrawalItems::where('id', $id)->firstOrFail();

            if ($withdraw->status !== 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This withdraw is not pending and cannot be approved.',
                ], 400);
            }

            $itemCode = $withdraw->item_code;
            $qty = $withdraw->requested_qty;

            $inventory = Inventory::where('item_code', $itemCode)
                ->first();

            if (!$inventory) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Item '{$itemCode}' not found in the specified subsidiary.",
                ], 404);
            }

            if ($inventory->qty < $qty) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Insufficient quantity for item '{$itemCode}'.",
                    'available_qty' => $inventory->qty,
                ], 400);
            }

            $inventory->qty -= $qty;
            $inventory->usage += $qty;
            $inventory->save();

            $withdraw->status = 1;
            $withdraw->updated_at = now();
            $withdraw->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Withdraw has been approved and completed.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to approve withdraw.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchWithdrawal(Request $request)
    {
        $searchTerm = $request->search;
        $id = $request->id;
        $perPage = $request->get('per_page', 10);
        $subsidiaryId = $request->subsidiaryid;

        try {
            if (!$id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Requestor ID is required.',
                ], 400);
            }

            $withdrawQueryResult = Withdrawal::query()
                ->join('withdrawal_items', 'withdrawals.id', '=', 'withdrawal_items.withdrawal_id')
                ->select('withdrawals.*', 'withdrawal_items.*')
                ->where('requestor_id', $id)
                ->where(function ($query) use ($searchTerm) {
                    if ($searchTerm) {
                        $query->where('item_description', 'LIKE', '%' . $searchTerm . '%')
                              ->orWhere('item_code', 'LIKE', '%' . $searchTerm . '%')
                              ->orWhere('request_number', 'LIKE', '%' . $searchTerm . '%')
                              ->orWhere('requestor_name', 'LIKE', '%' . $searchTerm . '%');
                    }
                })
                ->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => $withdrawQueryResult->items(),
                'pagination' => [
                    'current_page' => $withdrawQueryResult->currentPage(),
                    'total_pages' => $withdrawQueryResult->lastPage(),
                    'total_items' => $withdrawQueryResult->total(),
                    'per_page' => $withdrawQueryResult->perPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch withdrawals.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getCategory(Request $request)
    {
        try {
            $categories = Categories::select('id', 'name', 'description')->get();

            return response()->json([
                'status' => 'success',
                'data' => $categories,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch permissions.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function getSubCategory(Request $request, $id)
    {
        try {
            $categories = Subcategories::select('id', 'name')
                ->where('category_id', $id)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $categories,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch permissions.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function postCategory(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $new_category = new Categories();
            $new_category->name = $request->name; 
            $new_category->save();
            return response()->json([
               'status' => 'success',
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

    public function postSubCategory(Request $request)
    {
        try {

            $request->validate([
                'categoryid' => 'required|integer'
                'name' => 'required|string|max:255',
            ]);

            $new_subcategory = new Subcategories();
            $new_subcategory->name = $request->name; 
            $new_subcategory->categoryid = $request->categoryid; 
            $new_subcategory->save();
            
            return response()->json([
               'status' => 'success',
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
}
