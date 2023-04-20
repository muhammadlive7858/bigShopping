<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\vaqtincha;
use App\Models\vaqtincha2;
use App\Models\Category;
use App\Models\Product;
use App\Models\Asosiy_sotuvlar;
use App\Models\client;
use App\Models\Qarz;


class SotuvOfisi2Controller extends Controller
{
    public function index(){
        $cate = Category::all();
        $product = Product::all();
        return view('shoptu.indextu',compact('cate','product'));
    }

    public function productsearch(Request $request){

      //  dd($request->productsearch);
        $name = $request->productsearch;
        if (trim($name)) {
            $productname = Product::where('name', 'like', '%' . $name . '%')->where('count', '>', 0)->get();

            $prod_vaqt = $request->session()->get('karzinka2');
            // $prod_vaqt = vaqtincha::all();
            $client = client::all();
            return view('shoptu.createtu', compact('productname', 'prod_vaqt', 'client'));
        } 
        
        else {
            return redirect()->back();
        }
    }

    public function create_vaqtincha(Request $request){
    $prod = intval($request->productid);
    if($prod !== 0){
        $prod = Product::all()->where('id',$prod)->first();
        $prod_vaqt = $request->session()->get('karzinka2');
        $client = client::all();
        if($prod_vaqt !== null){
            foreach($prod_vaqt as $vaqt){
                if($vaqt['product_id'] === $prod->id){
                    return view('shoptu.createtu',compact('client','prod_vaqt'));
                }
            }
        }
        $shop = [
            'id'=>$prod->id,
            'product_id'=>$prod->id,
            'product_name'=>$prod->name,
            'product_count'=>$prod->count,
            'price'=>$prod->shop_price,
            'inputVal'=>0
        ];
        $store = $request->session()->push('karzinka2',$shop);
        }
            $prod_vaqt = $request->session()->get('karzinka2');
            $client = client::all();
            return view('shoptu.createtu', compact('prod_vaqt', 'client'));
    }
    public function productid(Request $request){
        $validate = $request->validate([
            'producttime'=>'numeric',
        ]);
        $cate = Category::all();
        $prod = Product::find($request->productid);
        $prod_vaqt = $request->session()->get('karzinka2');
        $client = client::all();
        if($prod == null){
            return view('shoptu.createtu',compact('client','prod_vaqt'))->with('text','Bunday tavar mavjud emas!');
        }
        if($prod_vaqt !== null){
            foreach($prod_vaqt as $vaqt){
                if($vaqt['product_id'] === $prod->id){
                    return view('shoptu.createtu',compact('client','prod_vaqt'));
                }
            }
        }
        $shop = [
            'id'=>$prod['id'],
            'product_id'=>$prod['id'],
            'product_name'=>$prod['name'],
            'product_count'=>$prod['count'],
            'price'=>$prod['shop_price'],
            'inputVal'=>0
        ];
        $store = $request->session()->push('karzinka2',$shop);
        
            $prod_vaqt = $request->session()->get('karzinka2');
            $client = client::all();
            return view('shoptu.createtu', compact('prod_vaqt', 'client'));
    }

    public function edit(Request $request,$id){
        // dd($request->inputVal);
        $request->inputVal = floatval($request->inputVal);
        $newSession = [];
        $prod = $request->session()->get('karzinka2');
        foreach($prod as $key => $value){
            if($value['product_id'] == $id){
                // Cache::increment(`karzinka1[$key][inputVal]`,intval($request->inputVal));
                $shop = [
                    'id'=>$value['id'],
                    'product_id'=>$value['product_id'],
                    'product_name'=>$value['product_name'],
                    'product_count'=>$value['product_count'],
                    'price'=>$value['price'],
                    'inputVal'=>$request->inputVal
                ];
                array_push($newSession,$shop);
            }else{
                $shop = [
                    'id'=>$value['id'],
                    'product_id'=>$value['product_id'],
                    'product_name'=>$value['product_name'],
                    'product_count'=>$value['product_count'],
                    'price'=>$value['price'],
                    'inputVal'=>$value['inputVal']
                ];
                array_push($newSession,$shop);
            }
        }
        $request->session()->put('karzinka2',$newSession);

        $prod_vaqt = $request->session()->get('karzinka2');
        // dd($prod_vaqt);
        $client = client::all();
        return view('shoptu.createtu',compact('prod_vaqt','client'));
        // }
        // return redirect()->back();
    }

    public function hisoblash(Request $request){
        $savdo = 0;
        $price = [];
        $i = 0;
        $prod = $request->session()->get('karzinka2');
        // if(empty($prod)){
        //     return redirect()->back();
        // }
        foreach($prod as $product){
            // dd($prod);
            $savdo = $savdo + ($product['price'] * $product['inputVal']);
            $price[$i] = $product['price'];
            
            $product_mossiv[$i] = $product['product_id'];
            $sotish_soni_mossiv[$i] = $product['inputVal'];
            $i++;
        }
        $prod_vaqt = $request->session()->get('karzinka2');
        $client = client::all();
        // dd($savdo);
        if($savdo  === 0){
            $prod_vaqt = $request->session()->get('karzinka2');
            return view('shoptu.createtu',compact('prod_vaqt' ));
        }
        return view('shoptu.createtu',compact('prod_vaqt','client','product_mossiv','sotish_soni_mossiv','savdo'));
    }

    public function fullHisob(Request $request){
        if($request->plastik > $request->savdo){
            return redirect()->back()->with('text','Plastik Summasi katta!');
        }
        if($request->skidka > $request->savdo){
            return redirect()->back()->with('text','Qaytim Summasi katta!');
        }
        if($request->history_summa > $request->savdo){
            return redirect()->back()->with('text','Qarz to\'lavi juda katta !');
        }
        if(($request->history_summa + $request->skidka )> $request->savdo){
            return redirect()->back()->with('text','Qarz to\'lavi va qaytim summa juda katta !');
        }
        if(($request->history_summa + $request->skidka + $request->plastik)> $request->savdo){
            return redirect()->back()->with('text','Umumiy To\'lav  summa juda katta !');
        }
        if($request->skidka > $request->savdo / 10){
            return redirect()->back()->with('text','Qaytim  summa meyordan katta !');
        }
        
        
        if($request->count === "0"){
            $prod_vaqt = $request->session()->get('karzinka2');
            return view('shoptu.createtu',compact('prod_vaqt' ));
        }
        $request->validate([
            'product'=>'required',
            'count'=>'required',
            'clint_id'=>'nullable',
            'skidka'=>'nullable'
        ]);
        // request = skidka , product[], count [],client,plastik,savdo
        $prod = $request->session()->get('karzinka2');
        $i = 0;
        $name = [];
        $price = [];
        $foyda = [];
        $savdo = 0;
        $fullFoyda = 0;
        $product_mossiv = [];
        $original_count = [];
        foreach($request->product as $prod){
            $prod = intval($prod);
            $product = Product::all()->where('id',$prod)->first();
            // dd($product->count);
            $original_count[$i] = $product->count;
            $product_mossiv[$i] = $product;
            $name[$i] = $product->name;
            $price[$i] = $product->shop_price;
            $foyda[$i] = $product->shop_price - floatval($product->price);
            $i++;
        }
        $i = 0;
        // $count = client::all();
        $fullName = [];
        foreach($request->count as $count){
        // dd($price[$i]);
            // $count[$i] = $count;
            $count = floatval($count);
            // if($i === 1){
            //     dd($count);
            // }
            $fullFoyda = $fullFoyda + (floatval($count) * floatval($foyda[$i]));
            // dd($fullFoyda);        $fullName ." ,  ".
            $product_mossiv[$i]->update(['count'=>$original_count[$i] - $count]);
            
            
            $fullName[$i]['name'] = $name[$i] ;
            $fullName[$i]['price'] = $price[$i];
            $fullName[$i]['count'] =$count;

            $i++;
                
        }
    //   dd($fullName);
        $fullName = json_encode($fullName);
        $vaqt = date("Y-m-d");
        $vaqt = explode('-',$vaqt);
        // dd($vaqt[1]);
        $store = Asosiy_sotuvlar::create([
            'fullname'=>$fullName,
            'savdo'=>$request->savdo,
            'foyda'=>$fullFoyda,
            'skidka'=>$request->skidka,
            'naxt'=>$request->savdo - $request->plastik,
            'plastik'=>$request->plastik,
            'client_id'=>$request->client_id,
            'month'=>$vaqt[1],
            'year'=>$vaqt[0],
            'day'=>$vaqt[2], 
             'date'=>date('Y-m-d')
        ]);
        if($store){
            if($request->shop_debt !== null){
                $create = Qarz::create([
                    'name'=>client::find($request->client_id)->name,
                    'tolav_summa'=>$request->savdo,
                    'qarzi'=>$request->savdo - $request->history_summa - $request->skidka,
                    'desc'=>Asosiy_sotuvlar::orderBy('id','desc')->first()->id,
                    'phone'=>client::find($request->client_id)->phone,
                    'vaqt'=>$request->date,
                    'month'=>$vaqt[1],
                    'year'=>$vaqt[0],
                    'day'=>$vaqt[2], 
                ]);
            }
        }
        if($store){
            $vaqt = $request->session()->flash('karzinka2');
            // foreach($vaqt as $vaqt){
            //     $delete = $vaqt->delete();
            // }
            return redirect()->route('shop-indextu');
            
        }else{
            return redirect()->back();
        }
    }
    public function deleteOne(Request $request){
        $newSession = [];
        $prod = $request->session()->get('karzinka2');
        foreach($prod as $key => $value){
            if($value['product_id'] == $request->product){
                // Cache::increment(`karzinka1[$key][inputVal]`,intval($request->inputVal));
                // $shop = [
                // ];
                // array_push($newSession,$shop);
            }else{
                $shop = [
                    'id'=>$value['id'],
                    'product_id'=>$value['product_id'],
                    'product_name'=>$value['product_name'],
                    'product_count'=>$value['product_count'],
                    'price'=>$value['price'],
                    'inputVal'=>$value['inputVal']
                ];
                array_push($newSession,$shop);
            }
        }
        $request->session()->put('karzinka2',$newSession);
        $prod_vaqt = $request->session()->get('karzinka2');
        $client = client::all();
        return view('shoptu.createtu', compact('prod_vaqt', 'client'));
    }
    public function tozalash(Request $request){

        $vaqt = $request->session()->flash('karzinka2');
        
        // if(true){
            return redirect()->route('shop-indextu');
        // }
    }
}
