<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\prodaja;
use DB;
use Illuminate\Http\Request;
use App\Models\Asosiy_sotuvlar;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = client::all();
        return view('client.index',compact('client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if($request->sotuv){
            $clients = client::all();
            foreach($clients as $client){
                if($client->name == $request->name){
                    return redirect()->back()->with('text','Mijoz nomi avvaldan mavjud!');
                }
            }
            $store = client::create([
                    'name'=>$request->name,
                    'phone'=>$request->phone
                ]);
            if($store){
                return redirect()->route('hisoblash');
            }else{
                return redirect()->back();
            }
        }
        $clients = client::all();
        foreach($clients as $client){
            if($client->name == $request->name){
                return redirect()->back()->with('text','Mijoz nomi avvaldan mavjud!');
            }
        }
        $store = client::create($request->input());
        if($store){
            return redirect()->route('client.index');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $sotuv = Asosiy_sotuvlar::orderBy('id','desc')->where('client_id' ,$id)->get();
        
        $jamiSumma = 0;
        $jamiNaxt = 0;
        $jamiPlastik = 0;
        $jamiFoyda = 0;
        $jamiQaytim = 0;
        $res = [];
        $i = 0;
        $n = 0;
        //  dd($sotuv);
        

        foreach($sotuv as $sotish){
            foreach(json_decode($sotish->fullname) as $names){
                    // dd($names);
                foreach($names as $key => $name){
                    if($key === "name"){
                        $res[$n][$i]['name'] = $name;
                    }
                    if($key === 'count'){
                        $res[$n][$i]['count'] = $name;
                    }
                    if($key === 'price'){
                        $res[$n][$i]['price'] = $name;
                    }
                }

                    $i++;
            }
            // $sotuv->fullname[$n] = $res[$n]; 
            $n++;


            $jamiSumma   = $jamiSumma + $sotish->savdo;
            $jamiNaxt    = $jamiNaxt + $sotish->naxt;
            $jamiPlastik = $jamiPlastik + $sotish->plastik;
            $jamiFoyda   = $jamiFoyda + $sotish->foyda;
            $jamiQaytim  = $jamiQaytim + $sotish->skidka;
        }
        return view('client.show',compact('res','sotuv','jamiSumma','jamiNaxt','jamiPlastik','jamiFoyda','jamiQaytim'));
        // return view('client.show' , compact('clent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = client::all()->where('id',$id);
        return view('client.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $client = client::all()->where('id',$id)->update($request->input());
        // $update = $client->update($request->input());
        if($client){
            return redirect()->route('client.index');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = client::find($id)->delete();
        // $client->delete();
        return redirect()->back();
        
    }
}
