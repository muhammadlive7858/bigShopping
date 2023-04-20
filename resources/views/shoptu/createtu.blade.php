@extends('admin.index')

@section('content')
@if(Session::has('text'))
<div class="alert alert-success">
    {{Session::get('text')}}
</div>

@endif

<div class="d-flex justify-content-between">
<h2>Ikkinchi Sotuv Ofisi</h2>

<a href="{{route('shop-indexthree')}}" class="btn btn-primary text-white">Uchinchi  Sotuv paneliga o'tish</a>
</div>
<hr>
<hr>



<div class="row g-3 d-flex justify-content-between align-center form-control m-1 header-mazza" action="">
    @csrf
    <!-- Nom qidiruv -->
    <div class="col-md-5 d-flex aling-center justify-content-between row">
        <form action="{{ route('productsearchtu') }}"  method="post" class="w-100 d-flex align-center justify-content-between  ">
            
            @csrf
            <div class="col-auto" style="width:80%">
                <label for="inputPassword21" class="visually-hidden">Tavar</label>
                <input type="text" name="productsearch" class="form-control" id="search" placeholder="Tavar nomini kiriting:">
            </div>
            <div class="col-auto">
                <button id="submit" class="btn btn-primary mb-2"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <form action="{{route('create_vaqtinchatu')}}"  class="d-flex justify-content-between w-100 col-6" method="post">
            @csrf
            @method('post')
            <select name="productid" id="" class="w-100 form-select" style="width:80%;margin-right:5px">
                <option selected disabled>Tavar tanlang</option>
                @if(isset($productname))
                    @forelse($productname as $product_id)
                    <option value="{{ $product_id->id }}">{{ $product_id->name }}</option>
                    @empty
                    <option value="">Tavar mavjud emas</option>
                    @endforelse
                @endif
            </select>
            <button class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i></button>
        </form>
    </div>
    <!-- ID qidiruv -->
    <form action="{{ route('product-idtu') }}" class=" div col-md-5 d-flex aling-center justify-content-between">
        <div class="col-auto" style="width:80%">
            <label for="inputPassword2" class="visually-hidden">Tavar</label>
            <input type="text" name="productid" class="form-control" id="inputPassword2" placeholder="ID kiriting:">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2"><i class="bi bi-search"></i></button>
        </div>
    </form>
</div>

<hr>



<div class="row">
    <div class="col-10" style="min-width:350px">
        
        @if(!empty($prod_vaqt))

            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th scope="col" style="width:10%">#</th>
                        <th scope="col">Tavar nomi</th>
                        <th style="width:10%">Narxi</th>
                        <th scope="col" style="width:10%">mavjud</th>
                        <th scope="col" style="width:20% !important">Sotilmoqda...</th>
                        <th>o'chirish...</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prod_vaqt as $prod)
                    <tr>
                        <form action="{{ route('edittu',$prod['id']) }}" method="post">
                            @csrf
                                <td scope="row" style="width:10%">{{ $prod['product_id'] }}</th>
                                <td>{{ $prod['product_name'] }}</td>
                                <td class=" fw-bold bg-danger text-white">{{ $prod['price'] }}</td>
                                 <input type="hidden" value="{{ $prod['price'] }}" class="form-number">
                                <input type="hidden" name="product[]" value="{{ $prod['product_id'] }}">
                                <td style="width:10%" class="text-white fw-bold bg-success">{{ $prod['product_count'] }}</td>
                                <td class="d-flex justify-content-around align-center">
                                    @csrf
                                    @method('POST')
                                    <input type="text" step="any" name="inputVal"  value="{{ $prod['inputVal'] }}" id="sum" class="input-number" placeholder="Tavarlar soni:">
                                    <input class="p-2 m-2 input-control " style="width:50px" type="hidden" name="prod_id[]" id="" value="{{ $prod['product_id'] }}">
                                    <button class="btn btn-primary"><i class="bi bi-plus"></i></button>
                                </td>
                        </form>
                                <td>
                                    <form action="{{ route('deleteOnetu') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product" value="{{ $prod['id'] }}">
                                        <button  onclick="return confirmDelete();" class="btn btn-danger w-100"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
@else
<h1 class="">Tavar Qo'shing</h1>
@endif



<hr>
</div>
        <form class="col-2 d-flex flex-column" action="{{ route('hisoblashtu') }}" method="">
            <div class="d-flex justify-content-end mb-1 w-100  ">
                <button  id="btn" class="btn btn-primary w-40 p-3 m-auto"><i class="bi bi-calculator fs-1"></i></button>
            </div>
        </form>

    <div class="col-10 d-flex flex-column" style="min-width:350px">
        <div class="div w-100 d-flex align-center justify-content-center  flex-column">
             
            <h1 class="text-success fw-bold">
                @if(!empty($savdo))
                <?php
                setlocale(LC_MONETARY,'en_US');
                $sotuv = money_format('%(#10n',$savdo);
                $sotuv = explode(' ',$sotuv);
                echo end($sotuv);
                ?>
                @else
                <span></span>
                @endif
               <b>Sum: </b>

            </h1>
            <form action="{{ route('fullhisobtu') }}" method="post">
                @csrf
                @if(!empty($savdo))
                <input type="hidden" name="savdo" value="{{ $savdo }}">
                @else
                <span></span>
                @endif

                @if(!empty($savdo))
                @forelse($product_mossiv as $product)
                <input type="hidden" name="product[]" value="{{ $product }}">

                @empty
                @endforelse
                @else
                @endif

                @if(!empty($savdo))
                @forelse($sotish_soni_mossiv as $son)
                <input type="hidden" name="count[]" value="{{ $son }}">
                @empty
                @endforelse
                @else
                @endif
                <div>
                    <input type="number" step="1000" class="form-control" name="plastik" placeholder="Plastik to'lov" class="form-control">
                </div>

                <h6 class="w-100 my-2"><b>Qaytim:</b></h6>
                <div class="d-flex justify-content-between mt-1 ">
                    <input type="number" id="input" step="1000" name="skidka" value="0" class="form-control  w-100">
                </div>
                <div class="d-flex justify-content-between mt-1 ">
                    <select name="client_id" id="" class="form-control  w-50 m-1">
                    <option value="">Mijozni tanlang</option>
                        @if(isset($client))
                            @forelse($client as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @empty
                            <option value="">Mijoz mavjud emas</option>
                            @endforelse
                        @endif
                </select>
                <a href="{{ route('qarz.index') }}" class="btn btn-primary w-50 p-1 m-1">Mijoz yaratish</a>
                </div>
                <div>
                    <label class="w-100 d-flex justify-content-between">
                        <h4>Sotuv qarzga amalga oshirilsinmi:</h4>
                        <input type="checkbox" name="shop_debt">
                    </label>
                    <label class="w-100 d-flex justify-content-between">
                        <h4>Hozirgi to'lanish summasi:</h4>
                        <input type="number" name="history_summa" class="form-control w-50 m-1" step="1000">
                    </label>
                    <label class="w-100 d-flex justify-content-between">
                        <h4>Qarz to'lash vaqti:</h4>
                        <input type="date" name="date" class="form-control w-50 m-1">
                    </label>
                </div>
                <div class="d-flex">
                    <button onclick="sotish()" id="btc" class="btn btn-primary w-50 mx-1">
                        <i class="bi bi-send fs-2  "></i>
                        <span id="text">Sotish</span>
                        <span id="loading-animate"></span>
                    </button>
                    <a href="{{route('tozalashtu')}}"  onclick="return confirmDelete();" id="btd" style="background-color:red;" class="btn btn-danger w-50 mx-1"><i class="bi bi-trash fs-2"></i></a>
                </div>
            </form>
        </div>
        <!--</div>-->
        <hr>

        <style>
            #btc {
                background-color: #49D75C;
                border: 0px solid #49D75C;
                border-radius: 30px;
                font-size: 1rem;
                font-weight: bold;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                outline: none;
                transition: all .25s ease;
                width: 200px;
                position: relative;
                height: 50px;
                overflow: hidden;

            }

            #btc i {
                font-size: 1.30rem;
                position: absolute;
                left: 10px;
                pointer-events: none;
                z-index: 10;
                background: inherit;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: all .25s ease;
            }

            #btc #text {
                width: 120px;
                display: block;
                position: relative;
                pointer-events: none;
                transition: all .25s ease;
                position: absolute;
                left: 30px;
            }

            #btc:not(#loading, #text):hover {
                box-shadow: 0px 10px 25px 0px rgba(73, 215, 92, 4);
            }

            #btc:not(#loading, #text):hover i {
                transform: translate(7px);
            }


            #btd {
                background-color: #49D75C;
                border: 0px solid #49D75C;
                border-radius: 30px;
                font-size: 1rem;
                font-weight: bold;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                outline: none;
                transition: all .25s ease;
                width: 200px;
                position: relative;
                height: 50px;
                overflow: hidden;

            }

            #btd i {
                font-size: 1.30rem;
                position: absolute;
                left: 10px;
                pointer-events: none;
                z-index: 10;
                background: inherit;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: all .25s ease;
            }

            #btd #text {
                width: 120px;
                display: block;
                position: relative;
                pointer-events: none;
                transition: all .25s ease;
                position: absolute;
                left: 30px;
            }

            #btd:not(#loading, #text):hover {
                box-shadow: 0px 10px 25px 0px rgba(red);
            }

            #btd:not(#loading, #text):hover i {
                transform: translate(7px);
            }

            table tr:hover {
                transform: translate(6px);
                transition: all .3s;
            }
        </style>

        <div class="spinner-grow text-dark position-fixed d-none w-100 h-100" role="status" id="animation">
            <span class="sr-only">Loading...</span>
        </div>

    </div>
</div>
</div>
<!-- <form action="{{route('pdf')}}">
    @if(!empty($savdo))
    <input type="hidden" value="{{$savdo}}" name="price">
    @else 
    <input type="hidden" name="">
    @endif
  

<button href="" class="btn btn-success w-30 px-4 mt-1"><i class="bi bi-file-pdf fs-3"></i></button>

</form> -->




<!-- Modal -->

<!-- Button trigger modal -->
<script>

 let formNums = document.querySelectorAll('.form-number');
     let inputNums = document.querySelectorAll('.input-number');
     let formN = Array.from(formNums)
     let inputN = Array.from(inputNums)
     inputN.forEach((item) => {
         item.addEventListener('input' , () => {
             formN.forEach((key, value) => {
                 inputN.forEach((key1 , value1) => {
                     if(value == value1){
                         sum += +key?.value * (+key1?.value)
                     }
                 })
             })
             document.querySelector('b').innerHTML = sum
             sum = 0
         })
     })
     let sum = 0;

        
   
</script>

@endsection

