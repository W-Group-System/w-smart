<?php

use App\Features;
use App\PurchaseOrderApprover;
use App\PurchaseRequest;
use App\PurchaseRequestApprover;
use App\Subfeatures;
use App\UserAccessModule;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

function checkRoles($role_id, $name="")
{
    $subfeatures = Subfeatures::where('subfeature_name', $name)->first();
    
    if ($subfeatures)
    {
        $module = UserAccessModule::where('role_id', $role_id)->where('subfeature_id', $subfeatures->id)->first();
        if ($module)
        {
            return true;
        }
    }
    
    return false;
}
function checkModule($role_id, $name="")
{
    $feature = Features::where('feature', $name)->first();
    
    if ($feature)
    {
        $module = UserAccessModule::where('role_id', $role_id)->where('feature_id', $feature->id)->first();
        if ($module)
        {
            return true;
        }
    }
    
    return false;
}
function for_approval_count()
{
    $pr_count = PurchaseRequestApprover::with('purchase_request')->where('status','Pending')->where('user_id', auth()->user()->id)->count();

    $po_count = PurchaseOrderApprover::where('status','Pending')->where('user_id', auth()->user()->id)->count();
    
    $count = $pr_count + $po_count;

    return $count;
}
function assign_count()
{
    return PurchaseRequest::whereNull('assigned_to')->count();
}
function count_rfq($assigned_to)
{
    return PurchaseRequest::where('assigned_to', $assigned_to)->where('status', 'For RFQ')->count();
}