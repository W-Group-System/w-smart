<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Subcategories;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::with('subCategory')->get();

        return view('category', compact('categories'));
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
        $category = new Categories();
        $category->name = $request->category_name;
        $category->save();

        foreach($request->sub_category as $sub_category)
        {
            $subcategory = new Subcategories();
            $subcategory->category_id = $category->id;
            $subcategory->name = $sub_category;
            $subcategory->save();
        }

        Alert::success('Successfully Saved')->persistent("Dismiss");
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
        //
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
        // dd($request->all());
        $category = Categories::findOrFail($id);
        $category->name = $request->category_name;
        $category->save();

        $subcategory = Subcategories::where('category_id', $id)->delete();
        foreach($request->sub_category as $sub_category)
        {
            $subcategory = new Subcategories();
            $subcategory->category_id = $category->id;
            $subcategory->name = $sub_category;
            $subcategory->save();
        }

        Alert::success('Successfully Updated')->persistent("Dismiss");
        return back();
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
}
