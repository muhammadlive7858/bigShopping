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
    <h1 class="w-100">Qaytim Tavarlar sahifasi</h1>
    <form action="{{route('qaytuvsearch')}}" class="form-control d-flex">
            <input type="text" name="prosearch" placeholder="Tavar nomi boyicha qidirish" class="form-control mx-1">
            <button class="btn btn-primary ml-1"><i class="bi bi-search"></i></button>
    </form>
    
    <hr>
    <h4><b>Tavarlar jami hisobi:</b></h4>
    <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th>Qaytuvlar soni</th>
                    <th scope="col">Qaytuvlar summasi</th>
                    <th>Qaytuvlar miqdori</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Jami</th>
                    <th  >{{  $qaytuv_soni  }}</th>
                    <th class="bg-success text-white">{{  $qaytuv_shopprice  }}</th>
                    <th class="bg-primary text-white">{{ $qaytuv_miqdori }}</th>
                </tr>
            </tbody>
        </table>
    <hr>
    <h4><b>Tavarlar ro'yxati:</b></h4>
    <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th scope="col">Nomi</th>
                    <th class="seconds" >Narxi</th>
                    <th>Sotilish narxi</th>
                    <th>Soni</th>
                    <th scope="col" style="width:10% !important">Amallar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                ?>
                @forelse($product as $prod)
                <tr>
                    <td  class="seconds" scope="row">{{ $i }}</th>
                    <td>{{ $prod->productname }}</td>
                    <td id="n">{{ $prod->price }}</td>
                    <td class="text-white bg-success">{{ $prod->shop_price }}</td>
                    <td class="bg-primary text-white">{{ $prod->count }}</td>
                    <td  class="d-flex align-center justify-content-around">
                        <a href="{{ route('qaytuv.edit',$prod->id) }}" class="mt-2 p-0"><i class="bi bi-pencil btn-success w-100 p-2" style='border-radius:5px'></i></a>
                        <form action="{{ route('qaytuv.destroy',$prod->id) }}" method="post" class="d-flex align-center ">
                            @csrf
                            @method('delete')
                        <button class="btn-danger w-100 p-1 "style='border-radius:5px'  onclick="return confirmDelete();"><i class="bi bi-trash-fill " ></i></button>
                        </form>
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
        <!-- <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        <script>
            function delet(){
                confirm('Haqiqatdan ham ochirmoqchimisiz?')
            }
            $(document).ready(function() {
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
</style> -->
        
    
        
        

@endsection