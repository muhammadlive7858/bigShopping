<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\taminotchi;
use App\Models\Hodimlar;

class SoftdelCantroller extends Controller
{
    public function index(){
        return view('delete.index');
    }
    public function produc(){
        $pro = Product::onlyTrashed()->get();
      
        return view('delete.produc' ,  compact( 'pro'));
    }
    public function restore($id){
        $cats = Product::onlyTrashed()->findOrFail($id);
       
        // $cats->update([
        //     'image'=>'https://www.publicdomainpictures.net/en/view-image.php?image=270609&picture=not-found-image'
        // ]);
    
        $cats->restore();
        return redirect('/prodelete')->with('tiklash' , 'Categorya tiklandi');
    }
    public function deletepro($id){
        $product = Product::onlyTrashed()->find($id);
        $product->forceDelete();
        return redirect()->route('prodelete');


    }
    // CATEGORY
    public function category(){
        $cats = Category::onlyTrashed()->get();
        return view('delete.category' , compact('cats'));
    }
    public function catsrestore($id){
        $cats = Category::onlyTrashed()->findOrFail($id);
      
        $cats->restore();
        return redirect('/catedelete')->with('tiklash' , 'Categorya tiklandi');
    }
    public function deletecate($id){
        // dd($id);
        Category::onlyTrashed()->find($id)->forceDelete();
        return redirect()->route('catedelete');


    }
    
    // public function tam() {
    //     $pro = taminotchi::onlyTrashed()->get();
    //     return view('delete.taminot' , compact('pro'));
    // }
    // public function tamrestore($id) {

    //     $cats = taminotchi::onlyTrashed()->findOrFail($id);
    //     $cats->restore();
    //     return redirect()->back();
    // }
    // public function hodimdel(){
    //     $pro = Hodimlar::onlyTrashed()->get();
    //     return view('delete.hodim' , compact('pro'));
    // }
}
