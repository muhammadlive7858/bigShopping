<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use App\Models\Qarz;
use App\Models\setting;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $count_product = setting::first();
        Paginator::useBootstrap();
        $proCount = Product::where('count' , '<' , $count_product->less_product)->count();
        $vaqt = date('Y-m-d');
        // dd($vaqt);
        $qarz = Qarz::where('vaqt',$vaqt)->count();
        // $qarz = "";
      $dollar = file_get_contents('https://cbu.uz/oz/arkhiv-kursov-valyut/json/');
      $json = json_decode($dollar, true);
      $rate = $json[0]['Rate'];


        View::share('proCount' , $proCount );
        View::share('QarzProvider' , $qarz );
         View::share('rate' , $rate );


    }
    
}
