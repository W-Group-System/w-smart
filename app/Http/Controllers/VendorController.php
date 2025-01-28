<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplierAccreditation;

class VendorController extends Controller
{
    public function getVendorName(Request $request)
    {
        $vendorId = $request->vendor_id;

        // Fetch the vendor by ID
        $vendor = SupplierAccreditation::find($vendorId);

        if ($vendor) {
            // Return corporate_name as JSON response
            return response()->json([
                'corporate_name' => $vendor->corporate_name,
            ]);
        }

        // Return an error response if vendor not found
        return response()->json([
            'corporate_name' => null,
            'error' => 'Vendor not found',
        ], 404);
    }
}
