@extends('admin.index')

@section('content')
    
        <h4>Dollor $ hisobi qarzlar</h4>
        <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th scope="col">Jami Summa</th>
                    <th  class="seconds" scope="col">Qoldiq Summa</th>
                    <th  class="seconds" scope="col">To'lash</th></th>
                    <th>To'lav tarixi</th>
                </tr>
            </thead> 
            <tbody>
                <?php
                    $i = 1;
                ?>
                <tr>
                    <td  class="seconds" scope="row">{{ $i }}</th>
                    <td>{{ $jamiSummaDollor }}$</td>
                    <td class="seconds">{{ $qoldiqSummaDollor }}$</td>
                    <td class="seconds">
                        <a href="{{ route('shqarz-create',$id) }}" class="btn btn-primary">To'lash</a>
                    </td>
                    <td class="bg-primary text-white">
                        <a href="{{ route('shqarz-show',$id) }}" class="btn btn-success w-100">To'lav tarixi</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h4>Som hisobi qarzlar</h4>
        <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th scope="col">Jami Summa</th>
                    <th  class="seconds" scope="col">Qoldiq Summa</th>
                    <th  class="seconds" scope="col">To'lash</th></th>
                    <th>To'lav tarixi</th>
                </tr>
            </thead> 
            <tbody>
                <?php
                    $i = 1;
                ?>
                <tr>
                    <td  class="seconds" scope="row">{{ $i }}</th>
                    <td>
                        <!--{{ $jamiSummaSom }}-->
                        <?php
                            setlocale(LC_MONETARY,'en_US');
                            $jamiSom = money_format('%(#10n',$jamiSummaSom);
                            $jamiSom = explode(' ',$jamiSom);
                            echo end($jamiSom);
                        ?>
                    </td>
                    <td class="seconds">
                        <!--{{ $qoldiqSummaSom }}-->
                        <?php
                            if($qoldiqSummaSom < 0){
                                echo "-";
                            }
                            setlocale(LC_MONETARY,'en_US');
                            $qoldiqSom = money_format('%(#10n',$qoldiqSummaSom);
                            $qoldiqSom = explode(' ',$qoldiqSom);
                            echo end($qoldiqSom);
                        ?>
                        </td>
                    <td class="seconds">
                        <a href="{{ route('shqarz-createSom',$id) }}" class="btn btn-primary">To'lash</a>
                    </td>
                    <td class="bg-primary text-white">
                        <a href="{{ route('shqarz-showSom',$id) }}" class="btn btn-success w-100">To'lav tarixi</a>
                    </td>
                </tr>
            </tbody>
        </table>
        
            <h1 class="w-100">Taminotchi tavarlar Qidiruvi</h1>
            <div class="row w-100">
                <form action="{{route('taminitprosearch')}}" class="form-control d-flex col-md-6">
                 <input type="text" name="name" placeholder="Tavar nomi boyicha qidirish" class="form-control mx-1">
                 <input type="hidden" name="id" value="{{$id}}">
                    <button class="btn btn-primary ml-1"><i class="bi bi-search"></i></button>
                </form>
                
                <form action="{{route('codsearchtaminotproduct')}}" class="form-control  d-flex  col-md-6" method="post">
                  @csrf 
                    <input type="hidden" name="taminot_id" value="{{ $id }}">
                    <input type="number" name="code"  class="form-control mx-1" value="{{ Session::get('code') }}" placeholder="Tavar kodini kiriting:">
                        <button class="btn btn-primary ml-1"><i class="bi bi-search"></i></button>
              </form>
            </div>
              
            
           
            
            
            
            
            <hr>
            <h4><b>Tavarlar jami hisobi:</b></h4>
            <table class="table table-bordered w-100 table-responsive">
                    <thead>
                        <tr class="">
                            <th  class="seconds" scope="col">#</th>
                            <th>Tavar turi</th>
                            <th>Hozirda mavjudlari-Summasi</th>
                            <th>Hozirda mavjudlari soni</th>
                            <th scope="col">So'm baxosi</th>
                            <th scope="col">Dollor baxosi</th>
                            <th>Jami soni</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Jami</th>
                            <th  >{{  $prod_turi  }}</th>
                            <th>
                                <?php
                                    setlocale(LC_MONETARY,'en_US');
                                    $mavjudSumma = money_format('%(#10n',$mavjudlarSummasi);
                                    $mavjudSumma = explode(' ',$mavjudSumma);
                                    echo end($mavjudSumma);
                                ?>
                            </th>
                            <th>
                                {{ $mavjud }}
                            </th>
                            <th id="th" >
                                <!--{{  $prod_price  }}-->
                                <?php
                                    setlocale(LC_MONETARY,'en_US');
                                    $price = money_format('%(#10n',$prod_price);
                                    $price = explode(' ',$price);
                                    echo end($price);
                                ?>
                                </th>
                            <th class="bg-success text-white">
                                <!--{{  $prod_shopprice  }}-->
                                <?php
                                    setlocale(LC_MONETARY,'en_US');
                                    $shopprice = money_format('%(#10n',$prod_shopprice);
                                    $shopprice = explode(' ',$shopprice);
                                    echo end($shopprice);
                                ?>
                                </th>
                            <th class="bg-primary text-white">{{ $prod_soni }}</th>
                        </tr>
                    </tbody>
                </table>
            <hr>
        
        <hr><h1 class="w-100">Taminotchi tamonidan kiritilgan tavarlar:</h1>
    <table class="table table-bordered w-100 table-responsive">
            <thead>
                <tr class="">
                    <th  class="seconds" scope="col">#</th>
                    <th class="seconds">Kodi</th>
                    <th scope="col">Nomi</th>
                    <th  class="seconds" scope="col">Dollor baxosi</th>
                    <th  class="seconds" scope="col">So'm baxosi</th>
                    <th  class="seconds" scope="col">Kirim vaqti</th>
                    <th>Hozirda mavjud</th>
                    <th>Soni</th>
                    <th>Amallar</th>
                </tr>
            </thead> 
            <tbody>
                <?php
                    $i = 1;
                ?>
            @forelse($prod as $prod)
                <tr>
                    <td  class="seconds" scope="row">{{ $i }}</th>
                    <td  class="seconds" scope="row"><b>{{ $prod->id }}</b></th>
                    <td>{{ $prod->name }}</td>
                    <td class="seconds">
                        <!--{{ $prod->dollors }}-->
                        <?php
                                    setlocale(LC_MONETARY,'en_US');
                                    $prodDollor = money_format('%(#10n',$prod->dollors);
                                    $prodDollor = explode(' ',$prodDollor);
                                    echo end($prodDollor);
                                ?>
                        </td>
                    <td class="seconds">
                        <!--{{ $prod->price }}-->
                        <?php
                                    setlocale(LC_MONETARY,'en_US');
                                    $prodprice = money_format('%(#10n',$prod->price);
                                    $prodprice = explode(' ',$prodprice);
                                    echo end($prodprice);
                                ?>
                        </td>

                    <td class="seconds">
                        {{ $prod->created_at }}
                    </td>
                    <th>{{ $prod->count }}</th>
                    <td class="bg-primary text-white">{{ $prod->taminotcount }}</td>
                    <td class="d-flex">
                        <a href="{{ route('productplus',$prod->id) }}" class="btn btn-success w-100"><i class="bi bi-plus"></i></a>
                        <form action="{{ route('product.destroy',$prod->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button  onclick="return confirmDelete();" class="btn btn-danger">O'chirish</button>
                        </form>
                    </td>
                </tr>
                <?php
                    $i =$i + 1;
                ?>
                @empty
                <h4>Tavar mavjud emas</h4>
                @endforelse
            </tbody>
        </table>
        <hr>
        <script>
            <script>
            function delet(){
                confirm("Haqiqatdan ham o'chirmoqchimisiz?")
            }
        </script>
        </script>

@endsection