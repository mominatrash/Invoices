<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Random\Engine\Secure;

class ProductController extends Controller
{
    public function products(){

        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('products','sections'));
    }

    public function insert_product(Request $request)
    {
      
        
        $validation = $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'description' => 'required'
        ], [

            'product_name.required' => 'الرجاء إدخال اسم القسم',
            'product_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'الرجاء إدخال وصف للقسم'


        ]);

        
            $n=new Product();
            $n->product_name=$request->product_name;
            $n->description=$request->description;
            $n->section_id = $request->section_id;
            $n->save();
            session()->flash('Add','تم اضافة القسم بنجاح');
            return redirect('/products');
        
    }


    public function update_product(Request $request){

        
        $validation = $request->validate([
            'product_name' => 'required|max:255|unique:products,'.$request->id,
            'description' => 'required'
        ], [

            'product_name.required' => 'الرجاء إدخال اسم القسم',
            'product_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'الرجاء إدخال وصف للقسم'


        ]);
        
        
        $id = Section::where('name',$request->section_name)->first()->id;
        $product = Product::where('id',$request->product_id)->first();

            $product->product_name = $request->product_name;
            $product->description = $request->description;
            $product->section_id = $id;
            $product->save();
            session()->flash('edit', 'تم تعديل المنتج بنجاح');
            return redirect('/products');
    }


    public function product_delete(Request $request)
    {
        Product::where('id',$request->product_id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/products');

    }
}
