<?php

namespace App\Http\Controllers;

use App\Grn;
use App\GrnItemHistory;
use App\PurchaseApprover;
use App\PurchaseOrder;
use App\PurchaseOrderApprover;
use App\PurchaseOrderItem;
use App\PurchaseRequest;
use App\RfqEmail;
use App\RfqItem;
use App\SupplierAccreditation;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $purchase_request = PurchaseRequest::with('rfqItem')->doesntHave('purchaseOrder')->where('status','For Canvassing')->get();
        $vendors = RfqEmail::get();
        
        $purchase_order = PurchaseOrder::with('purchaseRequest')->get();
        $purchase_approvers = PurchaseApprover::get();

        $stack = HandlerStack::create();
            
        $middleware = new Oauth1([
            'consumer_key'    => env('CONSUMER_KEY'),
            'consumer_secret' => env('CONSUMER_SECRET'),
            'token'           => env('TOKEN'),
            'token_secret'    => env('TOKEN_SECRET'),
            'realm' => env('REALM_ID'),
            'signature_method' => 'HMAC-SHA256'
        ]);
        
        $stack->push($middleware);

        $client = new Client([
            'base_uri' => env('NETSUITE_URL'),
            'handler' => $stack,
            'auth' => 'oauth',
        ]);
        
        $response = $client->post(env('NETSUITE_QUERY_URL'), [
            'headers' => [
                'prefer' => 'transient'
            ],
            'json' => [
                'q' => "SELECT tranid FROM transaction WHERE abbrevtype = 'PURCHORD' ORDER BY id DESC", 
            ],
            'query' => [
                'limit' => 1
            ]
        ]);
        
        $po_data = json_decode($response->getBody()->getContents());
        $po_number = collect($po_data->items)->first()->tranid;
        
        return view('purchased_order',compact('start_date','end_date','purchase_request','purchase_order','vendors','po_number','purchase_approvers'));
        // return view('purchased_order',compact('start_date','end_date','purchase_request','purchase_order','vendors','purchase_approvers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $purchase_order = PurchaseOrder::orderBy('id','desc')->first();
        if ($purchase_order) 
        {
            $get_number = substr($purchase_order->purchase_order_no, 3);
            $number = $get_number + 1;
            
            $purchase_order_no = 'PO'.str_pad($number, 6, '0', STR_PAD_LEFT);
        }
        else
        {
            $get_number = substr($request->purchase_order_no, 3);
            $number = $get_number + 1;
            
            $purchase_order_no = 'PO'.str_pad($number, 6, '0', STR_PAD_LEFT);
        }
        
        $purchase_order = new PurchaseOrder();
        $purchase_order->purchase_order_no = $purchase_order_no;
        $purchase_order->purchase_request_id = $request->purchase_request;
        $purchase_order->supplier_id = $request->vendor;
        $purchase_order->status = 'Pending';
        $purchase_order->expected_delivery_date = $request->expected_delivery_date; 
        $purchase_order->save();

        foreach($request->purchaseOrderItem as $purchaseOrderItem)
        {
            $po_item = new PurchaseOrderItem;
            $po_item->inventory_id = $purchaseOrderItem;
            $po_item->purchase_order_id = $purchase_order->id;
            $po_item->save();
        }

        $purchase_approvers = PurchaseApprover::where('level', 2)->orderBy('level','asc')->get();
        foreach($purchase_approvers as $key=>$purchase_approver)
        {
            $pr_approver = new PurchaseOrderApprover();
            $pr_approver->purchase_order_id = $purchase_order->id;
            $pr_approver->user_id = $purchase_approver->user_id;
            $pr_approver->level = $purchase_approver->level;
            if ($key == 0)
            {
                $pr_approver->status = 'Pending';
            }
            else
            {
                $pr_approver->status = 'Waiting';
            }
            $pr_approver->save();
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $start_date = $request->start_date;
        $po = PurchaseOrder::with('purchaseRequest.rfqItem.purchaseItem.inventory', 'supplier', 'purchaseOrderItem.inventory', 'purchaseOrderApprovers')->findOrFail($id);

        $middleware = new Oauth1([
            'consumer_key'    => env('CONSUMER_KEY'),
            'consumer_secret' => env('CONSUMER_SECRET'),
            'token'           => env('TOKEN'),
            'token_secret'    => env('TOKEN_SECRET'),
            'realm' => env('REALM_ID'),
            'signature_method' => 'HMAC-SHA256'
        ]);

        $stack = HandlerStack::create();
        
        $stack->push($middleware);

        $client = new Client([
            'base_uri' => env('NETSUITE_URL'),
            'handler' => $stack,
            'auth' => 'oauth',
        ]);

        $response = $client->post(env('NETSUITE_QUERY_URL'), [
            'headers' => [
                'Prefer' => 'transient'
            ],
            'json' => [
                'q' => "SELECT tranid FROM transaction WHERE abbrevtype = 'ITEM RCP' ORDER BY id DESC", 
            ],
            'query' => [
                'limit' => 1
            ]
        ]);

        $data = $response->getBody()->getContents();
        $item_receipt = json_decode($data);
        $latest_grn = collect($item_receipt->items)->first();
        
        $po_response = $client->post(env('NETSUITE_QUERY_URL'),[
            'headers' => [
                'Prefer' => 'transient'
            ],
            'json' => [
                'q' => "SELECT id, tranId FROM transaction WHERE abbrevtype = 'PURCHORD' AND tranId='".$po->purchase_order_no."' ORDER BY id DESC", 
            ],
            'query' => [
                'limit' => 1
            ]
        ]);
        $response = json_decode($po_response->getBody()->getContents());
        $po_data = collect($response->items)->first();
        
        return view('purchase_orders.view_purchase_order', compact('po', 'latest_grn', 'po_data'));
        // return view('purchase_orders.view_purchase_order', compact('po'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function refreshRfqVendor(Request $request)
    {
        $rfq_email = RfqEmail::where('purchase_request_id', $request->data)->pluck('supplier_id')->toArray();
        
        $suppliers = SupplierAccreditation::whereIn('id', $rfq_email)->get();

        $options = '<option value="">Select Vendor</option>'; // Default option
        foreach ($suppliers as $supplier) {
            $options .= '<option value="' . $supplier->id . '">' . $supplier->corporate_name. ' - '. $supplier->billing_email . '</option>';
        }
        
        return response()->json($options);
    }

    public function approved(Request $request)
    {
        // dd($request->all());
        try {
            $purchase_order_approvers = PurchaseOrderApprover::where('purchase_order_id', $request->id)->where('status','Pending')->first();
            $purchase_order_approvers->status = 'Approved';
            $purchase_order_approvers->save();

            $purchase_order_approvers = PurchaseOrderApprover::where('status', 'Waiting')->orderBy('level','asc')->get();
            
            if($purchase_order_approvers->isNotEmpty())
            {
                foreach($purchase_order_approvers as $key=>$po_approver)
                {
                    if ($key == 0)
                    {
                        $po_approver->status = 'Pending';
                    }
                    else
                    {
                        $po_approver->status = 'Waiting';
                    }
    
                    $po_approver->save();
                }
            }
            else
            {
                $purchase_order = PurchaseOrder::with('purchaseRequest.rfqItem.purchaseItem.inventory', 'supplier')->findOrFail($request->id);
                $purchase_order->status = 'Approved';
                $purchase_order->save();

                $items_array = [];
                foreach($purchase_order->purchaseRequest->rfqItem as $rfq_item)
                {
                    $items_array[] = [
                        'item' => [
                            'id' => $rfq_item->purchaseItem->inventory->inventory_id,
                            'refName' => $rfq_item->purchaseItem->inventory->item_code
                        ]
                    ];
                }
                
                $data = [
                    "tranDate" => date('Y-m-d'),
                    "dueDate" => date('Y-m-d', strtotime($purchase_order->expected_delivery_date)),
                    // Vendor
                    "entity" => [
                        "id" => $purchase_order->supplier->id,
                        "refName" =>  $purchase_order->supplier->corporate_name
                    ],
                    // "entity" => [
                    //     "id" => 16150,
                    //     "refName" =>  'DPLUS SIGN ADVERTISING CORPORATION'
                    // ],
                    "location" => [
                        "id" => "1",
                        "refName" => "Head Office"
                    ],
                    "department" => [
                        "id" => $purchase_order->purchaseRequest->department->id,
                        "refName" => $purchase_order->purchaseRequest->department->name
                    ],
                    "class" => [
                        "id" => $purchase_order->purchaseRequest->classification->id,
                        "refName" => $purchase_order->purchaseRequest->classification->name
                    ],
                    // Task Memo
                    "custbody8" => "Generate GRN upon completion.",
                    // Task Assigned To
                    "custbody36" => [
                        "id" => $purchase_order->purchaseRequest->assignedTo->id,
                        "refName" => $purchase_order->purchaseRequest->assignedTo->name
                    ],
                    // Requestor
                    "custbody38" => [
                        "id" => auth()->user()->id,
                        "refName" => auth()->user()->name
                    ],
                    // Approver
                    "custbody41" => [
                        "id" => "15566",
                        "refName" => "Jemirald D Cerilla"
                    ],
                    // Special Instruction
                    "custbody39" => "*** IMPORTANT! PAYMENT INSTRUCTIONS ***\r\n\r\nCOMPANY NAME: W Tower Condominium Corporation\r\nADDRESS: 0001 W Tower, 39th Street, North Bonifacio Triangle, Bonifacio Global City, Taguig City\r\nT.I.N. No.: 008-019-430-000\r\nBUSINESS STYLE: W Tower Condominium Corporation",
                    // Assigned To
                    "employee" => [
                        "id" => $purchase_order->purchaseRequest->assignedTo->id,
                        "refName" => $purchase_order->purchaseRequest->assignedTo->name
                    ],
                    "currency" => [
                        "id" => "1",
                        "refName" => "Philippine Peso"
                    ],
                    "exchangeRate" => 1.0,
                    "shippingAddress" => $purchase_order->purchaseRequest->company->shipping_address,
                    "approvalStatus" => [
                        "id" => "2"
                    ],
                    "item" => [
                        "items" => $items_array
                    ]
                ];

                $middleware = new Oauth1([
                    'consumer_key'    => env('CONSUMER_KEY'),
                    'consumer_secret' => env('CONSUMER_SECRET'),
                    'token'           => env('TOKEN'),
                    'token_secret'    => env('TOKEN_SECRET'),
                    'realm' => env('REALM_ID'),
                    'signature_method' => 'HMAC-SHA256'
                ]);
        
                $stack = HandlerStack::create();
                
                $stack->push($middleware);

                $client = new Client([
                    'base_uri' => env('NETSUITE_URL'),
                    'handler' => $stack,
                    'auth' => 'oauth',
                ]);
    
                $client->post('purchaseOrder', [
                    'json' => $data,
                ]);
            }

            Alert::success('Successfully Approved')->persistent('Dismiss');
            return back();

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function received(Request $request,$id)
    {
        // dd($request->all());
        try {
            $grn_data = Grn::orderBy('id','desc')->first();
            if ($grn_data)
            {
                $grn = substr($grn_data->grn_no,4);
                $number = $grn+1;
            }
            else
            {
                $number = '00001';
            }
            $grn_display = "GRN".str_pad($number, 6, '0', STR_PAD_LEFT);

            $status = collect($request->actual_qty)->every(function($item, $key)use($request) {
                return $item == $request->received_qty[$key];
            });

            $display_status = '';
            if ($status)
            {
                $display_status = 'Fully Received';
            }
            else
            {
                $display_status = 'Partial Received';
            }

            $purchase_order = PurchaseOrder::findOrFail($id);
            $purchase_order->status = $display_status;
            $purchase_order->save();

            $grn = new Grn;
            $grn->purchase_order_id = $id;
            $grn->grn_no = $grn_display;
            $grn->save();

            foreach($request->inventory_id as $key=>$inventory)
            {
                $purchase_order_item = PurchaseOrderItem::where('inventory_id', $inventory)->first();
                $purchase_order_item->qty = $request->received_qty[$key];
                $purchase_order_item->save();

                $grn_item_history = new GrnItemHistory;
                $grn_item_history->grn_id = $grn->id;
                $grn_item_history->inventory_id = $inventory;
                $grn_item_history->purchase_order_id = $id;
                $grn_item_history->received_qty =  $request->received_qty[$key];
                $grn_item_history->save();
            }
            
            // $items_array = [];
            // foreach($request->line as $lineKey => $line)
            // {
            //     $items_array[] = [
            //         'orderLine' => (int)$line,
            //         'quantity' => isset($request->qty[$lineKey]) ? (int)$request->qty[$lineKey] : 0,
            //         'itemReceive' => isset($request->receive_item[$lineKey]) ? true : false
            //     ];
            // }
            
            // $data = [
            //     "item" => [
            //         'items' => $items_array
            //     ],
            // ];
            
            // $stack = HandlerStack::create();
                
            // $middleware = new Oauth1([
            //     'consumer_key'    => env('CONSUMER_KEY'),
            //     'consumer_secret' => env('CONSUMER_SECRET'),
            //     'token'           => env('TOKEN'),
            //     'token_secret'    => env('TOKEN_SECRET'),
            //     'realm' => env('REALM_ID'),
            //     'signature_method' => 'HMAC-SHA256'
            // ]);
            
            // $stack->push($middleware);

            // $client = new Client([
            //     'base_uri' => env('NETSUITE_URL'),
            //     'handler' => $stack,
            //     'auth' => 'oauth',
            // ]);

            // $client->post('purchaseOrder/'.$request->po_id.'/!transform/itemReceipt', [
            //     'json' => $data,
            // ]);

            Alert::success('Successfully Received')->persistent('Dismiss');
            return back();

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function cancelled($id)
    {
        $purchase_order = PurchaseOrder::findOrFail($id);
        $purchase_order->status = 'Cancelled';
        $purchase_order->save();

        Alert::success("Successfully Cancelled")->persistent('Dismiss');
        return back();
    }

    public function refreshRfqItem(Request $request)
    {
        $rfq_items_array = [];

        $rfqs = RfqItem::with('purchaseItem.inventory')->where('purchase_request_id', $request->data)->get();

        foreach($rfqs as $rfq)
        {
            $rfq_items_array[] = $rfq->purchaseItem->inventory;
        } 
        
        return response()->json([
            'rfq' => $rfq_items_array
        ]);
    }

    public function viewGrn($id)
    {
        $grn = Grn::with('purchaseOrder')->findOrFail($id);

        return view('grn.view_grn', compact('grn'));
    }
}
