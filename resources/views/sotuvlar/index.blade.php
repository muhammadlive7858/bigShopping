@extends('admin.index')

@section('content')
<h1 class="w-100">Hamma Sotuvlar sahifasi</h1>
<hr>
<form action="{{route('date')}}" method="post" class="form-control">
    @csrf
    <input type="date" class="form-control " name="date" style="margin-bottom:8px;"  >
    <button class="btn btn-primary" >vaqt bo'yicha</button>
</form>
    <h4><b>Sotuvlarning jami hisobi:</b></h4>
    @if(Auth::user()->role == 'adminner')
    <span> bu Sotuvlar ro'yxati</span>

    @else 
     <table  class="table table-bordered w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Jami sotuv summasi</th>
                    <th>Jami foyda</th>
                    <th>Jami qaytim puli</th>
                    <th>Jami naxt savdo</th>
                    <th>Jami Plastik savdo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>{{ $s }}</th>
                    <th id="th">{{$jamiSumma}}</th>
                    <th id="th">{{$jamiFoyda}}</th>
                    <th id="th">{{$jamiQaytim}}</th>
                    <th id="th">{{$jamiNaxt}}</th>
                    <th id="th">{{$jamiPlastik}}</th>
                </tr>
            </tbody>
        </table>
    @endif
   
<hr>
    <h4><b>Sotuvlarning ro'yxati</b></h4>
    <table class="table table-bordered w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tavar va soni </th>
                    <th>Savdo summasi</th>
                    <th>Foyda</th>
                    <th>Qaytim puli</th>
                    <th>Naxt</th>
                    <th>Plastik</th>
                    <th>Vaqti</th>
                    <th scope="col" style="width:15% !important">Amallar</th>
                </tr>
            </thead>
            <tbody>
                                <?php
                                    $n = 0;
                                    $s = 1;
                                ?>
                @foreach($sotuv as $prod)
                                
                <tr>
                    <td scope="row">{{ $s }}</td>
                        
                    <td>
                        <table>
                            
                            <tbody>
                                <tr>
                                    <?php 
                                        $i = 0;
                                        $ii = 1;
                                        foreach($res[$n] as $result){
                                            echo " <b>$ii)</b>";
                                            foreach($result as $key => $value){
                                                if($key == "name"){
                                                    echo "<span>$value||</span>";
                                                }
                                                if($key == "count"){
                                                    echo "<span class='text-primary'>$value ta</span>";
                                                }
                                                if($key == "price"){
                                                    echo "<span class='text-danger'> $value Sum|| </span>";
                                                }
                                                $i++;
                                                if(empty($result)){
                                                    break;
                                                }
                                            }
                                                $ii++;
                                            echo "<hr>";
                                        }
                                        $n++;
                                        $s++;
                                        
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                                            
                    <td class="bg-danger text-white">{{ $prod->savdo }}</td>
                       @if(Auth::user()->role == 'adminner')
                    <td  id="th">0</td>
                    @else 
                    <td  id="th">{{ $prod->foyda }}</td>
                    @endif
                    <td class="bg-success text-white">{{ $prod->skidka }}</td>
                    <td class="bg-danger text-white">{{ $prod->naxt }}</td>
                    <td class="bg-danger text-white">{{ $prod->plastik }}</td>
                    <td>{{ $prod->created_at }}</td>
                    <td  class="d-flex align-center justify-content-around">
                        <form action="{{route('tavar_pdf',$prod->id)}}" class="m-2">
                            <button href="" class="btn btn-primary"><i class="bi bi-file-pdf"></i></button>
                        </form>

                        <!--<a href="{{ route('sotuvedit',$prod->id) }}" class="btn btn-success m-2"><i class="bi bi-pencil btn-success w-100 p-2" style='border-radius:5px'></i></a>-->
                        <form action="{{ route('sotuvdestroy',$prod->id) }}" method="post" class="m-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"  onclick="return confirmDelete();" ><i class="bi bi-trash-fill " ></i></button>
                        </form>
                    </td>
                </tr>
                <?php
                    if(empty($res[$n])){
                        break;
                    }
                ?>
                @endforeach
            </tbody>
        </table>
        <style>
            #th{
                background: #111;
            }
            #th:hover{
                background:white;
            }
        </style>
@endsection