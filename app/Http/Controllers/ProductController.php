<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\productHisobot;
use App\Models\ShaxsiyQarz;
use App\Models\shaxsiyqarzhistory;
use Illuminate\Http\Request;
use App\Models\taminotchi;
use App\Models\taminotProduct;
use App\Models\vaqtinchaDollor;
use App\Models\setting;
use Auth;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $count = setting::first();
        $user = Auth::user();
            if($user->role === 'admin'){    
            return abort('403','Bu sahifa director uchun  himoyalangan !');
            }
            
        if($search = $request->session()->get('productSearch')){
            $product = Product::where('name', "like", '%' . $search . '%')->orderBy('id','desc')->paginate($count->product_paginate_count);
        }else{
            $product = Product::orderBy('id','desc')->paginate($count->product_paginate_count);
        }
        
        if($search = $request->session()->get('productSearch')){
            $productHisob = Product::where('name', "like", '%' . $search . '%')->orderBy('id','desc')->get();
        }else{
            $productHisob = Product::orderBy('id','desc')->get();
        }
        
        $prod_price = 0;
        $prod_shopprice = 0;
        $prod_turi = 0;
        $prod_soni = 0;
        
        $data = [];
        foreach($productHisob as $prod){
            $prod_price = $prod_price + ($prod->price * $prod->count);
            $prod_shopprice = $prod_shopprice + ($prod->shop_price * $prod->count);
            $prod_turi = $prod_turi + 1;
            $prod_soni = $prod_soni + $prod->count;
            $data['count'][] = $prod->count;
            $data['name'][] = $prod->name;
        }
        return view('product.index' ,compact('product','prod_price','prod_shopprice','prod_turi','prod_soni'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $taminot = taminotchi::all();
        $cate = Category::all();
        $products = Product::all();
        return view('product.create',compact('cate','taminot','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {   
        // dd($request->name);
        $prod = Product::all();
        // dd($prod);
        if($request->price >= $request->shop_price){
            return redirect()->back()->with('error' , 'Sotilish Summasi katta');
        }
        $request->taminotchi = intval($request->taminotchi);
            $summa = $request->price * $request->count;
            if($request->dollorHisob === "on"){
                $dollorVaqtincha = vaqtinchaDollor::orderBy('id','desc')->first();
                
                
                $tam = taminotchi::find($request->taminotchi);
                
                $store = Product::create([
                    'name'=>$request->name,
                    'category_id'=>$request->category_id,
                    // 'desc'=>$request->desc,
                    'producttime'=>$request->producttime,
                    'taminotchi'=>$request->taminotchi,
                    'dollor'=>true,
                    'dollors'=>$dollorVaqtincha->dollor,
                    'som'=>$dollorVaqtincha->som,
                    'price'=>$request->price,
                    'shop_price'=>$request->shop_price,
                    'count'=>$request->count,
                    'taminotCount'=>$request->count,
                     'taminotname'=>$tam->name
                ]);
                $vaqt = date("Y-m-d");
                $vaqt = explode('-',$vaqt);
                $store = productHisobot::create([
                    'name'=>$request->name,
                    'taminotchi'=>$request->taminotchi,
                    'dollor'=>true,
                    'dollors'=>$dollorVaqtincha->dollor,
                    'som'=>$dollorVaqtincha->som,
                    'price'=>$request->price,
                    'shop_price'=>$request->shop_price,
                    'count'=>$request->count,
                    'month'=>$vaqt[1],
                    'year'=>$vaqt[0],
                    'day'=>$vaqt[2]
                ]);
                    if($store){
                        vaqtinchaDollor::orderBy('id','desc')->first()->delete();
                        return redirect()->route('product.index');
                    }else{
                        return redirect()->back();
                    }
                // }
            }else{
                 $tam = taminotchi::find($request->taminotchi);
                
                 
                $store = Product::create([
                    'name'=>$request->name,
                    'category_id'=>$request->category_id,
                    // 'desc'=>$request->desc,
                    'producttime'=>$request->producttime,
                    'taminotchi'=>$request->taminotchi,
                    'dollor'=>false,
                    'price'=>$request->price,
                    'shop_price'=>$request->shop_price,
                    'count'=>$request->count,
                    'taminotcount'=>$request->count,
                    'taminotname'=>$tam->name

                ]);
                $vaqt = date("Y-m-d");
                $vaqt = explode('-',$vaqt);
                $store = productHisobot::create([
                    'name'=>$request->name,
                    'taminotchi'=>$request->taminotchi,
                    'dollor'=>false,
                    'price'=>$request->price,
                    'shop_price'=>$request->shop_price,
                    'count'=>$request->count,
                    'month'=>$vaqt[1],
                    'year'=>$vaqt[0],
                    'day'=>$vaqt[2]

                ]);
                if($store){
                    return redirect()->route('product.index');
                }else{
                    return redirect()->back();
                }
            }
        }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $cate = Category::all();
        $taminot = taminotchi::all();
        $product = Product::find($id);
        if($product->dollor == 1){
            return view('product.edit',compact('product','cate','taminot'));
        }else{
            return view('product.editnotdollor',compact('product','cate','taminot'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // if($product = Product::where('name' , 'LIKE' , '%'. $request->prosearch . '%' )->get()){
        //     return redirect()->back()->with('text','Bu nomli tavar mavjud');
        // }
        
        $dollar = file_get_contents('https://cbu.uz/oz/arkhiv-kursov-valyut/json/');
          $json = json_decode($dollar, true);
          $rate = $json[0]['Rate'];
          $resultKurs =  $rate * $request->dollar ;
                $prod = Product::find($id);
                if($prod->dollor == 1){
                    // $prod = Product::find($id);
                    $tam = taminotchi::find($request->taminotchi);
                    $category = taminotchi::find($request->category_id);
                    if($tam){
                        if($category){
                            $store = $prod->update([
                                'name'=>$request->name,
                                'taminotchi'=>$request->taminotchi,
                                'category_id'=>$request->category_id,
                                'dollors'=>$request->dollar,
                                'producttime'=>$request->producttime,
                                'price'=>$resultKurs,
                                'shop_price'=>$request->shop_price,
                                'count'=>$request->count,
                                'taminotcount'=>$request->count,
                                'taminotname'=>$tam->name
                            ]);
                            if($store){
                                return redirect()->route('product.index');
                            }else{
                                return redirect()->back();
                            }
                        }else{
                            $store = $prod->update([
                                'name'=>$request->name,
                                'taminotchi'=>$request->taminotchi,
                                'dollors'=>$request->dollar,
                                'producttime'=>$request->producttime,
                                'price'=>$resultKurs,
                                'shop_price'=>$request->shop_price,
                                'count'=>$request->count,
                                'taminotcount'=>$request->count,
                                'taminotname'=>$tam->name
                            ]);
                            if($store){
                                return redirect()->route('product.index');
                            }else{
                                return redirect()->back();
                            }
                        }
                    }else{
                        if($category){
                            $store = $prod->update([
                                'name'=>$request->name,
                                'category_id'=>$request->category_id,
                                'dollors'=>$request->dollar,
                                'producttime'=>$request->producttime,
                                'price'=>$resultKurs,
                                'shop_price'=>$request->shop_price,
                                'count'=>$request->count,
                                'taminotcount'=>$request->count
                            ]);
                            if($store){
                                return redirect()->route('product.index');
                            }else{
                                return redirect()->back();
                            }
                        }else{
                            $store = $prod->update([
                                'name'=>$request->name,
                                'dollors'=>$request->dollar,
                                'producttime'=>$request->producttime,
                                'price'=>$resultKurs,
                                'shop_price'=>$request->shop_price,
                                'count'=>$request->count,
                                'taminotcount'=>$request->count
                            ]);
                            if($store){
                                return redirect()->route('product.index');
                            }else{
                                return redirect()->back();
                            }
                        }
                    }
                }else{
                    $tam = taminotchi::find($request->taminotchi);
                    $category = taminotchi::find($request->category_id);
                    if($tam){
                        if($category){
                            $store = $prod->update([
                                'name'=>$request->name,
                                'taminotchi'=>$request->taminotchi,
                                'category_id'=>$request->category_id,
                                // 'dollors'=>$request->dollar,
                                'producttime'=>$request->producttime,
                                'price'=>$request->price,
                                'shop_price'=>$request->shop_price,
                                'count'=>$request->count,
                                'taminotcount'=>$request->count,
                                'taminotname'=>$tam->name
                            ]);
                            if($store){
                                return redirect()->route('product.index');
                            }else{
                                return redirect()->back();
                            }
                        }else{
                            $store = $prod->update([
                                'name'=>$request->name,
                                'taminotchi'=>$request->taminotchi,
                                // 'dollors'=>$request->dollar,
                                'producttime'=>$request->producttime,
                                'price'=>$request->price,
                                'shop_price'=>$request->shop_price,
                                'count'=>$request->count,
                                'taminotcount'=>$request->count,
                                'taminotname'=>$tam->name
                            ]);
                            if($store){
                                return redirect()->route('product.index');
                            }else{
                                return redirect()->back();
                            }
                        }
                    }else{
                        if($category){
                            $store = $prod->update([
                                'name'=>$request->name,
                                // 'taminotchi'=>$request->taminotchi,
                                'category_id'=>$request->category_id,
                                // 'dollors'=>$request->dollar,
                                'producttime'=>$request->producttime,
                                'price'=>$request->price,
                                'shop_price'=>$request->shop_price,
                                'count'=>$request->count,
                                'taminotcount'=>$request->count
                            ]);
                            if($store){
                                return redirect()->route('product.index');
                            }else{
                                return redirect()->back();
                            }
                        }else{
                            $store = $prod->update([
                                'name'=>$request->name,
                                // 'taminotchi'=>$request->taminotchi,
                                // 'dollors'=>$request->dollar,
                                'producttime'=>$request->producttime,
                                'price'=>$request->price,
                                // 'price'=>$resultKurs,
                                'shop_price'=>$request->shop_price,
                                'count'=>$request->count,
                                'taminotcount'=>$request->count
                            ]);
                            if($store){
                                return redirect()->route('product.index');
                            }else{
                                return redirect()->back();
                            }
                        }
                    }
                }
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $delete = Product::find($id)->delete();
        
        if($delete){
            // taminotProduct::find($id)->delete();
            return redirect()->back();
        }
        
    }
}