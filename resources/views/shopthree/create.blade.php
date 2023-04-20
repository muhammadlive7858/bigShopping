@extends('admin.index')

@section('content')
@if(Session::has('text'))
<div class="alert alert-success">
    {{Session::get('text')}}
</div>

@endif

<h2>Uchinchi Sotuv Ofisi</h2>
<hr>



<div class="row g-3 d-flex justify-content-between align-center form-control m-1 header-mazza" action="">
    @csrf
    <!-- Nom qidiruv -->
    <div class="col-md-5 d-flex aling-center justify-content-between row">
        <form action="{{ route('productsearchthree') }}"  method="post" class="w-100 d-flex align-center justify-content-between  ">
            @csrf
            <div class="col-auto" style="width:80%">
                <label for="inputPassword21" class="visually-hidden">Tavar</label>
                <input type="text" name="productsearch" class="form-control" id="inputPassword21" placeholder="Tavar nomini kiriting:">
            </div>
            <div class="col-auto">
                <button id="submit" class="btn btn-primary mb-2"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <!--<form action="{{route('create_vaqtinchathree')}}"  class="d-flex justify-content-between w-100 col-6" method="post">-->
        <!--    @csrf-->
        <!--    @method('post')-->
        <!--    <select name="productid" id="" class="w-100 form-select" style="width:80%;margin-right:5px">-->
        <!--        <option selected disabled>Tavar tanlang</option>-->
        <!--        @if(isset($productname))-->
        <!--            @forelse($productname as $product_id)-->
        <!--            <option value="{{ $product_id->id }}">{{ $product_id->name }}</option>-->
        <!--            @empty-->
        <!--            <option value="">Tavar mavjud emas</option>-->
        <!--            @endforelse-->
        <!--        @endif-->
        <!--    </select>-->
        <!--    <button class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i></button>-->
        <!--</form>-->
    </div>
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
</div>

<hr>



<div class="row">
    <div class="col-10"  style="min-width:350px">
        
        <table class="table table-bordered w-100">
            <thead>
                <tr>
                    <th scope="col" style="width:10%">#</th>
                    <th scope="col">Tavar nomi</th>
                    <th style="width:10%">Narxi</th>
                    <th scope="col" style="width:10%">mavjud</th>
                    <th scope="col" style="width:20% !important">Sotilmoqda...</th>
                    <th>o'chirish</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                ?>
                    @if(!empty($prod_vaqt))
                    @foreach($prod_vaqt as $prod)
                    <tr>
                        <form action="{{ route('editthree',$prod['id']) }}" method="post">
                            @csrf
                                <td scope="row" style="width:10%">{{ $i }}</th>
                                <td>{{ $prod['product_name'] }}</td>
                                <td class=" fw-bold bg-danger text-white">{{ $prod['price'] }}
                                <input type="hidden" id="itemSum"  value="{{ $prod['price'] }}">
                                </td>
                                
                                <input type="hidden" name="product[]" value="{{ $prod['product_id'] }}">
                                <td style="width:10%" class="text-white fw-bold bg-success">{{ $prod['product_count'] }}</td>
                                <td class="d-flex justify-content-around align-center">
                                    @csrf
                                    @method('POST')
                                    <input type="text" step="any" name="inputVal" value="{{ $prod['inputVal'] }}" id="item" class="form-control" placeholder="Tavarlar soni:">
                                    <input class="p-2 m-2 input-control " style="width:50px" type="hidden" name="prod_id[]" id="" value="{{ $prod['product_id'] }}">
                                    <button class="btn btn-primary"><i class="bi bi-plus"></i></button>
                                </td>
                                <td>
                        </form>
                                    <form action="{{ route('deleteOnethree') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="karzinka" value="karzinka3">
                                        <input type="hidden" name="product" value="{{ $prod['id'] }}">
                                        <button class="btn btn-danger w-100"  onclick="return confirmDelete();"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                    </tr>
                        <?php 
                            $i++;
                        ?>
                    @endforeach
                
                    @else
                    <h1>Tavar Qo'shing</h1>
                    @endif
                </tbody>
            </table>

<hr>
</div>
        <form class="col-2 d-flex flex-column" action="{{ route('hisoblashthree') }}" method="">
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



            </h1>
            <form action="{{ route('fullhisobthree') }}" method="post">
                @csrf
                @if(!empty($savdo))
                <input type="hidden" name="savdo" value="{{ $savdo }}">
                <b></b>
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
                    <input type="number" id="input" name="skidka" value="0" step="1000" class="form-control  w-100">
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
                <a href="{{ route('client.create') }}" class="btn btn-primary w-50 p-1 m-1">Mijoz yaratish</a>
                <button type="button" class="btn btn-primary w-25 m-1" data-toggle="modal" data-target="#exampleModal">
                  Qarz savdo
                </button>
                </div>
                
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Qarz savdo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!--<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
                            <label class="w-100 d-flex justify-content-between">
                                <h4>Sotuv qarzga amalga oshirilsinmi:</h4>
                                <input class="checkModal" type="checkbox" name="shop_debt">
                            </label>
                            
                            <!--<div class="modal">-->
                                <label class="w-100 d-flex justify-content-between">
                                    <h4>Hozirgi to'lanish summasi:</h4>
                                    <input type="number" name="history_summa" class="form-control w-50 m-1" step="1000">
                                </label>
                                <label class="w-100 d-flex justify-content-between">
                                    <h4>Qarz to'lash vaqti:</h4>
                                    <input type="date" name="date" class="form-control w-50 m-1">
                                </label>
                            <!--</div>-->
                        <!--</div>-->
                      </div>
                      <div class="modal-footer">
                        <div class="d-flex w-100">
                            <button onclick="sotish()" id="btc" class="btn btn-primary w-50 mx-1">
                                <i class="bi bi-send fs-2  "></i>
                                <span id="text">Sotish</span>
                                <span id="loading-animate"></span>
        
        
                            </button>
                            <a  onclick="return confirmDelete();" href="{{route('tozalashthree')}}" id="btd" style="background-color:red;" class="btn btn-danger w-50 mx-1"><i class="bi bi-trash fs-2"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                
                <div class="d-flex">
                    <button onclick="sotish()" id="btc" class="btn btn-primary w-50 mx-1">
                        <i class="bi bi-send fs-2  "></i>
                        <span id="text">Sotish</span>
                        <span id="loading-animate"></span>


                    </button>
                    <a  onclick="return confirmDelete();" href="{{route('tozalashthree')}}" id="btd" style="background-color:red;" class="btn btn-danger w-50 mx-1"><i class="bi bi-trash fs-2"></i></a>
                </div>
            </form>
        </div>
        <!--</div>-->
        <hr>
        <script>
            let checkbox = document.querySelector('.checkModal');
            let div = document.querySelector('.modal');
            checkbox.addEventListener.checked(funtion(){
                div.style.display = 'block'
            })
        </script>
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


<!-- input:number_format -->
<!-- Modal -->

<!-- Button trigger modal -->
<script>
    // function increment() {
    //     let inputval = document.querySelector('#input').value;
    //     inputval *= 1
    //     inputval = inputval + 1000;
    //     document.querySelector('#input').value = inputval
    // }

    // function decrement() {
    //     let inputval = document.querySelector('#input').value;
    //     inputval *= 1
    //     inputval = inputval - 1000;
    //     document.querySelector('#input').value = inputval
    // }
    </script>
</script>

@endsection

