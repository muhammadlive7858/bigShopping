<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $cate = Category::all();
        return view('category.index',compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validate = $request->validate([
            'name'=>'required',
            'desc'=>'nullable'
        ]);
        // dd($request->input());
        $store = Category::create($request->input());
        if($store){
            return redirect()->route('category.index');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $s = intval($id);
        //dd($s);
        // $pro = Product::where('category_id', $s)->get();
        
        // $s = $request->category_id;
        
        $product = Product::where('category_id', $s)->get();
        $cateName = Category::find( $s);
        $shop_price = [];
        $price = [];
        $count = [];
        $s = 0;
        foreach($product as $pro){
            array_push($shop_price , ($pro->shop_price * $pro->count));
            array_push($price      , ($pro->price * $pro->count));
            array_push($count      , $pro->count);
            $s++;
        }
        
        $kelish = array_sum($price);
        $soni =    array_sum($count);
        $cate = Category::all();
         $sotish =   array_sum($shop_price);
         $res = $sotish - $kelish;
         
         
        
        return view('category.show', compact('product','kelish','soni','cate','sotish','res','s','cateName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = Category::find($id);
        return view('category.edit',compact('cate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {   
        $validate = $request->validate([
            'name'=>'required',
            'desc'=>'nullable'
        ]);
        // dd($request);
        $cate = Category::find($id);
        $update = $cate->update($request->input());
        if($update){
            return redirect()->route('category.index');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = Category::find($id);
        $delete = $cate->delete($id);
        
        return redirect()->back();
    }
}
