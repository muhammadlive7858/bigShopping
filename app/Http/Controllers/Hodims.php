<?php

namespace App\Http\Controllers;
use App\Models\Hodimlar;
use App\Models\Hodimsavdo;
use App\Models\Hshop;
use App\Models\date;
use Illuminate\Http\Request;

class Hodims extends Controller
{
    public function index(){
        $hodim = Hodimlar::all();
        $month = date::orderBy('id','desc')->first();
        // dd($month);
        $vaqt = date("Y-m-d");
        $vaqt = explode('-',$vaqt);
        if($month->month !== $vaqt[1]){
                    $month = date::orderBy('id','desc')->first();
                    $vaqt = date("Y-m-d");
                    $vaqt = explode('-',$vaqt);
                    $month->update([
                            'month'=>$vaqt[1]
                        ]);
            foreach($hodim as $hodims){
                    
                // $shops = Hshop::where('hodim_id',$hodims->id)->get();
                // $savdo = 0;
                // foreach($shops as $shop){
                //     $savdo = $savdo + $shop->savdo;
                // }
                $updatehodim = Hodimlar::find($hodims->id);
                
                // dd($hodims->summa);
                $updatehodim->update([
                        'qoldiq'=>$hodims->summa,
                    ]);
            }
        }
        return view('hodim.index',compact('hodim'));
    }
    public function create(){
        return view('hodim.create');
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'phone'=>'nullable',
            'summa'=>'required',
            'desc'=>'nullable'
        ]);
                $store = Hodimlar::create([
                    'name'=>$request->name,
                    'phone'=>$request->phone,
                    'summa'=>$request->summa,
                    'qoldiq'=>floatval($request->summa),
                    'desc'=>$request->desc
                ]);
        if($store){
            return redirect()->route('hodim.index');
        }else{
            return redirect()->back();
        }
    }
    public function edit($id){
        $hodim = Hodimlar::find($id);
        return view('hodim.edit',compact('hodim'));
    }
    public function update(Request $request,$id){
        $hodim = Hodimlar::find($id);
        $update = $hodim->update($request->input());
        if($update){
            return redirect()->route('hodim.index');
        }else{
            return redirect()->back();
        }
    }
    public function destroy($id ){
        $hodim = Hodimlar::find($id);
        $delete = $hodim->delete();
        return redirect()->back();
    }
    public function show(){
        $hodim = Hodimlar::all();
        $savdo = Hodimsavdo::all();
        return view('hodim.show',compact('hodim','savdo'));
    }
    public function savdo(Request $request){
        $savdo = Hodimsavdo::create($request->input());
        if($savdo){
            return redirect()->route('show.savdo');
        }else{
            return redirect()->back();
        }
    }
    public function savdodelete($id){
        $delete = Hodimsavdo::find($id);
        $delete = $delete->delete();
        return redirect()->back();
    }
    public function showsavdo(){
        $savdo = Hodimsavdo::all();
        return view('hodim.savdo',compact('savdo'));
    }
}
