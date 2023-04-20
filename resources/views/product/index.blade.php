@extends('admin.index')

@section('content')

    <style>
        @media(max-width:413){
    .container{
        width: 100% !important;
        margin: 10px 5px !important;
    }
    .content{
        margin:0 auto !important;
        padding: 0 !important;
    }
    .seconds{
        display:none ;
    }
    
}
    </style>
      <h1 class="w-100">Hamma Tavarlar sahifasi</h1>
      <div class="row w-100">
          <form action="{{route('prosearch')}}" class="form-control d-flex col-md-6 col-12">
            <input type="text" name="prosearch" placeholder="Tavar nomi boyicha qidirish" class="form-control mx-1" value="{{ Session::get('productSearch') }}">
            <button class="btn btn-primary ml-1"><i class="bi bi-search"></i></button>
          </form>
          
            <a href="{{route('prosearch')}}" class="btn btn-success  col-md-1 col-6 w-25"><i class="bi bi-x-octagon"></i></a>
            
          <form action="{{route('codsearchproduct')}}" class="form-control  d-flex col-md-2 col-6 w-75" method="post">
              @csrf
            <input type="number" name="code"  class="form-control mx-1" value="{{ Session::get('code') }}">
            <button class="btn btn-primary ml-1"><i class="bi bi-search"></i></button>
          </form>
      </div>
    
    <hr>
   
    <h4 class="d-flex justify-content-between"><b>Tavarlar jami hisobi:</b><a href="{{ route('product.create') }}" class="btn btn-primary">Tavar yaratish</a> <a href="{{ route('taminot.index') }}" class="btn btn-primary">Taminotchi yaratish</a></h4>
    <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th>Tavar turi</th>
                    <th scope="col">Asl baxosi</th>
                    <th scope="col">Sotilish baxosi</th>
                    <th>Jami soni</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Jami</th>
                    <th  >{{  $prod_turi  }}</th>
                    <th id="th" >
                        @if(Auth::user()->role == "adminner")
                        <!--<h1>dfhdjhgh</h1>-->
                        @else
                            <?php
                                setlocale(LC_MONETARY,'en_US');
                                $aslbaxo = money_format('%(#10n',$prod_price);
                                $aslbaxo = explode(' ',$aslbaxo);
                                echo end($aslbaxo);
                            ?>
                        @endif
                    </th>
                    <th id="th">
                        @if(Auth::user()->role == "adminner")
                        <!--<h1>dfhdjhgh</h1>-->
                        @else
                        <?php
                            setlocale(LC_MONETARY,'en_US');
                            $sotishbaxo = money_format('%(#10n',$prod_shopprice);
                            $sotishbaxo = explode(' ',$sotishbaxo);
                            echo end($sotishbaxo);
                        ?>
                        @endif
                    </th>
                    <th class="bg-primary text-white">{{ $prod_soni }}</th>
                </tr>
            </tbody>
        </table>
    <hr>
      {{$product->links()}}
    <h4><b>Tavarlar ro'yxati:</b></h4>
    <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th  class="seconds" scope="col">Kod</th>
                    <th scope="col">Nomi</th>
                    <th scope="col">Kategoriya</th>
                    <th scope="col">Taminotchi</th>
                    <th>Dollor Narxi</th>
                    <th class="seconds" >Narxi</th>
                    <th>Sotilish narxi</th>
                    <th  class="seconds" scope="col">Hisobot</th>
                    <th>Mavjud</th>
                    <th scope="col" style="width:10% !important">Amallar</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    $product->links();
                    $i = 1;
                    // $son = 0;
                    // if($product->currentPage() > $i){
                    //     return $son = $product->currentPage()-1;
                    // }
                     
                    //  $test = 0;
                ?>
                @forelse($product as $prod)
                <tr >
                    <td id="m"  class="seconds" scope="row">{{ $i }}</th>
                    <td class="fw-bold">{{ $prod->id }}</td>
                    <td>{{ $prod->name }}</td>
                    <td>{{ $prod->category->name }}</td>
                    <td>{{$prod->taminotname}}</td>
                    <td id="n">
                        @if(Auth::user()->role == "adminner")
                        <!--<h1>dfhdjhgh</h1>-->
                        @else
                            {{ $prod->dollors }}$
                        @endif
                        </td>
                    <td id="n">
                        <!--{{ $prod->price }}-->
                        @if(Auth::user()->role == "adminner")
                        <!--<h1>dfhdjhgh</h1>-->
                        @else
                            <?php
                                setlocale(LC_MONETARY,'en_US');
                                $price = money_format('%(#10n',$prod->price);
                                $price = explode(' ',$price);
                                echo end($price);
                                
                            ?>
                        @endif
                    </td>
                    <td class="text-white bg-success">
                        <!--{{ $prod->shop_price }}-->
                        <?php
                            setlocale(LC_MONETARY,'en_US');
                            $shopprice = money_format('%(#10n',$prod->shop_price);
                            $shopprice = explode(' ',$shopprice);
                            echo end($shopprice);
                        ?>
                    </td>
                    <td class="seconds" id="th">
                        
                        
                        <?php
                            setlocale(LC_MONETARY,'en_US');
                            $result = money_format('%(#10n',round($prod->price * $prod->count,2));
                            $result = explode(' ',$result);
                            echo end($result);
                            // $test = $test + ($prod->price * $prod->count);
                        ?>
                      
                        </td>
                    <td class="bg-primary text-white">{{ $prod->count }}</td>
                    <td  class="d-flex align-center justify-content-around">
                        @if(Auth::user()->role == "adminner")
                        <!--<h1>dfhdjhgh</h1>-->
                        @else
                            <a href="{{ route('product.edit',$prod->id) }}" class="mt-2 p-0"><i class="bi bi-pencil btn-success w-100 p-2" style='border-radius:5px'></i></a>
                            <form action="{{ route('product.destroy',$prod->id) }}" method="post" class="d-flex align-center ">
                                @csrf
                                @method('delete')
                            <button class="btn-danger w-100 p-1 "style='border-radius:5px'  onclick="return confirmDelete();"><i class="bi bi-trash-fill " ></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                <?php
                    $i++;
                ?>
                @empty
                <h3>Tavar mavjud emas!</h3>
                @endforelse
            </tbody>
        </table>
       
        <!--<h1></h1>-->
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        <script>
            function delet(){
                confirm('Haqiqatdan ham ochirmoqchimisiz?')
            }
            // $(document).ready(function() {}
        </script>
    <style>
            #th{
                background: #111;
            }
            #th:hover{
                background:white;
            }
        #n{
        color: red;
        background-color: red;
    }
    #n:hover {
        color: #fff;
    }
            #m{
        color: black;
    }
    #m:hover {
        background-color: red;
        color: #fff;
    }
</style> 

        
    
        
        

@endsection