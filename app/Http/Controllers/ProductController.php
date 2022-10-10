<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {

        $products = Product::all();
        $sections = Section::all();

        return view('products.index',compact('products','sections'));
    }


    public function create()
    {
        //
    }


    public function store(ProductRequest $request)
    {
        try {

            Product::create([
                'name'=>$request->name,
                'section_id'=>$request->section,
                'description'=>$request->description
            ]);

            session()->flash('success','تم اضافة المنتج بنجاح');
            return redirect()->back();


        }
        catch (\Exception $e){

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
          }
    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(ProductRequest $request)
    {

        $product = Product::findorFail($request->id);
        try {
            $product->update([
                'name'=>$request->name,
                'section_id'=>$request->section,
                'description'=>$request->description
            ]);

            session()->flash('success','تم تعديل المنتج بنجاح');
            return redirect()->back();
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        Product::destroy($id);
        session()->flash('success','تم حذف المنتج بنجاح');
        return redirect()->back();
    }
}
