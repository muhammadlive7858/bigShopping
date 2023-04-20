@extends('admin.index')

@section('content')
<?php
    $oy = 1;
?>
        <div class="d-flex justify-content-between">
            <div class="w-100">
                @foreach($res as $result)
    
                    <table class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{$oy}}-oy</th>
                                <th scope="col">Jami savdo </th>
                                <th>Jami  foyda</th>
                                <th>Jami Qaytim</th>
                                <th>Jami Qaytgan tavar summasi</th>
                                <th style="width:15%">Chiqim</th>
                                <th>Oylik natija</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>{{ $result['savdo'] }}</td>
                                <td>{{ $result['foyda'] - $result['foyda_qaytuv'] }}</td>
                                <td>{{ $result['qaytim'] }}</td>
                                <td>{{ $result['qaytuv'] }}</td>
                                <td>{{ $result['chiqim'] }}</td>
                                <th>
                                    <a href="{{ route('days',$oy) }}" class="btn btn-primary">Ko'rish</a>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <?php  $oy++  ?>

        @endforeach
            </div>
        
        <hr>
        
        </div>
        <hr>
        <table class="table table-bordered w-100">
            <thead>
                <tr>
                    <th scope="col">Yillik</th>
                    <th scope="col">Jami savdo </th>
                    <th>Jami  foyda</th>
                    <th>Jami Qaytim</th>
                    <th>Jami qaytgan tavarlar</th>
                    <th>Yillik Chiqim</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $date }} - yil</td>
                    <td>{{ $jamiSavdo }}</td>
                    <td>{{ $jamiFoyda }}</td>
                    <td>{{ $jamiQaytim }}</td>
                    <td>{{ $JQT }}</td>
                    <td>{{ $yearchiqim }}</td>
                    <td><a href="{{route('yillik')}}" class="btn btn-success">Fayl orqali yuklash</a></td>
                </tr>
            </tbody>
        </table>

@endsection