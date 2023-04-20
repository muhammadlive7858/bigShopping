@extends('admin.index')

@section('content')


<!-- End Search Bar -->

<h2>Sotuv Ofisi</h2>
<hr>

<style>
   
</style>

<div class="row g-3 d-flex justify-content-between align-center form-control m-1 wrap " >
    @csrf
    <!-- Nom qidiruv -->
    <div class="col-md-5 ">
    <form action="{{ route('productsearch') }}" method="post"     class="w-100 d-flex aling-center justify-content-between">
     @csrf
        <div class="col-auto" style="width:80%">
            <label for="inputPassword21" class="visually-hidden">Tavar</label>
            <input type="text" value="" name="productsearch"  class="form-control" id="inputPassword21" placeholder="Tavar nomini kiriting:">
        </div>
        <div class="col-auto">
            <button id="submit" class="btn btn-primary mb-2"><i class="bi bi-search"></i></button>
        </div>
    </form>
    @if(isset($productname))
        @forelse($productname as $product_id)
        <form  action="{{route('create_vaqtincha' , $product_id->id)}}" class="d-flex justify-content-between w-100 col-6" method="post">
       <div id="from">
        <div>
            <button class="btn btn-primary mb-1" style="width:100%;" >{{$product_id->name}}</button>
          </div>
       </div>
            {{-- <button class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i></button> --}}
            @csrf
        </form>
        @empty
        <h5>Tavar Mavjud Emas</h5>
        @endforelse
        @endif
    </div>
    <!-- ID qidiruv -->
    <form action="{{ route('product-id') }}" class=" div col-md-4 d-flex aling-center justify-content-between">
    <div class="col-auto" style="width:80%">
        <label for="inputPassword2" class="visually-hidden">Tavar</label>
        <input type="text" name="productid"  class="form-control" id="inputPassword2" placeholder="ID kiriting:">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-2"><i class="bi bi-search"></i></button>
    </div>
    </form>
    <a href="{{ route('hisoblash') }}" class="btn btn-primary col-md-2 m-1">Karzinka</a>
   
</div>

<hr>




 
@endsection