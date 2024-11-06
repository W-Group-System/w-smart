<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Inventory;
use App\Transfer;
use App\Approval;
use App\Subsidiary;
use App\Withdrawal;
use App\WithdrawalItems;
use App\Categories;
use App\Subcategories;
use App\Uoms;
use App\Returns;
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

/*            if ($startDate && $endDate) {
                // Format the start and end dates
                $startDateTime = date('Y-m-d 00:00:00', strtotime($startDate)); // Start of the day
                $endDateTime = date('Y-m-d 23:59:59', strtotime($endDate)); // End of the day

                $query->where('subsidiaryid', $subsidiaryid)
                      ->where('date', '>=', $startDateTime)
                      ->where('date', '<=', $endDateTime);
            }*/

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('item_description', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('item_code', 'LIKE', '%' . $searchTerm . '%');
                });
            }
            $query->where('subsidiaryid', $subsidiaryid);
            $query->orderBy('date', 'desc');
            $inventory = $query->paginate($perPage);

            $inventory->getCollection()->transform(function ($item) {
                if ($item->uom_id) {
                    $uom = Uoms::find($item->uom_id);
                    if ($uom) {
                        $item->primaryUOM = $uom->uomp;
                        $item->primaryUOMValue = $uom->uomp_value;
                        $item->secondaryUOM = $uom->uoms;
                        $item->secondaryUOMValue = $uom->uoms_value;
                        $item->tertiaryUOM = $uom->uomt;
                        $item->tertiaryUOMValue = $uom->uomt_value;
                    }
                }
                return $item;
            });

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
               'primaryUOM.name' => 'required|string|max:255',
               'primaryUOM.value' => 'required|numeric|min:0',
               'secondaryUOM.name' => 'required|string|max:255',
               'secondaryUOM.value' => 'required|numeric|min:0',
               'tertiaryUOM.name' => 'required|string|max:255',
               'tertiaryUOM.value' => 'required|numeric|min:0',
               'qty' => 'required|numeric|min:0',
               'cost' => 'required|numeric|min:0',
               'usage' => 'required|numeric|min:0',
               'subsidiary' => 'required|string|max:100',
               'subsidiaryid' => 'required|numeric|min:0',
           	]);

            $primaryUOMName = $request->primaryUOM['name'];
            $primaryUOMValue = $request->primaryUOM['value'];
            $secondaryUOMName = $request->secondaryUOM['name'];
            $secondaryUOMValue = $request->secondaryUOM['value'];
            $tertiaryUOMName = $request->tertiaryUOM['name'];
            $tertiaryUOMValue = $request->tertiaryUOM['value'];

            $uom = Uoms::where('uomp', $primaryUOMName)
                ->where('uomp_value', $primaryUOMValue)
                ->where('uoms', $secondaryUOMName)
                ->where('uoms_value', $secondaryUOMValue)
                ->where('uomt', $tertiaryUOMName)
                ->where('uomt_value', $tertiaryUOMValue)
                ->first();

            if (!$uom) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid UOM combination provided.',
                ], 400);
            }

           	$new_inventory = new Inventory();
           	$new_inventory->date = $request->date; 
           	$new_inventory->item_code = $request->item_code; 
           	$new_inventory->item_description = $request->item_description; 
           	$new_inventory->category_id = $request->category_id; 
            $new_inventory->item_category = $request->item_category; 
            $new_inventory->subcategory_id = $request->subcategory_id; 
            $new_inventory->subcategory_name = $request->subcategory_name; 
            $new_inventory->uomp = $primaryUOMName;
            $new_inventory->uoms = $secondaryUOMName;
            $new_inventory->uomt = $tertiaryUOMName; 
            $new_inventory->uom_id = $uom->id;
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
                if ($item->uom_id) {
                    $uom = Uoms::find($item->uom_id);
                    if ($uom) {
                        $item->primaryUOM = $uom->uomp;
                        $item->primaryUOMValue = $uom->uomp_value;
                        $item->secondaryUOM = $uom->uoms;
                        $item->secondaryUOMValue = $uom->uoms_value;
                        $item->tertiaryUOM = $uom->uomt;
                        $item->tertiaryUOMValue = $uom->uomt_value;
                        $item->relation_id = $uom->relation_id;
                    }
                }

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

            $query->leftJoin('approvals', function($join) {
                $join->on('transfers.transfer_id', '=', 'approvals.process_id')
                    ->where('approvals.process', '=', 'transfer')
                    ->whereColumn('transfers.hierarchy', '=', 'approvals.hierarchy');
            })
            ->select('transfers.*', 'approvals.approver_id', 'approvals.approver_name');
            
            if ($startDate && $endDate) {
                $query->whereBetween('transfers.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }
            
            if ($subsidiary) {
                $query->where('transfers.transfer_to', $subsidiary->subsidiary_name);
            } else {
                Log::warning("No subsidiary found for ID: {$subsidiaryid}");
            }
            
            $query->orderBy('transfers.created_at', 'desc');

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
                'items.*.relation_id' => 'required|integer|exists:uoms,relation_id',
                'items.*.uomp' => 'required|string|max:255',
                'items.*.uoms' => 'required|string|max:255',
                'items.*.uomt' => 'required|string|max:255',
                'transfer_from' => 'required|integer|exists:subsidiaries,subsidiary_id',
                'transfer_to' => 'required|integer|exists:subsidiaries,subsidiary_id|different:transfer_from',
                'remarks' => 'nullable|string|max:255',
                'approvals' => 'required|array|min:2',
                'approvals.*.approver_id' => 'required|integer|exists:users,id',
                'approvals.*.approver_name' => 'required|string|max:255',
            ]);

            $transactId = $request->transact_id;
            $transferFromId = $request->transfer_from;
            $transferToId = $request->transfer_to;
            $transferFromName = Subsidiary::where('subsidiary_id', $transferFromId)->value('subsidiary_name');
            $transferToName = Subsidiary::where('subsidiary_id', $transferToId)->value('subsidiary_name');
            $remarks = $request->remarks;

            $transferLogs = [];

            foreach ($request->items as $item) {
                $itemCode = $item['item_code'];
                $qty = $item['qty'];
                $relationId = $item['relation_id'];

                $uom = Uoms::where('relation_id', $relationId)
                    ->where('uomp', $item['uomp'])
                    ->where('uoms', $item['uoms'])
                    ->where('uomt', $item['uomt'])
                    ->first();

                if (!$uom) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "No matching UOM found for item '{$itemCode}' with the specified relation.",
                    ], 404);
                }

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

                $transferCode = $itemCode; 

                if (!$existingTargetInventory || $existingTargetInventory->uomp !== $item['uomp']) {
                    $existingTransfer = Transfer::where('transfer_code', $itemCode)
                        ->where('transfer_from', $transferToName)
                        ->first();

                    if ($existingTransfer) {
                        $transferCode = $existingTransfer->item_code;
                    } else {
                        $transferCode = $itemCode;
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
                $newTransferLog->released_qty = 0;
                $newTransferLog->uomp = $item['uomp']; 
                $newTransferLog->uoms = $item['uoms']; 
                $newTransferLog->uomt = $item['uomt']; 
                $newTransferLog->uom_id = $uom->id;
                $newTransferLog->status = 'Pending';
                $newTransferLog->requester_id = $request->input('requester_id', auth()->id() ?? 0);
                $newTransferLog->requester_name = $request->input('requester_name', auth()->user()->name ?? 'N/A');
                $newTransferLog->remarks = $remarks;
                $newTransferLog->hierarchy = 1;
                $newTransferLog->save(); 

                $transferLogs[] = $newTransferLog;

                \Log::info('Transfer log after save:', [
                    'transfer_log_id' => $newTransferLog->transfer_id,  
                    'transact_id' => $newTransferLog->transact_id,
                    'transfer_from' => $newTransferLog->transfer_from,
                    'transfer_to' => $newTransferLog->transfer_to,
                    'status' => $newTransferLog->status,
                ]);

                if ($newTransferLog->transfer_id) {
                    \Log::info("New transfer log ID: " . $newTransferLog->transfer_id);

                    foreach ($request->approvals as $index => $approval) {
                        $newApproval = new Approval(); 
                        $newApproval->process = 'transfer'; 
                        $newApproval->process_id = $newTransferLog->transfer_id; 
                        $newApproval->approver_id = $approval['approver_id'];
                        $newApproval->approver_name = $approval['approver_name'];
                        $newApproval->hierarchy = $approval['hierarchy'];

                        try {
                            $newApproval->save(); 
                            \Log::info("Approval saved for approver: " . $approval['approver_name']);
                        } catch (\Exception $e) {
                            \Log::error("Failed to save approval for approver: " . $approval['approver_name'] . ". Error: " . $e->getMessage());
                        }
                    }
                } else {
                    \Log::error("Failed to retrieve the transfer log ID after saving.");
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to retrieve transfer log ID.',
                    ], 500);
                }
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

            if ($transfer->status === 'Receiving') {
                return $this->processReceiving($request, $transfer);
            } elseif ($transfer->status !== 'Pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This transfer is not pending and cannot be approved.',
                ], 400);
            }

            $currentHierarchy = Approval::where('process_id', $transactId)
                ->where('process', 'transfer')
                ->where('approver_id', $request->input('approver_id'))
                ->value('hierarchy');

            if (!$currentHierarchy) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to approve this transfer at this stage.',
                ], 403);
            }

            $releasedQty = $request->input('released_qty');
            if ($releasedQty && $releasedQty > 0) {
                $transfer->released_qty = $releasedQty; 
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid released quantity provided.',
                ], 400);
            }

            $newTransferHierarchy = $transfer->hierarchy + 1;
            $transfer->hierarchy = $newTransferHierarchy; 
            $transfer->save();

            $nextApprovalExists = Approval::where('process_id', $transactId)
            ->where('process', 'transfer')
            ->where('hierarchy', $newTransferHierarchy)
            ->exists();

            if ($nextApprovalExists) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Transfer approved at this level. Waiting for next approver.',
                ], 200);
            }

            $transfer->status = 'Receiving';
            $transfer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Transfer is now marked as "Receiving". Requester will handle final approval.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to approve transfer.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function declineTransfer(Request $request, $transactId)
    {
        try {
            $transfer = Transfer::where('transfer_id', $transactId)->firstOrFail();

            $transfer->status = $transfer->status === 'Receiving' ? 'Not Received' : 'Declined';

            if ($request->has('remarks')) {
                $transfer->remarks = $request->input('remarks');
            }

            $transfer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Transfer status updated successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to decline transfer.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function processReceiving(Request $request, $transfer)
    {
        try {
            $itemCode = $transfer->item_code;
            $transferCode = $transfer->transfer_code;
            $releasedQty = $transfer->released_qty;
            $transferFromId = Subsidiary::where('subsidiary_name', $transfer->transfer_from)->value('subsidiary_id');
            $transferToId = Subsidiary::where('subsidiary_name', $transfer->transfer_to)->value('subsidiary_id');

            $sourceInventory = Inventory::where('item_code', $itemCode)
                ->where('subsidiaryid', $transferFromId)
                ->first();

            if (!$sourceInventory) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Item '{$itemCode}' not found in the specified subsidiary.",
                ], 404);
            }

            $uom = Uoms::find($sourceInventory->uom_id);
            if (!$uom) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'UOM configuration for source inventory not found.',
                ], 404);
            }

            $convertedSourceQty = $this->convertToTargetUOM($sourceInventory, $releasedQty, $transfer);
            
            if ($convertedSourceQty < $releasedQty) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Insufficient quantity for item '{$itemCode}' in subsidiary '{$transfer->transfer_from}'.",
                    'available_qty' => $convertedSourceQty,
                ], 400);
            }

            $sourceInventory->qty -= $this->revertToPrimaryUOM($sourceInventory, $releasedQty, $transfer);
            $sourceInventory->save();

            $targetInventory = Inventory::where('item_code', $itemCode)
                ->where('subsidiaryid', $transferToId)
                ->first();

            if ($targetInventory) {
                $targetInventory->qty += $releasedQty; 
                $targetInventory->save();
            } else {
                $targetUom = Uoms::find($transfer->uom_id);
                if (!$targetUom) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'UOM configuration for target inventory not found.',
                    ], 404);
                }

                $inventoryData = [
                    'item_code' => $transferCode,
                    'item_description' => $sourceInventory->item_description,
                    'item_category' => $sourceInventory->item_category,
                    'category_id' => $sourceInventory->category_id,
                    'subcategory_name' => $sourceInventory->subcategory_name ?? '',
                    'subcategory_id' => $sourceInventory->subcategory_id ?? 0,
                    'uomp' => $targetUom->uomp,
                    'uoms' => $targetUom->uoms,
                    'uomt' => $targetUom->uomt,
                    'uom_id' => $transfer->uom_id,
                    'qty' => $releasedQty,
                    'cost' => $sourceInventory->cost,
                    'usage' => $sourceInventory->usage,
                    'subsidiaryid' => $transferToId,
                    'subsidiary' => $transfer->transfer_to,
                    'remarks' => 'Transferred',
                    'date' => now(),
                ];

                \Log::info('Creating new inventory entry', $inventoryData);

                Inventory::create($inventoryData);
            }

            // Mark the transfer as completed
            $transfer->status = 'Received';
            $transfer->updated_at = now();
            $transfer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Transfer has been received and completed.',
                'data' => $transfer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process receiving step.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function convertToTargetUOM($sourceInventory, $releasedQty, $transfer)
    {
        $uom = Uoms::find($sourceInventory->uom_id);
        if (!$uom) {
            return $releasedQty;
        }

        $primaryValue = $uom->uomp_value;
        $secondaryValue = $uom->uoms_value;
        $tertiaryValue = $uom->uomt_value;

        $sourceUOM = $sourceInventory->uomp;
        $targetUOM = $transfer->uomp;

        // Convert based on UOM values
        if ($sourceUOM === $targetUOM) {
            return $releasedQty;
        }

        // Adjust conversion logic to convert to target UOM
        if ($sourceUOM === $uom->uomp && $targetUOM === $uom->uoms) {
            return $releasedQty * ($secondaryValue / $primaryValue);
        } elseif ($sourceUOM === $uom->uomp && $targetUOM === $uom->uomt) {
            return $releasedQty * ($tertiaryValue / $primaryValue);
        } elseif ($sourceUOM === $uom->uoms && $targetUOM === $uom->uomp) {
            return $releasedQty * ($primaryValue / $secondaryValue);
        } elseif ($sourceUOM === $uom->uoms && $targetUOM === $uom->uomt) {
            return $releasedQty * ($tertiaryValue / $secondaryValue);
        } elseif ($sourceUOM === $uom->uomt && $targetUOM === $uom->uomp) {
            return $releasedQty * ($primaryValue / $tertiaryValue);
        } elseif ($sourceUOM === $uom->uomt && $targetUOM === $uom->uoms) {
            return $releasedQty * ($secondaryValue / $tertiaryValue);
        }

        // If no match, return original value
        return $releasedQty;
    }

    private function revertToPrimaryUOM($sourceInventory, $releasedQty, $transfer)
    {
        $uom = Uoms::find($sourceInventory->uom_id);
        if (!$uom) {
            return $releasedQty;
        }

        $primaryValue = $uom->uomp_value;
        $secondaryValue = $uom->uoms_value;
        $tertiaryValue = $uom->uomt_value;

        $sourceUOM = $sourceInventory->uomp;
        $targetUOM = $transfer->uomp;

        // Revert back to source UOM before saving
        if ($sourceUOM === $targetUOM) {
            return $releasedQty;
        }

        if ($sourceUOM === $uom->uomp && $targetUOM === $uom->uoms) {
            return $releasedQty * ($primaryValue / $secondaryValue);
        } elseif ($sourceUOM === $uom->uomp && $targetUOM === $uom->uomt) {
            return $releasedQty * ($primaryValue / $tertiaryValue);
        } elseif ($sourceUOM === $uom->uoms && $targetUOM === $uom->uomp) {
            return $releasedQty * ($secondaryValue / $primaryValue);
        } elseif ($sourceUOM === $uom->uoms && $targetUOM === $uom->uomt) {
            return $releasedQty * ($secondaryValue / $tertiaryValue);
        } elseif ($sourceUOM === $uom->uomt && $targetUOM === $uom->uomp) {
            return $releasedQty * ($tertiaryValue / $primaryValue);
        } elseif ($sourceUOM === $uom->uomt && $targetUOM === $uom->uoms) {
            return $releasedQty * ($tertiaryValue / $secondaryValue);
        }

        return $releasedQty;
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

                // Join with approvals and select fields from both tables
                $withdrawItemsQuery->leftJoin('approvals', function ($join) {
                    $join->on('withdrawal_items.id', '=', 'approvals.process_id')
                         ->where('approvals.process', '=', 'withdraw')
                         ->whereColumn('withdrawal_items.hierarchy', '=', 'approvals.hierarchy');
                });

                // Join withdrawal_items with withdrawals and select data from all tables
                $withdrawQueryResult = Withdrawal::query()
                    ->join('withdrawal_items', 'withdrawals.id', '=', 'withdrawal_items.withdrawal_id')
                    ->leftJoin('approvals', function ($join) {
                        $join->on('withdrawal_items.id', '=', 'approvals.process_id')
                             ->where('approvals.process', '=', 'withdraw')
                             ->whereColumn('withdrawal_items.hierarchy', '=', 'approvals.hierarchy');
                    })
                    ->select(
                        'withdrawals.*', 
                        'withdrawal_items.*', 
                        'approvals.approver_id', 
                        'approvals.approver_name'
                    )
                    ->orderBy('withdrawals.updated_at', 'desc')
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
                'items.*.uomp' => 'required|string|max:50',
                'items.*.uoms' => 'required|string|max:50',
                'items.*.uomt' => 'required|string|max:50',
                'items.*.uom_id' => 'required|integer|exists:uoms,id',
                'items.*.reason' => 'required|string|max:50',
                'items.*.qty' => 'required|numeric|min:0.01',
                'approvals' => 'required|array|min:2',
                'approvals.*.approver_id' => 'required|integer|exists:users,id',
                'approvals.*.approver_name' => 'required|string|max:255',
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
                $uomp = $item['uomp'];
                $uoms = $item['uoms'];
                $uomt = $item['uomt'];
                $uomId = $item['uom_id'];
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
                    $newWithdrawalLog->uomp = $uomp; 
                    $newWithdrawalLog->uoms = $uoms; 
                    $newWithdrawalLog->uomt = $uomt; 
                    $newWithdrawalLog->uom_id = $uomId;
                    $newWithdrawalLog->reason = $reason;
                    $newWithdrawalLog->status = 0;
                    $newWithdrawalLog->hierarchy = 1;
                    $newWithdrawalLog->save();
                    $withdrawalLog[] = $newWithdrawalLog;

                    if ($newWithdrawalLog->withdrawal_id) {
                        \Log::info("New withdrawal log ID: " . $newWithdrawalLog->id);

                        foreach ($request->approvals as $index => $approval) {
                            $newApproval = new Approval(); 
                            $newApproval->process = 'withdraw'; 
                            $newApproval->process_id = $newWithdrawalLog->id; 
                            $newApproval->approver_id = $approval['approver_id'];
                            $newApproval->approver_name = $approval['approver_name'];
                            $newApproval->hierarchy = $approval['hierarchy'];

                            try {
                                $newApproval->save(); 
                                \Log::info("Approval saved for approver: " . $approval['approver_name']);
                            } catch (\Exception $e) {
                                \Log::error("Failed to save approval for approver: " . $approval['approver_name'] . ". Error: " . $e->getMessage());
                            }
                        }
                    } else {
                        \Log::error("Failed to retrieve the transfer log ID after saving.");
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to retrieve transfer log ID.',
                        ], 500);
                    }   
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

    public function processWithdraw(Request $request, $id)
    {
        try {
            $withdraw = WithdrawalItems::where('id', $id)->firstOrFail();

            if ($withdraw->status !== 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This withdraw request is not approved by the approvers yet!',
                ], 400);
            }

            $itemCode = $withdraw->item_code;
            $releasedQty = $request->released_qty;

            $withdrawal = Withdrawal::find($withdraw->withdrawal_id);
            if (!$withdrawal) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Associated withdrawal record not found.',
                ], 404);
            }
            $subsidiaryId = $withdrawal->subsidiaryid;

            $inventory = Inventory::where('item_code', $itemCode)
                                ->where('subsidiaryid', $subsidiaryId)
                                ->first();

            if (!$inventory) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Item '{$itemCode}' not found in the specified subsidiary.",
                ], 404);
            }

            $uom = Uoms::find($withdraw->uom_id);
            if (!$uom) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'UOM configuration not found for the inventory item.',
                ], 404);
            }
            $convertedQty = $this->convertToTargetUOM($inventory, $releasedQty, $withdraw);

            $convertedPrimaryQty = $this->convertToTargetUOM($inventory, $inventory->qty, $withdraw);
            if ($convertedPrimaryQty < $releasedQty) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Insufficient quantity for item '{$itemCode}'.",
                    'available_qty' => $inventory->qty,
                ], 200);
            }

            $inventory->qty -= $this->revertToPrimaryUOM($inventory, $releasedQty, $withdraw);
            $inventory->usage += $this->revertToPrimaryUOM($inventory, $releasedQty, $withdraw);
            $inventory->save();

            $withdraw->status = 2;
            $withdraw->primary_qty = $this->revertToPrimaryUOM($inventory, $releasedQty, $withdraw);
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

    public function processReturn(Request $request, $id)
    {

        try {
            $return = Returns::where('id', $id)->firstOrFail();
            if ($return->status !== 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This return request is not approved by the approvers yet!',
                ], 400);
            }

            $withdrawal = WithdrawalItems::join('withdrawals', 'withdrawal_items.withdrawal_id', '=', 'withdrawals.id')
               ->where('withdrawals.request_number', $return->process_id)
               ->select('withdrawal_items.*')
               ->firstOrFail();
            $itemCode = $return->item_code;
            $releasedQty = $request->released_qty;

            $subsidiaryId = $return->subsidiaryid;

            $inventory = Inventory::where('item_code', $itemCode)
                                ->where('subsidiaryid', $subsidiaryId)
                                ->first();

            if (!$inventory) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Item '{$itemCode}' not found in the specified subsidiary.",
                ], 404);
            }

            $uom = Uoms::find($return->uomid);
            if (!$uom) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'UOM configuration not found for the inventory item.',
                ], 404);
            }
            $convertedQty = $this->convertToTargetUOM($inventory, $releasedQty, $withdrawal);
            
            $inventory->qty += $this->revertToPrimaryUOM($inventory, $convertedQty, $withdrawal);
            $inventory->usage -= $this->revertToPrimaryUOM($inventory, $convertedQty, $withdrawal);
            $inventory->save();
            $withdrawal->released_qty -= $convertedQty;

            $withdrawal->primary_qty -= $this->revertToPrimaryUOM($inventory, $convertedQty, $withdrawal);
            if ($withdrawal->primary_qty <= 0) {
                $withdrawal->status = 6;
            }
            $withdrawal->save();
            $return->status = 2;
            $return->updated_at = now();
            $return->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Return request has been approved and completed.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to approve return request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function convertToPrimaryUOM($uom, $releasedQty, $currentUOM)
    {
        $secondaryValue = $uom->uoms_value; 
        $tertiaryValue = $uom->uomt_value;

        if ($currentUOM === $uom->uomp) {
            return $releasedQty;
        } elseif ($currentUOM === $uom->uoms) {
            return $releasedQty / $secondaryValue;
        } elseif ($currentUOM === $uom->uomt) {
            return $releasedQty / $tertiaryValue;
        }

        return $releasedQty;
    }

    public function approveWithdraw(Request $request, $transactId)
    {
        try {
            $withdraw = WithdrawalItems::where('id', $transactId)->firstOrFail();

            if ($withdraw->status === 1) {
                return $this->processWithdraw($request, $transactId);
            } elseif ($withdraw->status !== 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This withdraw request is not pending and cannot be approved.',
                ], 400);
            }

            $currentHierarchy = Approval::where('process_id', $transactId)
                ->where('process', 'withdraw')
                ->where('approver_id', $request->input('approver_id'))
                ->value('hierarchy');

            if (!$currentHierarchy) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to approve this transfer at this stage.',
                ], 403);
            }

            $releasedQty = $request->input('released_qty');
            if ($releasedQty && $releasedQty > 0) {
                $withdraw->released_qty = $releasedQty; 
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid released quantity provided.',
                ], 400);
            }

            $newWithdrawHierarchy = $withdraw->hierarchy + 1;
            $withdraw->hierarchy = $newWithdrawHierarchy; 
            $withdraw->save();

            $nextApprovalExists = Approval::where('process_id', $transactId)
            ->where('process', 'withdraw')
            ->where('hierarchy', $newWithdrawHierarchy)
            ->exists();

            if ($nextApprovalExists) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Withdraw request approved at this level. Waiting for next approver.',
                ], 200);
            }

            $withdraw->status = 1;
            $withdraw->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Withdraw request is now marked as "Receiving". Requester will handle final approval.',
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
            $new_category->description = $request->description; 
            $new_category->save();
            $newCategoryId = $new_category->id;
            if($request->subcategories) {
                foreach ($request->subcategories as $items) {
                    foreach($items as $item) {
                        $new_subCategory = new Subcategories();
                        $new_subCategory->name = $item; 
                        $new_subCategory->category_id = $newCategoryId; 
                        $new_subCategory->save();
                    }
                    
                }
            }

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
                'categoryid' => 'required|integer',
                'subcategories' => 'required|array|min:1',
                'subcategories.*' => 'string|max:255',
            ]);

            // Get the category ID from the request
            $categoryId = $request->categoryid;

            // Loop through each subcategory name
            foreach ($request->subcategories as $item) {
                $new_subCategory = new Subcategories();
                $new_subCategory->name = $item; 
                $new_subCategory->category_id = $categoryId; // Use the category ID from the request
                $new_subCategory->save();
            }

            return response()->json([
               'status' => 'success',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create subcategory: ' . $e->getMessage());
            return response()->json([
               'status' => 'error',
               'message' => 'Failed to create subcategory.',
               'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUOMs(Request $request)
    {
        try {
            $query = Uoms::select(
                'id',
                'relation_id',
                'uomp as primaryUOM',
                'uomp_value as primaryUOMValue',
                'uoms as secondaryUOM',
                'uoms_value as secondaryUOMValue',
                'uomt as tertiaryUOM',
                'uomt_value as tertiaryUOMValue'
            );
    
            if ($request->has('primary') && !empty($request->primary)) {
                $query->where('uomp', $request->primary);
            }
    
            if ($request->has('secondary') && !empty($request->secondary)) {
                $query->where('uoms', $request->secondary); 
            }
    
            if ($request->has('searchPrimary') && !empty($request->searchPrimary)) {
                $search = $request->searchPrimary;
                $query->whereRaw("LOWER(uomp) = ?", [strtolower($search)]);
            }
            
            if ($request->has('searchSecondary') && !empty($request->searchSecondary)) {
                $search = $request->searchSecondary;
                $query->whereRaw("LOWER(uoms) = ?", [strtolower($search)]);
            }
            
            if ($request->has('searchTertiary') && !empty($request->searchTertiary)) {
                $search = $request->searchTertiary;
                $query->whereRaw("LOWER(uomt) = ?", [strtolower($search)]);
            }
    
            $uoms = $query->limit($request->input('limit', 10))->get();
    
            return response()->json([
                'status' => 'success',
                'data' => $uoms,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch UOMs.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function postUOM(Request $request)
    {
        try {
            $request->validate([
                'primaryUOM' => 'required|string|max:255',
                'primaryUOMValue' => 'required|numeric|min:0',
                'secondaryUOM' => 'required|string|max:255',
                'secondaryUOMValue' => 'required|numeric|min:0',
                'tertiaryUOM' => 'required|string|max:255',
                'tertiaryUOMValue' => 'required|numeric|min:0',
            ]);

            $uoms = [
                [
                    'uom' => strtolower($request->primaryUOM),
                    'value' => 1
                ],
                [
                    'uom' => strtolower($request->secondaryUOM),
                    'value' => round($request->secondaryUOMValue / $request->primaryUOMValue, 6)
                ],
                [
                    'uom' => strtolower($request->tertiaryUOM),
                    'value' => round($request->tertiaryUOMValue / $request->primaryUOMValue, 6)
                ]
            ];

            function adjustUOMValues($primaryIndex, $secondaryIndex, $tertiaryIndex, $uoms)
            {
                $primaryUOM = $uoms[$primaryIndex];
                $primaryUOM['value'] = 1;

                $secondaryValue = $uoms[$secondaryIndex]['value'] / $uoms[$primaryIndex]['value'];
                $tertiaryValue = $uoms[$tertiaryIndex]['value'] / $uoms[$primaryIndex]['value'];

                $uoms[$primaryIndex]['value'] = 1;
                $uoms[$secondaryIndex]['value'] = round($secondaryValue, 6);
                $uoms[$tertiaryIndex]['value'] = round($tertiaryValue, 6);

                return [
                    $uoms[$primaryIndex],
                    $uoms[$secondaryIndex],
                    $uoms[$tertiaryIndex]
                ];
            }

            $combinations = [];
            $indices = [
                [0, 1, 2], 
                [0, 2, 1], 
                [1, 0, 2], 
                [1, 2, 0], 
                [2, 0, 1], 
                [2, 1, 0]  
            ];

            foreach ($indices as $indexSet) {
                $adjustedUOMs = adjustUOMValues($indexSet[0], $indexSet[1], $indexSet[2], $uoms);
                $combinations[] = [
                    'uomp' => $adjustedUOMs[0]['uom'],
                    'uomp_value' => $adjustedUOMs[0]['value'],
                    'uoms' => $adjustedUOMs[1]['uom'],
                    'uoms_value' => $adjustedUOMs[1]['value'],
                    'uomt' => $adjustedUOMs[2]['uom'],
                    'uomt_value' => $adjustedUOMs[2]['value']
                ];
            }

            $firstCombination = $combinations[0];
            $firstUOM = new Uoms();
            $firstUOM->uomp = ucfirst($firstCombination['uomp']);
            $firstUOM->uomp_value = $firstCombination['uomp_value'];
            $firstUOM->uoms = ucfirst($firstCombination['uoms']);
            $firstUOM->uoms_value = $firstCombination['uoms_value'];
            $firstUOM->uomt = ucfirst($firstCombination['uomt']);
            $firstUOM->uomt_value = $firstCombination['uomt_value'];
            $firstUOM->save();

            $relationId = $firstUOM->id;
            $firstUOM->relation_id = $relationId;
            $firstUOM->save();

            for ($i = 1; $i < count($combinations); $i++) {
                $combination = $combinations[$i];
                $new_uom = new Uoms();
                $new_uom->uomp = ucfirst($combination['uomp']);
                $new_uom->uomp_value = $combination['uomp_value'];
                $new_uom->uoms = ucfirst($combination['uoms']);
                $new_uom->uoms_value = $combination['uoms_value'];
                $new_uom->uomt = ucfirst($combination['uomt']);
                $new_uom->uomt_value = $combination['uomt_value'];
                $new_uom->relation_id = $relationId; 
                $new_uom->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Unique UOM combinations have been saved.',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create UOM: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create UOM.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUOMSettings(Request $request)
    {
        try {
            $query = Uoms::select(
                'id',
                'relation_id',
                'uomp as primaryUOM',
                'uomp_value as primaryUOMValue',
                'uoms as secondaryUOM',
                'uoms_value as secondaryUOMValue',
                'uomt as tertiaryUOM',
                'uomt_value as tertiaryUOMValue'
            );

            if ($request->has('primary') && !empty($request->primary)) {
                $query->where('uomp', $request->primary);
            }

            if ($request->has('secondary') && !empty($request->secondary)) {
                $query->where('uoms', $request->secondary); 
            }

            if ($request->has('searchPrimary') && !empty($request->searchPrimary)) {
                $search = $request->searchPrimary;
                $query->where('uomp', 'LIKE', "%$search%");
            }

            if ($request->has('searchSecondary') && !empty($request->searchSecondary)) {
                $search = $request->searchSecondary;
                $query->where('uoms', 'LIKE', "%$search%");
            }

            if ($request->has('searchTertiary') && !empty($request->searchTertiary)) {
                $search = $request->searchTertiary;
                $query->where('uomt', 'LIKE', "%$search%");
            }

            $uoms = $query->get();
            $groupedUOMs = $uoms->groupBy('relation_id')->map(function ($group) {
                return [
                    'relation_id' => $group->first()->relation_id,
                    'uoms' => $group->map(function ($uom) {
                        return [
                            'id' => $uom->id,
                            'primaryUOM' => $uom->primaryUOM,
                            'primaryUOMValue' => $uom->primaryUOMValue,
                            'secondaryUOM' => $uom->secondaryUOM,
                            'secondaryUOMValue' => $uom->secondaryUOMValue,
                            'tertiaryUOM' => $uom->tertiaryUOM,
                            'tertiaryUOMValue' => $uom->tertiaryUOMValue,
                        ];
                    })->values()
                ];
            })->values();

            return response()->json([
                'status' => 'success',
                'data' => $groupedUOMs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch UOM settings.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function fetchReturns(Request $request)
    {
        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $subsidiaryid = $request->subsidiaryid;
            $perPage = $request->get('per_page', 10);

            $subsidiary = Subsidiary::where('subsidiary_id', $subsidiaryid)->first();
            $query = Returns::query();

            $query->leftJoin('approvals', function($join) {
                $join->on('returns.id', '=', 'approvals.process_id')
                    ->where('approvals.process', '=', 'return')
                    ->whereColumn('returns.hierarchy', '=', 'approvals.hierarchy');
            })
            ->select('returns.*', 'approvals.approver_id', 'approvals.approver_name');
            
            if ($startDate && $endDate) {
                $query->whereBetween('returns.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }
            
            $query->orderBy('returns.created_at', 'desc');

            Log::info('Executing Returns Query:', [
                'query' => $query->toSql(),
                'bindings' => $query->getBindings(),
            ]);

            $returns = $query->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => $returns->items(),
                'pagination' => [
                    'current_page' => $returns->currentPage(),
                    'total_pages' => $returns->lastPage(),
                    'total_items' => $returns->total(),
                    'per_page' => $returns->perPage(),
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

    public function requestReturn(Request $request)
    {
        try {
  /*          $request->validate([
                'request_number' => 'required|string|max:100',
                'requestor_name' => 'required|string|max:255',
                'requestor_id' => 'required|string|max:255',
                'subsidiaryid' => 'required|integer',
                'subsidiary_name' => 'required|string|max:255',
                'items' => 'required|array|min:2',

                'items.*.item_code' => 'required|string|max:50',
                'items.*.item_description' => 'required|string|max:255',
                'items.*.withdraw_qty' => 'required|numeric|min:0.01',
                'items.*.returned_qty' => 'required|numeric|min:0.01',

                'items.*.uomid' => 'required|integer',
                'items.*.uom' => 'required|string|max:255',
                'items.*.item_category' => 'required|string|max:255',
                'items.*.return_date' => 'required|date',
                'items.*.reason' => 'required|date',

                'approvals' => 'required|array|min:2',
                'approvals.*.approver_id' => 'required|integer|exists:users,id',
                'approvals.*.approver_name' => 'required|string|max:255',
            ]);*/

            $requestId = $request->request_number;
            $requestorName = $request->requestor_name;
            $requestorId = $request->requestor_id;
            $remarks = $request->remarks;
            $subsidiaryid = $request->subsidiaryid;
            $subsidiary_name = $request->subsidiary_name;

            $returnLogs = [];

            foreach ($request->items as $item) {
                $itemCode = $item['item_code'];
                $process_id = $item['process_id'];
                $returned_qty = $item['returned_qty'];
                $withdraw_qty = $item['withdraw_qty'];
                $uom = $item['uom'];
                $uomId = $item['uomid'];
                $item_description = $item['item_description'];
                $item_category = $item['item_category'];
                $return_date = $item['return_date'];
                $reason = $item['reason'];

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
                    $newReturnLog = new Returns();
                    $newReturnLog->request_number = $requestId;
                    $newReturnLog->requestor_name = $requestorName;
                    $newReturnLog->requestor_id = $requestorId;
                    $newReturnLog->process_id = $process_id;
                    $newReturnLog->remarks = $remarks;
                    $newReturnLog->subsidiaryid = $subsidiaryid;
                    $newReturnLog->subsidiary_name = $subsidiary_name;
                    $newReturnLog->withdraw_qty = $withdraw_qty;
                    $newReturnLog->item_code = $itemCode;
                    $newReturnLog->item_description = $item_description;
                    $newReturnLog->item_category = $item_category;
                    $newReturnLog->returned_qty = $returned_qty;
                    $newReturnLog->return_date = $return_date;
                    $newReturnLog->uom = $uom;
                    $newReturnLog->uomid = $uomId;
                    $newReturnLog->status = 0;
                    $newReturnLog->hierarchy = 1;
                    $newReturnLog->reason = $reason;
                    $newReturnLog->save();
                    $returnLogs[] = $newReturnLog;

                    if ($newReturnLog->id) {
                        \Log::info("New Return log ID: " . $newReturnLog->id);

                        foreach ($request->approvals as $index => $approval) {
                            $newApproval = new Approval(); 
                            $newApproval->process = 'return'; 
                            $newApproval->process_id = $newReturnLog->id; 
                            $newApproval->approver_id = $approval['approver_id'];
                            $newApproval->approver_name = $approval['approver_name'];
                            $newApproval->hierarchy = $approval['hierarchy'];

                            try {
                                $newApproval->save(); 
                                \Log::info("Approval saved for approver: " . $approval['approver_name']);
                            } catch (\Exception $e) {
                                dd($e);
                                \Log::error("Failed to save approval for approver: " . $approval['approver_name'] . ". Error: " . $e->getMessage());
                            }
                        }
                    } else {
                        \Log::error("Failed to retrieve the return log ID after saving.");
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to retrieve return log ID.',
                        ], 500);
                    }   
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Return request has been logged and is pending approval.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create return request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function searchReturn(Request $request)
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

            $returnQueryResult = Returns::query()
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
                'data' => $returnQueryResult->items(),
                'pagination' => [
                    'current_page' => $returnQueryResult->currentPage(),
                    'total_pages' => $returnQueryResult->lastPage(),
                    'total_items' => $returnQueryResult->total(),
                    'per_page' => $returnQueryResult->perPage(),
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

    public function getReturnSuggestions(Request $request)
    {
        try {
            // Validate the inputs
            $request->validate([
                'subsidiaryId' => 'required|integer',
                'searchTerm' => 'nullable|string|max:255',
            ]);

            $subsidiaryId = $request->input('subsidiaryId');
            $searchTerm = $request->input('searchTerm');

            $items = WithdrawalItems::join('withdrawals', 'withdrawal_items.withdrawal_id', '=', 'withdrawals.id')
                ->where('withdrawals.request_number', 'LIKE', '%' . $searchTerm . '%')
                ->where('withdrawal_items.status', 2)
                ->where('withdrawals.subsidiaryid', $subsidiaryId)
                ->select('withdrawals.request_number')
                ->limit(10)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $items,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Failed to fetch return suggestions: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch inventory.',
                'error' => $e,
            ], 500);
        }
    }

    public function returnSearchItem(Request $request)
    {
        $requestId = $request->request_id;
        $subsidiaryId = $request->subsidiary_id;

        try {
            $items = WithdrawalItems::join('withdrawals', 'withdrawal_items.withdrawal_id', '=', 'withdrawals.id')
                ->join('uoms', 'withdrawal_items.uom_id', '=', 'uoms.id') // Join with the UOM table
                ->where('withdrawals.request_number', $requestId)
                ->where('withdrawal_items.status', 2)
                ->where('withdrawals.subsidiaryid', $subsidiaryId)
                ->select(
                    'withdrawal_items.*', 
                    'withdrawals.*', 
                    'uoms.*'
                )
                ->get();
            if ($items->isNotEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $items,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No matching item details found.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch item details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function approveReturn(Request $request, $transactId)
    {
        try {
            $returns = Returns::where('id', $transactId)->firstOrFail();

            if ($returns->status === 1) {
                return $this->processReturn($request, $transactId);
            } elseif ($returns->status !== 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This return request is not pending and cannot be approved.',
                ], 400);
            }

            $currentHierarchy = Approval::where('process_id', $transactId)
                ->where('process', 'return')
                ->where('approver_id', $request->input('approver_id'))
                ->value('hierarchy');

            if (!$currentHierarchy) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to approve this return request at this stage.',
                ], 403);
            }

            $returnQty = $request->input('return_qty');
            if ($returnQty && $returnQty > 0) {
                $returns->returned_qty = $returnQty; 
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid released quantity provided.',
                ], 400);
            }

            $newReturnHierarchy = $returns->hierarchy + 1;
            $returns->hierarchy = $newReturnHierarchy; 
            $returns->save();

            $nextApprovalExists = Approval::where('process_id', $transactId)
            ->where('process', 'return')
            ->where('hierarchy', $newReturnHierarchy)
            ->exists();

            if ($nextApprovalExists) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Return request approved at this level. Waiting for next approver.',
                ], 200);
            }

            $returns->status = 1;
            $returns->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Return request is now marked as "Receiving". Requester will handle final approval.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to approve return request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function declineWithdraw(Request $request, $transactId)
    {
        try {
            $withdrawal = WithdrawalItems::where('id', $transactId)->firstOrFail();

            $withdrawal->status = $withdrawal->status === 0 ? 4 : 5;

            if ($request->has('remarks')) {
                $withdrawal->remarks = $request->input('remarks');
            }

            $withdrawal->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Withdraw status updated successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to decline withdraw.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function declineReturn(Request $request, $transactId)
    {
        try {
            $returns = Returns::where('id', $transactId)->firstOrFail();

            $returns->status = $withdrawal->status === 0 ? 4 : 5;

            if ($request->has('remarks')) {
                $returns->remarks = $request->input('remarks');
            }

            $returns->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Return status updated successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to decline return.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
