<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\qaytip;
use App\Models\Product;

class QaytipController extends Controller
{
    public function index(){
        $product = qaytip::orderBy('id','desc')->get();
        // $product = Product::all();
        $qaytuv_miqdori = 0;
        $qaytuv_shopprice = 0;
        $qaytuv_turi = 0;
        $qaytuv_soni = 0;
        $data = [];
        foreach($product as $prod){
            $qaytuv_shopprice = $qaytuv_shopprice + ($prod->shop_price * $prod->count);
            $qaytuv_soni = $qaytuv_turi + 1;
            $qaytuv_miqdori = $qaytuv_miqdori + $prod->count;
            $data['count'][] = $prod->count;
            $data['name'][] = $prod->name;
            
            // $foyda = $foyda + ($product->shop_price - $product->price);
        }
        $data['count'] = json_encode($data);
        return view('qaytim.index' ,compact('data','product','qaytuv_shopprice','qaytuv_miqdori','qaytuv_soni'));
        // return view('qaytim.index',compact('product'));
    }
    public function edit($id){
        $product = qaytip::find($id);
        return view('qaytim.edit',compact('product'));
    }
    public function update($id,Request $request){
        
        $product = qaytip::find($id);
        $pro = Product::find($product->prod_id);
        $pro->update([
            'count' => $pro->count - $product->count + $request->count
            ]);
        $product->update([
            'count'=>$request->count
        ]);
        return redirect()->route('qaytuv.index');
    }
    public function destroy($id){
        $product = qaytip::find($id);
        $product->delete();
        return redirect()->route('qaytuv.index');
    }
}
