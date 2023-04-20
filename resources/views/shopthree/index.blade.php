@extends('admin.index')

@section('content')


<!-- End Search Bar -->

<h2>Uchinchi Sotuv Ofisi</h2>
<hr>

<style>
   
</style>
@if (\Session::has('text'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('text') !!}</li>
        </ul>
    </div>
@endif

<div class="row g-3 d-flex justify-content-between align-center form-control m-1 wrap " >
    @csrf
    <!-- Nom qidiruv -->
    <!--<div class="col-md-5 d-flex aling-center justify-content-between row ">-->
        <form action="{{ route('productsearchthree') }}" method="post" class="d-flex align-center justify-content-between col-md-5 ">
         @csrf
            <div class="col-auto" style="width:80%">
                <label for="inputPassword21" class="visually-hidden">Tavar</label>
                <input type="text" value="" name="productsearch"  class="form-control" id="inputPassword21" placeholder="Tavar nomini kiriting:">
            </div>
            <div class="col-auto">
                <button id="submit" class="btn btn-primary mb-2"><i class="bi bi-search"></i></button>
            </div>
        </form>
        
    <!--</div>-->
    <!-- ID qidiruv -->
    <form action="{{ route('product-idthree') }}" class=" div col-md-5 d-flex aling-center justify-content-between">
        <div class="col-auto" style="width:80%">
            <label for="inputPassword2" class="visually-hidden">Tavar</label>
            <input type="text" name="productid" class="form-control" id="inputPassword2" placeholder="ID kiriting:">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2"><i class="bi bi-search"></i></button>
        </div>
    </form>
    <a href="{{ route('hisoblashthree') }}" class="btn btn-primary col-md-2">Karzinka</a>
    
   
</div>
<hr>
<div class="w-100 m-1" >
  
        @forelse($product as $product)
            <form action="{{route('create_vaqtinchathree')}}" method="post" class="row form-control">
                @csrf
                    <h4 class="col-md-6">{{ $product->name }}</h4>
                    <h4 class="col-md-3">{{ $product->count }}</h4>
                    <h4 class="col-md-3 text-danger">{{ $product->shop_price }}</h4>
                    <input name="product" type="hidden" value="{{ $product }}"/>
                    <div class="w-100 row">
                        <input name="count" type="float" placeholder="Tavarning sonini kiriting:" class="col-md-6 input"/>
                        <button class="btn btn-outline-primary col-md-6" ><i class="bi bi-plus-circle"></i></button>
                    </div>
            </form>
        @empty
            
        @endforelse
</div>


<hr>




 
@endsection