@extends('admin.index')

@section('content')
<h1 class="w-100">{{ $cateName->name }} kategoriya Tavarlari sahifasi</h1>
      <form action="{{route('cateprosearch')}}" class="form-control d-flex">
         <input type="text" name="prosearch" placeholder="Tavar nomi boyicha qidirish" class="form-control mx-1">
         <button class="btn btn-primary ml-1"><i class="bi bi-search"></i></button>
    </form>
    <form action="{{route('catecodsearchproduct')}}" class="form-control d-flex" method="post">
        @csrf
         <input type="number" name="code" placeholder="Tavar kodi boyicha qidirish" class="form-control mx-1">
         <button class="btn btn-primary ml-1"><i class="bi bi-search"></i></button>
    </form>
    
    <hr>
     <h4><b>Tavarlar jami hisobi:</b></h4>
    <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th>Tavarlar soni</th>
                    <th scope="col">Asl baxosi</th>
                    <th scope="col">Sotuv_baxosi</th>
                    <!--<th>Foyda</th>-->
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>{{ $s }}</th>
                    <th  >{{  $soni  }}</th>
                    <th id="n" >
                        <?php
                            setlocale(LC_MONETARY,'en_US');
                            $kelishbaxo = money_format('%(#10n',$kelish);
                            $kelishbaxo = explode(' ',$kelishbaxo);
                            echo end($kelishbaxo);
                        ?>
                    </th>
                    <th class="bg-success text-white">
                        <?php
                            setlocale(LC_MONETARY,'en_US');
                            $sotishBAxo = money_format('%(#10n',$sotish);
                            $sotishBAxo = explode(' ',$sotishBAxo);
                            echo end($sotishBAxo);
                        ?>
                    </th>
                    <!--<th class="bg-primary text-white">{{ $res }}</th>-->
                </tr>
            </tbody>
        </table>
<hr>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Nomi</th>
            <th scope="col">Kodi</th>
            <th scope="col">Baxosi</th>
            <th scope="col">Sotilish Baxosi</th>
            <th scope="col">Mavjud</th>
        </tr>
    </thead>
    <tbody>
        <?php  
            $i = 1;
        ?>
        @forelse($product as $proo)
        <tr>
            
            <td><?php echo $i;  ?></td>
            <td>{{$proo->name}}</td>
            <td><b>{{ $proo->id }}</b></td>
            <td id="n">{{$proo->price}}</td>
            <td>{{$proo->shop_price}}</td>
            <td>{{$proo->count}}</td>

            <?php  $i++;  ?>
        </tr>
        @empty
        <tr>
            <th class="bg-danger text-white">Bu Categoryada tavarlar mavjud emas Tavar qoshish bolimiga o'ting va tavar qo'shing</th>
        </tr>
        @endforelse
    </tbody>
</table>
<style>
    table,thead,tbody,tr,th,td{
        border-collapse: collapse;
        border: 1px solid #aaa;
    }
    tr:hover{
        background-color: #111;
        color: #fff;
    }
</style>
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
        </style>
@endsection
<!-- 1648534549 -->