<?php

namespace App\Http\Controllers;

use App\PurchaseOrder;
use App\PurchaseRequest;
use App\RfqEmail;
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

        $purchase_request = PurchaseRequest::doesntHave('purchaseOrder')->where('status','For Canvassing')->get();
        $vendors = RfqEmail::get();
        
        $purchase_order = PurchaseOrder::with('purchaseRequest')->get();
        
        return view('purchased_order',compact('start_date','end_date','purchase_request','purchase_order','vendors'));
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
        $purchase_order = new PurchaseOrder();
        $purchase_order->purchase_request_id = $request->purchase_request;
        $purchase_order->supplier_id = $request->vendor;
        $purchase_order->status = 'Pending';
        $purchase_order->expected_delivery_date = $request->expected_delivery_date;
        $purchase_order->save();

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
        $po = PurchaseOrder::with('purchaseRequest.rfqItem.purchaseItem.inventory', 'supplier')->findOrFail($id);

        return view('purchase_orders.view_purchase_order', compact('po'));
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
        try {
            $purchase_order = PurchaseOrder::with('purchaseRequest.rfqItem.purchaseItem.inventory', 'supplier')->findOrFail($request->id);

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
                "custbody8" => "Generate GRN upon completion.",
                "custbody36" => [
                    "id" => $purchase_order->purchaseRequest->assignedTo->id,
                    "refName" => $purchase_order->purchaseRequest->assignedTo->name
                ],
                // Requestor
                "custbody38" => [
                    "id" => auth()->user()->id,
                    "refName" => auth()->user()->name
                ],
                "employee" => [
                    "id" => $purchase_order->purchaseRequest->assignedTo->id,
                    "refName" => $purchase_order->purchaseRequest->assignedTo->name
                ],
                "currency" => [
                    "id" => "1",
                    "refName" => "Philippine Peso"
                ],
                "exchangeRate" => 1.0,
                "shippingAddress" => $purchase_order->purchaseRequest->company->address,
                "item" => [
                    "items" => $items_array
                ]
            ];
            
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

            $client->post('purchaseOrder', [
                // 'headers' => $headers,
                'json' => $data,
            ]);

            Alert::success('Successfully Approved')->persistent('Dismiss');
            return back();

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
}
