<?php

namespace App\Http\Controllers;
use App\User;
use App\SupplierAccreditation;
use App\SupplierAccreditationRep;
use App\SupplierAccreditationOwner;
use App\SupplierAccreditationContact;
use App\SupplierAccreditationReference;
use App\SupplierAccreditationCustomer;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{
    // List
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = User::where('status','Active')->pluck('name','id');
        $supplier_accreditation = SupplierAccreditation::when($start_date || $end_date, function($query) use ($start_date,$end_date){
                $query->whereBetween('created_at',[$start_date.' 00:00:01',$end_date.' 23:59:59']);
            })
            ->paginate(10);
        // $get_pr_no = PurchaseRequest::orderBy('id','desc')->first();
        // dd($users);
        return view('supplier_accreditation.index', compact('supplier_accreditation', 'users','start_date','end_date'));
    }

    // Create
    public function create()
    {
        return view('supplier_accreditation.create');
    }

    // Store
    public function store(Request $request)
    {
        
        $supplier_accreditation = SupplierAccreditation::create($request->only([
            'vendor_code', 'relationship', 'corporate_name', 'telephone_no', 'fax_no', 'trade_name', 'business_address', 'billing_address', 'billing_telephone', 'billing_fax', 'billing_email', 'billing_years', 'nature_business', 'registration_no', 'date_registered', 'billing_tin', 'taxpayer_classification', 'lease_date', 'handover', 'attachments', 'suppliers_terms', 'suppliers_specify', 'status'
        ]));

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');
    
            // Update the record with the file path
            $supplier_accreditation->update(['attachments' => $filePath]);
        }

        if ($request->hasFile('suppliers_attachments')) {
            $file = $request->file('suppliers_attachments');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');
    
            // Update the record with the file path
            $supplier_accreditation->update(['suppliers_attachments' => $filePath]);
        }
        
        if ($request->has('name') && $request->has('designation')) {
            foreach ($request->name as $key => $name) {
                if (!empty($name) && !empty($request->name[$key])) {
                    SupplierAccreditationRep::create([
                        'accreditation_id' => $supplier_accreditation->id,
                        'name' => $name,
                        'designation' => $request->designation[$key],
                        'contact' => $request->contact[$key],
                        'email' => $request->email[$key]
                    ]);
                }
            }
        }

        if ($request->has('owners') && $request->has('owners_designation')) {
            foreach ($request->owners as $key => $owners) {
                if (!empty($owners) && !empty($request->owners[$key])) {
                    SupplierAccreditationOwner::create([
                        'accreditation_id' => $supplier_accreditation->id,
                        'owners' => $owners,
                        'owners_designation' => $request->owners_designation[$key],
                        'address' => $request->address[$key],
                    ]);
                }
            }
        }

        if ($request->has('contacts') && $request->has('contacts_designation')) {
            foreach ($request->contacts as $key => $contacts) {
                if (!empty($contacts) && !empty($request->contacts[$key])) {
                    SupplierAccreditationContact::create([
                        'accreditation_id' => $supplier_accreditation->id,
                        'contacts' => $contacts,
                        'contacts_designation' => $request->contacts_designation[$key],
                        'contact_number' => $request->contact_number[$key],
                        'contacts_email' => $request->contacts_email[$key],
                    ]);
                }
            }
        }

        if ($request->has('company_name') && $request->has('contact_person')) {
            foreach ($request->company_name as $key => $company_name) {
                if (!empty($company_name) && !empty($request->company_name[$key])) {
                    SupplierAccreditationReference::create([
                        'accreditation_id' => $supplier_accreditation->id,
                        'company_name' => $company_name,
                        'contact_person' => $request->contact_person[$key],
                        'tel_no' => $request->tel_no[$key],
                        'terms' => $request->terms[$key],
                    ]);
                }
            }
        }

        if ($request->has('customer_company_name') && $request->has('customer_contact_person')) {
            foreach ($request->customer_company_name as $key => $customer_company_name) {
                if (!empty($customer_company_name) && !empty($request->customer_company_name[$key])) {
                    SupplierAccreditationCustomer::create([
                        'accreditation_id' => $supplier_accreditation->id,
                        'customer_company_name' => $customer_company_name,
                        'customer_contact_person' => $request->customer_contact_person[$key],
                        'customer_tel_no' => $request->customer_tel_no[$key],
                        'customer_terms' => $request->customer_terms[$key],
                    ]);
                }
            }
        }

        if ($request->hasFile('company_profile')) {
            $file = $request->file('company_profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['company_profile' => $filePath]);
        }

        if ($request->hasFile('audited_financial')) {
            $file = $request->file('audited_financial');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['audited_financial' => $filePath]);
        }

        if ($request->hasFile('office_location')) {
            $file = $request->file('office_location');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['office_location' => $filePath]);
        }

        if ($request->hasFile('business_permit')) {
            $file = $request->file('business_permit');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['business_permit' => $filePath]);
        }

        if ($request->hasFile('sec_registration')) {
            $file = $request->file('sec_registration');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['sec_registration' => $filePath]);
        }

        if ($request->hasFile('tax_incentive')) {
            $file = $request->file('tax_incentive');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['tax_incentive' => $filePath]);
        }

        if ($request->hasFile('articles')) {
            $file = $request->file('articles');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['articles' => $filePath]);
        }

        if ($request->hasFile('bir_documents')) {
            $file = $request->file('bir_documents');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['bir_documents' => $filePath]);
        }

        if ($request->hasFile('information_sheet')) {
            $file = $request->file('information_sheet');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['information_sheet' => $filePath]);
        }

        // Redirect or return a response
        return redirect()->back()->with('success', 'Supplier Accreditation submitted successfully!');
    }

    public function view($id)
    {
        $supplier_accreditation = SupplierAccreditation::with('user', 'representative', 'owners', 'contacts', 'references', 'customers')->findOrFail($id);
        $users = User::where('status','Active')->pluck('name','id');
        // dd($supplier_accreditation);
        
        return view('supplier_accreditation.view', compact('supplier_accreditation','users'));
    }

    public function edit($id)
    {
        $data = SupplierAccreditation::with('user', 'representative', 'owners', 'contacts', 'references', 'customers')->findOrFail($id);

        return view('supplier_accreditation.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $supplier_accreditation = SupplierAccreditation::findOrFail($id);
        $supplier_accreditation->relationship = $request->relationship;
        $supplier_accreditation->corporate_name = $request->corporate_name;
        $supplier_accreditation->telephone_no = $request->telephone_no;
        $supplier_accreditation->fax_no = $request->fax_no;
        $supplier_accreditation->trade_name = $request->trade_name;
        $supplier_accreditation->business_address = $request->business_address;
        $supplier_accreditation->billing_address = $request->billing_address;
        $supplier_accreditation->billing_telephone = $request->billing_telephone;
        $supplier_accreditation->billing_fax = $request->billing_fax;
        $supplier_accreditation->billing_email = $request->billing_email;
        $supplier_accreditation->billing_years = $request->billing_years;
        $supplier_accreditation->nature_business = $request->nature_business;
        $supplier_accreditation->registration_no = $request->registration_no;
        $supplier_accreditation->date_registered = $request->date_registered;
        $supplier_accreditation->billing_tin = $request->billing_tin;
        $supplier_accreditation->taxpayer_classification = $request->taxpayer_classification;
        $supplier_accreditation->lease_date = $request->lease_date;
        $supplier_accreditation->handover = $request->handover;
        $supplier_accreditation->suppliers_terms = $request->suppliers_terms;
        $supplier_accreditation->suppliers_specify = $request->suppliers_specify;

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');
    
            // Update the record with the file path
            $supplier_accreditation->update(['attachments' => $filePath]);
        }

        if ($request->hasFile('suppliers_attachments')) {
            $file = $request->file('suppliers_attachments');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');
    
            // Update the record with the file path
            $supplier_accreditation->update(['suppliers_attachments' => $filePath]);
        }

        $supplier_accreditation_rep = SupplierAccreditationRep::where('accreditation_id', $id)->delete();
        foreach($request->name as $key=>$name)
        {
            $supplier_accreditation_rep = new SupplierAccreditationRep;
            $supplier_accreditation_rep->accreditation_id = $id;
            $supplier_accreditation_rep->name = $name;
            $supplier_accreditation_rep->designation = $request->designation[$key];
            $supplier_accreditation_rep->contact = $request->contact[$key];
            $supplier_accreditation_rep->email = $request->email[$key];
            $supplier_accreditation_rep->save();
        }

        $supplier_accreditation_owner = SupplierAccreditationOwner::where('accreditation_id', $id)->delete();
        foreach($request->owners as $key=>$owners)
        {
            $supplier_accreditation_owner = new SupplierAccreditationOwner;
            $supplier_accreditation_owner->accreditation_id = $id;
            $supplier_accreditation_owner->owners = $owners;
            $supplier_accreditation_owner->owners_designation = $request->owners_designation[$key];
            $supplier_accreditation_owner->address = $request->address[$key];
            $supplier_accreditation_owner->save();
        }

        $supplier_accreditation_contact = SupplierAccreditationContact::where('accreditation_id', $id)->delete();
        foreach($request->contacts as $key=>$contacts)
        {
            $supplier_accreditation_contact = new SupplierAccreditationContact;
            $supplier_accreditation_contact->accreditation_id = $id;
            $supplier_accreditation_contact->contacts = $contacts;
            $supplier_accreditation_contact->contacts_designation = $request->contacts_designation[$key];
            $supplier_accreditation_contact->contact_number = $request->contact_number[$key];
            $supplier_accreditation_contact->contacts_email = $request->contacts_email[$key];
            $supplier_accreditation_contact->save();
        }

        $supplier_accreditation_ref = SupplierAccreditationReference::where('accreditation_id', $id)->delete();
        foreach($request->company_name as $key=>$company_name)
        {
            $supplier_accreditation_ref = new SupplierAccreditationReference;
            $supplier_accreditation_ref->accreditation_id = $id;
            $supplier_accreditation_ref->company_name = $company_name;
            $supplier_accreditation_ref->contact_person = $request->contact_person[$key];
            $supplier_accreditation_ref->tel_no = $request->tel_no[$key];
            $supplier_accreditation_ref->terms = $request->terms[$key];
            $supplier_accreditation_ref->save();
        }

        $supplier_accreditation_customer = SupplierAccreditationCustomer::where('accreditation_id', $id)->delete();
        foreach($request->customer_company_name as $key=>$customer_company_name)
        {
            $supplier_accreditation_customer = new SupplierAccreditationCustomer;
            $supplier_accreditation_customer->accreditation_id = $id;
            $supplier_accreditation_customer->customer_company_name = $customer_company_name;
            $supplier_accreditation_customer->customer_contact_person = $request->customer_contact_person[$key];
            $supplier_accreditation_customer->customer_tel_no = $request->customer_tel_no[$key];
            $supplier_accreditation_customer->customer_terms = $request->customer_terms[$key];
            $supplier_accreditation_customer->save();
        }

        if ($request->hasFile('company_profile')) {
            $file = $request->file('company_profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['company_profile' => $filePath]);
        }

        if ($request->hasFile('audited_financial')) {
            $file = $request->file('audited_financial');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['audited_financial' => $filePath]);
        }

        if ($request->hasFile('office_location')) {
            $file = $request->file('office_location');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['office_location' => $filePath]);
        }

        if ($request->hasFile('business_permit')) {
            $file = $request->file('business_permit');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['business_permit' => $filePath]);
        }

        if ($request->hasFile('sec_registration')) {
            $file = $request->file('sec_registration');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['sec_registration' => $filePath]);
        }

        if ($request->hasFile('tax_incentive')) {
            $file = $request->file('tax_incentive');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['tax_incentive' => $filePath]);
        }

        if ($request->hasFile('articles')) {
            $file = $request->file('articles');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['articles' => $filePath]);
        }

        if ($request->hasFile('bir_documents')) {
            $file = $request->file('bir_documents');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['bir_documents' => $filePath]);
        }

        if ($request->hasFile('information_sheet')) {
            $file = $request->file('information_sheet');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supplier_accreditation_files', $fileName, 'public');

            $supplier_accreditation->update(['information_sheet' => $filePath]);
        }

        $supplier_accreditation->update();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
    }

    public function approved(Request $request, $id) 
    {
        $supplier_accreditation = SupplierAccreditation::findOrFail($id);
        $supplier_accreditation->approved_remarks = $request->approved_remarks;
        $supplier_accreditation->status = 'Approved';
        $supplier_accreditation->save();

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return redirect()->back();
    }

    public function declined(Request $request, $id) 
    {
        $supplier_accreditation = SupplierAccreditation::findOrFail($id);
        $supplier_accreditation->declined_remarks = $request->declined_remarks;
        $supplier_accreditation->status = 'Declined';
        $supplier_accreditation->save();

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return redirect()->back();
    }
}
