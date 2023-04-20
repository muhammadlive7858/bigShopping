<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\setting;
class SettingController extends Controller
{
    public function index(){
        $setting = setting::first();
        // dd($setting);
        return view('setting.index',compact('setting'));
    }
    public function edit(){
        $setting = setting::first();
        // dd($setting);
        return view('setting.edit',compact('setting'));
    }
    public function update(Request $request){
        // dd($request);
        $setting = setting::first();
        $store = $setting->update($request->input());
        return redirect()->route('setting.index');
    }
}
