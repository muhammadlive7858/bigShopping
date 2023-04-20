<?php

namespace App\Http\Controllers;

use App\Models\shaxsiyQarzTaminot;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\productHisobot;

class ShaxsiyQarzTaminotController extends Controller
{   
    public function create($id){
        $id = $id;
        return view('taminotchi.shqarz.create',compact('id'));
    }
    public function createSom($id){
        $id = $id;
        return view('taminotchi.shqarz.som.create',compact('id'));
    }
    public function store(Request $request,$id){
        // dd($request);
        $vaqt = date("Y-m-d");
        $vaqt = explode('-',$vaqt);
        if($request->summa === 'dollor'){
            shaxsiyQarzTaminot::create([
                'taminotchi_id'=>$id,
                'dollor'=>$request->dollor,
                'month'=>$vaqt[1],
                    'year'=>$vaqt[0],
                    'day'=>$vaqt[2], 
            ]);
            return redirect()->route('taminot.show',$id);
        }elseif($request->summa === 'som'){
            shaxsiyQarzTaminot::create([
                'taminotchi_id'=>$id,
                'som'=>$request->dollor,
                'month'=>$vaqt[1],
                    'year'=>$vaqt[0],
                    'day'=>$vaqt[2], 
            ]);
            return redirect()->route('taminot.show',$id);
        }
    }
    public function show($id){
        // dd('mmm');
        $show = [];
        $shows = shaxsiyQarzTaminot::all()->where('taminotchi_id',$id);
        foreach($shows as $shows){
            if(isset($shows->dollor)){
                array_push($show,$shows);
            }
        }
        return view('taminotchi.shqarz.show',compact('show'));

    }
    public function showSom($id){
        // dd('mmm');
        $show = [];
        $shows = shaxsiyQarzTaminot::all()->where('taminotchi_id',$id);
        foreach($shows as $shows){
            if(isset($shows->som)){
                array_push($show,$shows);
            }
        }
        return view('taminotchi.shqarz.showsom',compact('show'));
    }
    public function destroy($id){
        $qarz = shaxsiyQarzTaminot::find($id);
        $delete = $qarz->delete();
        return redirect()->back(); 
    }
    public function productedit($id){
        $prod = Product::find($id);
        return view('taminotchi.editproduct',compact('prod'));
    }
    public function productupdate(Request $request,$id){
        // dd('mmm');
        $prod = Product::find($id);
        $product = Product::find($id);

        $prod = $prod->update([
            'count'=>$product->count + $request->count,
            'taminotcount'=>$product->taminotcount + $request->count
        ]);
        $vaqt = date("Y-m-d");
        $vaqt = explode('-',$vaqt);        
        $productHisobot = Product::find($id);
        $store = productHisobot::create([
                    'name'=>$productHisobot->name,
                    'taminotchi'=>$productHisobot->taminotchi,
                    'dollor'=>$productHisobot->dollor,
                    'dollors'=>$productHisobot->dollors,
                    'som'=>$productHisobot->som,
                    'price'=>$productHisobot->price,
                    'shop_price'=>$productHisobot->shop_price,
                    'count'=>$request->count,
                    'month'=>$vaqt[1],
                    'year'=>$vaqt[0],
                    'day'=>$vaqt[2]
                ]);
        return redirect()->route('taminot.index');
    }
}
