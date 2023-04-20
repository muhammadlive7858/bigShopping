<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Qarz;
use App\Models\Asosiy_sotuvlar;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\client;
use App\Models\setting;
use App\Models\Category;
use App\Models\qaytip;
use App\Models\taminotchi;
use App\Models\vaqtinchaDollor;
use App\Models\shaxsiyQarzTaminot;

use Auth;

class ProNullCantroller extends Controller
{
    public function index()
    {
        $count_product = setting::first();
        $productNullCount = Product::where('count', '<', $count_product->less_product)->get();

        return view('product.nullproduct', compact('productNullCount'));
    }

    public function dollorproduct(Request $request)
    {
        $kurs = file_get_contents("https://cbu.uz/oz/arkhiv-kursov-valyut/json/");
        $kurs = json_decode($kurs, true);
        $dollor = floatval($kurs[0]["Rate"]);
        
        $explode = explode(',',$request->dollor);
        // dd($explode);
        $i = 0;
        foreach($explode as $explode){
            $i ++;
        }
        if($i >1){
            return redirect()->route('product.create')->with('error','Dollorda xatolik!');
        }
        // $reqDollor = floatval($request->dollor);
        $som = floatval($request->dollor) * $dollor;
        if ($som !== 0) {
            vaqtinchaDollor::create([
                "dollor" => floatval($request->dollor),
                "som" => $som
            ]);
        }
        $dollor = vaqtinchaDollor::orderBy('id','desc')->first()->dollor;
        // dd($som);
        $products = Product::all();
        $taminot = taminotchi::all();
        $cate = Category::all();
        return view('product.create', compact('som', 'cate', 'taminot','products','dollor'));
    }

    public function coin()
    {
        $vaqt = date('Y-m-d');
        // dd($vaqt);
        $qarz = Qarz::all()->where('vaqt', $vaqt);
        return view('qarz.qarzday', compact('qarz'));
    }
    public function coinday()
    {
        $date = date('Y-m-d');
        // dd($vaqt);   
        // $savdo = Asosiy_sotuvlar::all()->where('created_at','like','%'.$vaqt.'%');
        $sotuv = DB::table('asosiy_sotuvlars')->select()
            ->where('created_at', 'like', '%' . $date . '%')->get();
        // dd($savdo);

        $jamiSumma = 0;
        $jamiNaxt = 0;
        $jamiPlastik = 0;
        $jamiFoyda = 0;
        $jamiQaytim = 0;
        $res = [];
        $i = 0;
        $n = 0;
        //  dd($sotuv);
        foreach ($sotuv as $sotish) {
            foreach (json_decode($sotish->fullname) as $names) {
                // dd($names);
                foreach ($names as $key => $name) {
                    if ($key === "name") {
                        $res[$n][$i]['name'] = $name;
                    }
                    if ($key === 'count') {
                        $res[$n][$i]['count'] = $name;
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
        // dd($res[0][0]);


        return view('sotuvlar.savdoday', compact('res', 'sotuv', 'jamiSumma', 'jamiNaxt', 'jamiPlastik', 'jamiFoyda', 'jamiQaytim'));
    }
    public function pdf(Request $request)
    {
        //    $req =  $request->price;
        $s = Asosiy_sotuvlar::orderBy('id', 'desc')->first();
        if ($s->clint_id) {

            $client = client::where('id', $s->client_id)->first();
            $client = $client['name'];
        }
        $req = $s->savdo;
        $date = date('Y-m-d');
        $names = json_decode($s->fullname);
        $i = 0;
        $res = [];
        foreach ($names as $names) {

            foreach ($names as $key => $value) {
                if ($key === "name") {
                    $res[$i]['name'] = $value;
                }
                if ($key === 'count') {
                    $res[$i]['count'] = $value;
                }
                if ($key === 'price') {
                    $res[$i]['price'] = $value;
                }
            }

            $i++;
        }
        // dd($res); 
        $hodim = Auth::user()->name;
        $s->hodim = $hodim;

        // dd($s->hodim);
        $vaqt = date("Y-m-d");

        $pdf = Pdf::loadView('pdf', ['name' => $res], ['s' => $s]);
        return $pdf->download('invoice-' . $vaqt . '.pdf');
    }

    public function tavarpdf($id)
    {
        $s = Asosiy_sotuvlar::where('id', $id)->first();
        $req = $s->savdo;
        $date = date('Y-m-d');
        $client = client::where('id', $s->client_id)->first();
        // $client = $client['name'];
        $names = json_decode($s->fullname);
        $i = 0;
        $res = [];
        foreach ($names as $names) {
            $price = 0;
            $count = 0;
            foreach ($names as $key => $value) {
                if ($key === "name") {
                    $res[$i]['name'] = $value;
                }
                if ($key === 'count') {
                    $count = $value;
                    $res[$i]['count'] = $value;
                }
                if ($key === 'price') {
                    $price = $value;
                    $res[$i]['price'] = $value;
                }
                $res[$i]['hisobot'] = ($count * intval($price));
            }

            $i++;
        }
        // dd($res); 
        $hodim = Auth::user()->name;
        $s->hodim = $hodim;

        $vaqt = date("Y-m-d");
        // dd($vaqt);
        $pdf = Pdf::loadView('pdf', ['s' => $s], ['name' => $res]);
        return $pdf->download('invoice-' . $vaqt . '.pdf');
    }
    public function dollor()
    {
    }
    public function qarzsearch(Request $request)
    {
        //dd($request->input());
        if (isset($request->search)) {

            $qarz = Qarz::where('phone', 'LIKE', '%' . $request->search . '%')->get();
            //   dd($qarz);
            return view('qarz.index', compact('qarz'));
        } else {
            $request->search = "";
            $qarz = Qarz::where('phone', 'like', '%' . $request->search . '%')->get();
            //  dd($qarz);
            return view('qarz.index', compact('qarz'));
        }
    }
    public function plus()
    {
        return view('product.plus');
    }
    public function editplus(Request $request, $id)
    {
        $product = Product::find($id);
        $count =  $product->count;
        if ($product) {
            $store = $product->update([
                "count" => $count + $request->count
            ]);
                $date = date('Y-m-d');
                $ex = explode( '-' , $date);
            $store = qaytip::create([
                'prod_id'=> $product->id,
                'productname' => $product->name,
                'shop_price' => $product->shop_price,
                'price' => $product->price,
                'foyda' => ($product->shop_price - $product->price) * $request->count,
                'count' => $request->count,
                'year'=>$ex[0],
                'month'=>$ex[1],
                'day'=>$ex[2]
            ]);
            // dd(qaytip::all());
            if ($store) {
                return redirect()->route('product.index');
            } else {
                return  abort(200, "forbidden");
            }
        }
    }
    public function sotuvsearch(Request $request)
    {
         //dd($request->date);
         $sotuv = Asosiy_sotuvlar::where('date',$request->date)->get();

        $jamiSumma = 0;
        $jamiNaxt = 0;
        $jamiPlastik = 0;
        $jamiFoyda = 0;
        $jamiQaytim = 0;
        $res = [];
        $i = 0;
        $n = 0;
        $s = 0;
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
            $s++;
            // $sotuv->fullname[$n] = $res[$n]; 
            $n++;


            $jamiSumma   = $jamiSumma + $sotish->savdo;
            $jamiNaxt    = $jamiNaxt + $sotish->naxt;
            $jamiPlastik = $jamiPlastik + $sotish->plastik;
            $jamiFoyda   = $jamiFoyda + $sotish->foyda;
            $jamiQaytim  = $jamiQaytim + $sotish->skidka;
        }
        $qaytuv = qaytip::all();
        $qaytuvSumma = 0;
        $qaytuvNaxt = 0;
        $qaytuvFoyda = 0;

        if($qaytuv === null){

        }else{
            foreach($qaytuv as $qayt){
                $qaytuvSumma = $qaytuvSumma + ($qayt->shop_price * $qayt->count);
                $qaytuvNaxt = $qaytuvNaxt + ($qayt->shop_price * $qayt->count);
                $qaytuvFoyda = $qaytuvFoyda + (($qayt->shop_price - $qayt->price) * $qayt->count);
            }
                $jamiSumma   = $jamiSumma - $qaytuvSumma;
                $jamiNaxt    = $jamiNaxt - $qaytuvNaxt;
                $jamiFoyda   = $jamiFoyda - $qaytuvFoyda;
        }
        
        // dd($res);
       
        return view('sotuvlar.index',compact('res','sotuv','jamiSumma','jamiNaxt','jamiPlastik','jamiFoyda','jamiQaytim','s'));
    }
    public function sotuvclient(){
        return view('client.create_sotuv');
    }
  public function searchName(Request $request){
    //   dd('test');
        $search = $request->search;
        $product = Product::where('name', 'LIKE', '%'.$search.'%')->get();

        return view('product.res', compact('product'));
    }
    public function dateproductsearch(Request $request){
        $product = Product::where('created_at','like','%'.$request->dateProSearch.'%')->orderBy('id','desc')->paginate(100);
        
        // hisob
        $productHisob = Product::where('created_at','like','%'.$request->dateProSearch.'%')->orderBy('id','desc')->get();
        
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
            
            // $foyda = $foyda + ($product->shop_price - $product->price);
        }
        // $data['count'] = json_encode($data);
        // dd($prod_price);
        return view('product.index' ,compact('product','prod_price','prod_shopprice','prod_turi','prod_soni'));
        
        // dd($product);
    }
    
    public function codsearchproduct(Request $request){
        $product = Product::where('id',$request->code)->paginate(100);
        
        // hisob
        $productHisob = Product::where('created_at','like','%'.$request->dateProSearch.'%')->orderBy('id','desc')->get();
        
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
            
            // $foyda = $foyda + ($product->shop_price - $product->price);
        }
        // $data['count'] = json_encode($data);
        // dd($prod_price);
        return view('product.index' ,compact('product','prod_price','prod_shopprice','prod_turi','prod_soni'));
    }
    public function codsearchtaminotproduct(Request $request){
        // dd($request->taminot_id);
        $product = Product::orderBy('id','desc')->where('taminotchi', $request->taminot_id)->get();
        $jamiSummaDollor = 0;
        $jamiSummaSom = 0;

        $qoldiqSummaDollor = 0;
        $qoldiqSummaSom = 0;
        // dd($prod);
        foreach($product as $product){
            if($product->dollor === 1){
                $jamiSummaDollor = $jamiSummaDollor + (floatval($product->dollors) * floatval($product->taminotcount));
            }else{
                $jamiSummaSom = $jamiSummaSom + (floatval($product->price) * floatval($product->taminotcount));
            }
        }
        $tolavSummaDollor = 0;
        $tolavSummaSom = 0;
        $history = shaxsiyQarzTaminot::where('taminotchi_id',intval($request->taminot_id))->get();
        foreach($history as $history){
            $tolavSummaDollor = $tolavSummaDollor + $history->dollor;
            $tolavSummaSom = $tolavSummaSom + $history->som;
        }
        $qoldiqSummaDollor = $jamiSummaDollor - $tolavSummaDollor;
        $qoldiqSummaSom = $jamiSummaSom - $tolavSummaSom;
        $id = $request->taminot_id;
        
        
        $prod = Product::all()->where('taminotchi', $id);
        $prod_price = 0;
        $prod_shopprice = 0;
        $prod_turi = 0;
        $prod_soni = 0;
        $mavjud = 0;
        $mavjudlarSummasi = 0;
        foreach($prod as $prod){
            // $prod_price = $prod_price + ($prod->price * $prod->count);
            if($prod->dollor === 0){
                $prod_price = $prod_price +  ($prod->price * $prod->taminotcount);
            }
            if($prod->dollor === 1){
                $prod_shopprice = $prod_shopprice +  ($prod->dollors * $prod->taminotcount);
            }
            $prod_turi = $prod_turi + 1;
            // $prod_soni = $prod_soni + $prod->taminotcount;
            $mavjud = $mavjud + $prod->count;
            $prod_soni = $prod_soni + $prod->taminotcount;
            $mavjudlarSummasi = $mavjudlarSummasi + ($prod->count * $prod->price );
            // $data['count'][] = $prod->count;
            // $data['name'][] = $prod->name;
            
            // $foyda = $foyda + ($product->shop_price - $product->price);
        }
        $prod = Product::orderBy('id','desc')->where('taminotchi', $id)->where('id',$request->code)->get();
        
        // dd($qoldiqSummaDollor);
        
        return view('taminotchi.show', compact('prod','jamiSummaDollor','qoldiqSummaDollor','jamiSummaSom','qoldiqSummaSom','id','prod_price','prod_shopprice','prod_turi','prod_soni','mavjud','mavjudlarSummasi'));
    }
    public function catecodsearchproduct(Request $request){
        $product = Product::where('id' ,$request->code)->get();
        
        // $product = Product::where('category_id', $s)->get();
        $shop_price = [];
        $price = [];
        $count = [];
        $s = 0;
        foreach($product as $pro){
            $cateName = Category::find( $pro->category_id);
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
}
