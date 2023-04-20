<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asosiy_sotuvlar;
use Symfony\Component\VarDumper\Cloner\Data;
use App\Models\Product;
use App\Models\productHisobot;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Chiqim;
// use App\Models\qaytim;
use App\Models\qaytip;
use App\Models\Qarz;
use App\Models\qarzhistory;
use App\Models\shaxsiyQarzTaminot;

class Hisobot extends Controller
{
    public function index(){
        // $vaqt = date("Y-m-d");
        // $vaqt = explode('-',$vaqt);
        // $qaytim = qaytip::where('year' , $vaqt[0])->groupBy('month');
        // dd($qaytim);
        
        $oy = 13;
        $qaytuv = [];
        $date = date('Y-m-d');
        $ex = explode( '-' , $date);

        $jamiSavdo = 0;
        $jamiFoyda = 0;
        $jamiQaytim = 0;

        for($i = 1; $i<$oy ;$i++){
            if($oy<10){
                $i = "0"+$i;
                // dd($i);
                $qaytuv[$i] = qaytip::where('month',$i)->where('year' ,$ex[0])->get();
            }else{
                $qaytuv[$i] = qaytip::where('month',$i)->where('year' , $ex[0])->get();
            }
        
        }
        $i = 1;
        foreach($qaytuv as $qayt){
            $res[$i]['qaytuv'] = 0;
            $res[$i]['foyda_qaytuv'] = 0;
            foreach($qayt as $price){
                $res[$i]['qaytuv'] = $res[$i]['qaytuv'] + ($price->shop_price * $price->count);
                $res[$i]['foyda_qaytuv'] = $res[$i]['foyda_qaytuv'] + ($price->shop_price - $price->price);
            }
            $i++;
        }
        // dd($qaytuv);
        
        $oy = 13;
        $savdo = [];
        $date = date('Y-m-d');
        $ex = explode( '-' , $date);

        $jamiSavdo = 0;
        $jamiFoyda = 0;
        $jamiQaytim = 0;

        for($i = 1; $i<$oy ;$i++){
            if($oy<10){
                $i = "0"+$i;
                // dd($i);
                $sotuv[$i] = Asosiy_sotuvlar::all()->where('month',$i)->where('year' ,$ex[0]);
            }else{
                $sotuv[$i] = Asosiy_sotuvlar::all()->where('month',$i)->where('year' , $ex[0]);
            }
        
        }
       
        $i = 1;
        /*MONTH*/ 
        foreach($sotuv as $savdo){
            $res[$i]['savdo'] = 0;
            $res[$i]['foyda'] = 0;
            $res[$i]['qaytim'] = 0;
            foreach($savdo as $sav){
                $res[$i]['savdo'] = $res[$i]['savdo'] + $sav->savdo;
                $res[$i]['foyda'] = $res[$i]['foyda'] + $sav->foyda;
                $res[$i]['qaytim'] = $res[$i]['qaytim'] + $sav->skidka;
            }
            $i++;
        }
        $chiqimlar = [];
        /*rosxot*/
        for($i = 1; $i<$oy ;$i++){
            if($oy<10){
                $i = "0"+$i;
                $chiqimlar[$i] = Chiqim::all()->where('month',$i)->where('year' ,$ex[0]);
                // dd($chiqimlar);
            }else{
                $chiqimlar[$i] = Chiqim::all()->where('month',$i)->where('year' , $ex[0]);
            }
        }
        
        $i = 1;
        foreach($chiqimlar as $chiqim){
            $res[$i]['chiqim'] = 0;
            foreach($chiqim as $chiqim){
                $res[$i]['chiqim'] = $res[$i]['chiqim'] + $chiqim->summa;
            }
            $i++;
        }
        
        
        
        // $i = 1;
        // $rasxot = [];
        // foreach($chiqim as $element){
        //     $rasxot[$i]['chiqim'] = 0;
        //     foreach($element as $e){
        //         $rasxot[$i]['chiqim'] = $rasxot[$i]['chiqim'] + $e->summa;
        //     }
        //     $i++;
        // }
        $yearchiqim = 0;
        $i = 1;
        foreach($res as $r){
            $yearchiqim = $yearchiqim + $r['chiqim'];
            $i++;
        }
        
        // dd($yearchiqim);
        
        
        /*year*/
        foreach($sotuv as $sotuv){
            foreach($sotuv as $sotish){
                $jamiSavdo = $jamiSavdo + $sotish->savdo;
                $jamiFoyda = $jamiFoyda + $sotish->foyda;
                $jamiQaytim = $jamiQaytim + $sotish->skidka;
            }
        }
        $vaqt = date("Y-m-d");
        $vaqt = explode('-',$vaqt);
        $JQT = 0;
        $jamiQaytganTavar = qaytip::where('year',$vaqt[0])->get();
        foreach($jamiQaytganTavar as $jamiQaytganTavar){
                $JQT = $JQT + ($jamiQaytganTavar->shop_price* $jamiQaytganTavar->count);
            }
        
        $date = $vaqt[0];
        // dd($res);
        return view('hisob.index' , compact('res','jamiSavdo','jamiFoyda','jamiQaytim','date','yearchiqim','JQT'));
    }
       function day($oy){
           if($oy < 10){
               $oy = 0+$oy;
           }
        $n = $oy;
        $day = date('d');
        $year = date('Y');
        $month = date('m');
        // dd(date('m'));  
        $data = []; 
        
        // for($n = 1;$n <= 12;$n++){
            for($i = 1; $i <= 31; $i++){
                // $product = Product::where('day' , $i)->where('month',$n)->where('year',$year)->get();
                // $data['product'][$i] = $product;
                $sotuv = Asosiy_sotuvlar::where('day' , $i)->where('month',$n)->where('year',$year)->get();
                $data['sotuvlar'][$i] = $sotuv;
                $chiqim = Chiqim::where('day' , $i)->where('month',$n)->where('year',$year)->get();
                $data['chiqim'][$i] = $chiqim;
                $shqarzhistory = shaxsiyQarzTaminot::where('day' , $i)->where('month',$n)->where('year',$year)->get();
                $data['shqarzhistory'][$i] = $shqarzhistory;
                $qarz = Qarz::where('day' , $i)->where('month',$n)->where('year',$year)->get();
                $data['qarz'][$i] = $qarz;
                $qarzhistory = qarzhistory::where('day' , $i)->where('month',$n)->where('year',$year)->get();
                $data['qarzhistory'][$i] = $qarzhistory;
                $jamiQaytganTavar = qaytip::where('day' , $i)->where('month',$n)->where('year',$year)->get();
                $data['JQT'][$i] = $jamiQaytganTavar;
            }
           
        // }
        // $sotuvlar = $data['sotuvlar'];
        // $chiqim = $data['chiqim'];
        // $qarz = $data['qarz'];
        // $qarzhistory = $data['qarzhistory'];
        // $this->data = $data;
        // dd($data['qarz'][9]);
        // dd($data);
        $date = [];
        for($i=1;$i<=31;$i++){
            $date[$i] = $i;
        }
        // dd($data);
        
        return view('hisob.day',compact('data','date','n'));
    }
    public function kirim(Request $request){
        // dd($request->input());
        $year = date('Y');
        if(intval($request->oy) < 10){
                $oy = "0".$request->oy;
           }
        if(intval($request->kun) < 10){
                $kun = "0".$request->kun;
           }
        $date = $year.'-'.$oy.'-'.$kun;
            // dd($date);
        $product = Product::where('created_at','like','%'.$date.'%')->orderBy('id','desc')->paginate(100);
        
        // hisob
        // $productHisob = Product::where('created_at','like','%'.$request->dateProSearch.'%')->orderBy('id','desc')->get();
        
        $prod_price = 0;
        $prod_shopprice = 0;
        $prod_turi = 0;
        $prod_soni = 0;
        
        $data = [];
        foreach($product as $prod){
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
    
    
    public function prosearch(Request $request){
        
        $request->session()->put('productSearch',$request->prosearch);
        
        $product = Product::where('name' , 'LIKE' , '%'. $request->prosearch . '%' )->orderBy('id','desc')->paginate(100);
        
        $productHisob = Product::where('name' , 'LIKE' , '%'. $request->prosearch . '%' )->orderBy('id','desc')->get();
        
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
        return view('product.index' ,compact('product','prod_price','prod_shopprice','prod_turi','prod_soni'));
      //return view('product.index' , compact('product'));
    }
    public function qaytuvsearch(Request $request){
    
        $product = qaytip::where('name' , 'LIKE' , '%'. $request->prosearch . '%' )->get();
        
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
        // return view('qaytim.index' ,compact('product','prod_price','prod_shopprice','prod_turi','prod_soni'));
      //return view('product.index' , compact('product'));
    }
    public function categoryproductsearch(Request $request){
    
        $product = Product::where('name' , 'LIKE' , '%'. $request->prosearch . '%' )->get();
        
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
      //return view('product.index' , compact('product'));
    }
    public function yillik(){
      $data = date('Y-m-d');
        // dd($date);
        $res = explode('-' , $data);
        $res_two = $res[0];
        $sotu = Asosiy_sotuvlar::where('year' , $res_two)->get();
        $sotuv  = [];
        $foyda = [];
        $skidka = [];
        foreach($sotu as $sot){
             array_push($sotuv , $sot->savdo);
             array_push($foyda , $sot->foyda);
             array_push($skidka , $sot->skidka);
        // dd($sotuv);
        }
        $result = [];
        $result['sotuv'] = array_sum($sotuv);
        $result['foyda'] = array_sum($foyda);
        $result['skidka'] = array_sum($skidka);
        $result['yil'] = $res_two;
        // dd($result);
        $pdf  = Pdf::loadView('yillik',['res'=>$result] , ['sotu' => $sotu] );
        return $pdf->download('invoic.yillik.pdf');
    }
    public function taminitprosearch(Request $request){
        $product = Product::where('taminotchi' , $request->id)->where('name' , 'LIKE' , '%'. $request->name . '%' )->get();
        // dd($product);
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
        $history = shaxsiyQarzTaminot::all()->where('taminotchi_id',$request->id);
        foreach($history as $history){
            $tolavSummaDollor = $tolavSummaDollor + $history->dollor;
            $tolavSummaSom = $tolavSummaSom + $history->som;
        }
        $qoldiqSummaDollor = $jamiSummaDollor - $tolavSummaDollor;
        $qoldiqSummaSom = $jamiSummaSom - $tolavSummaSom;
        $id = $request->id;
        
        
          $prod = Product::where('taminotchi' , $request->id)->where('name' , 'LIKE' , '%'. $request->name . '%' )->get();
        $prod_price = 0;
        $prod_shopprice = 0;
        $prod_turi = 0;
        $prod_soni = 0;
        $mavjud = 0;
        $mavjudlarSummasi = 0;
        foreach($prod as $prod){
            // $prod_price = $prod_price + ($prod->price * $prod->count);
            if($prod->dollor === 0){
                $prod_price = $prod_price +  ($prod->price * $prod->count);
            }
            if($prod->dollor === 1){
                $prod_shopprice = $prod_shopprice +  ($prod->dollors * $prod->count);
            }
            $prod_turi = $prod_turi + 1;
            $mavjud = $mavjud + $prod->count;
            $prod_soni = $prod_soni + $prod->taminotcount;
            $mavjudlarSummasi = $mavjudlarSummasi + ($prod->count * $prod->price);
            // $data['count'][] = $prod->count;
            // $data['name'][] = $prod->name;
            
            // $foyda = $foyda + ($product->shop_price - $product->price);
        }
         $prod = Product::where('taminotchi' , $request->id)->where('name' , 'LIKE' , '%'. $request->name . '%' )->get();
        
        return view('taminotchi.show', compact('prod','jamiSummaDollor','qoldiqSummaDollor','jamiSummaSom','qoldiqSummaSom','id','prod_price','prod_shopprice','prod_turi','prod_soni','mavjud','mavjudlarSummasi'));
        
    }
    public function qarzhistoryDestroy($id){
        // dd($id);
        $qarz = qarzhistory::find(intval($id));
        $qarz->delete();
        $qarz = qarzhistory::all()->where("qarz_id",$id);
        return view("qarz.show",compact("qarz"));
    }
}
