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

    
   
    
    
    
    <h1>{{ $oy }} - oyning {{ $kun }}-kuni uchun kirim jadvali</h1>
    <hr>
    <h4><b>Kirim jami hisobi:</b></h4>
    <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th>Tavar turi</th>
                    <th scope="col">Jami So'm baxosi</th>
                    <th scope="col">Jami Dollor baxosi</th>
                    <th>Jami soni</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Jami</th>
                    <th  >{{  $i  }}</th>
                    <th id="th" >
                        @if(Auth::user()->role == "adminner")
                        <!--<h1>dfhdjhgh</h1>-->
                        @else
                            <?php
                                setlocale(LC_MONETARY,'en_US');
                                $aslbaxo = money_format('%(#10n',$jamiSummaSom);
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
                            $sotishbaxo = money_format('%(#10n',$jamiSummaDollor);
                            $sotishbaxo = explode(' ',$sotishbaxo);
                            echo end($sotishbaxo);
                        ?>
                        @endif
                    </th>
                    <th class="bg-primary text-white">{{ $soni }}</th>
                </tr>
            </tbody>
        </table>
    <hr>
    <h4><b>Kirim ro'yxati:</b></h4>
    <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th scope="col">Nomi</th>
                    <th scope="col">Taminotchi</th>
                    <th>Dollor Narxi</th>
                    <th class="seconds" >Narxi</th>
                    <th>Sotilish narxi</th>
                    <th>Mavjud</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                ?>
                @forelse($kirimlar as $prod)
                <tr>
                    <td  class="seconds" scope="row">{{ $i }}</th>
                    <td>{{ $prod->name }}</td>
                    <td>{{ App\Models\taminotchi::findorFail($prod->taminotchi)->name }}</td>
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
                    <td class="bg-primary text-white">{{ $prod->count }}</td>
                    
                </tr>
                <?php
                    $i++;
                ?>
                @empty
                <h3>Tavar mavjud emas!</h3>
                @endforelse
            </tbody>
        </table>
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
        </style> 
        
    
        
        

@endsection