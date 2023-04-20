@extends('admin.index')

@section('content')
<h1 class="w-100">Hamma Sotuvlar sahifasi</h1>
<hr>
    <h4><b>Tavarlar jami hisobi:</b></h4>
    <table class="table table-bordered w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Jami sotuv summasi</th>
                    <th>Jami foyda</th>
                    <th>Jami qaytim puli</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Jami</th>
                    <th>{{$jamiSumma}}</th>
                    <th>{{$jamiFoyda}}</th>
                    <th>{{$jamiQaytim}}</th>
                </tr>
            </tbody>
        </table>
<hr>
    <h4><b>Tavarlarning ro'yxati</b></h4>
    <table class="table table-bordered w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tavar va soni </th>
                    <th>Savdo summasi</th>
                    <th>Foyda</th>
                    <th>Qaytim puli</th>
                    <th>Hodim</th>
                    <th>Vaqti</th>
                    <th scope="col" style="width:15% !important">Amallar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                ?>
                @foreach($sotuv as $prod)
                <tr>
                    <td scope="row">
                        <?php
                            echo $i;
                        ?>
                    </td>
                    <td>{{$prod->fullname}}</td>
                    <td class="bg-danger text-white">{{ $prod->savdo }}</td>
                    <td class="bg-primary text-white">{{ $prod->foyda }}</td>
                    <td class="bg-success text-white">{{ $prod->skidka }}</td>
                    <td>{{ App\Models\Hodimlar::find($prod->hodim_id)->name }}</td>
                    <td>{{ $prod->created_at }}</td>
                    <td  class="d-flex align-center justify-content-around">

                        <a href="{{ route('hodimSotuvlar.edit',$prod->id) }}" class="btn btn-success m-2"><i class="bi bi-pencil btn-success w-100 p-2" style='border-radius:5px'></i></a>
                        <form action="{{ route('hodimSotuvlar.destroy',$prod->id) }}" method="post" class="m-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"  onclick="return confirmDelete();"><i class="bi bi-trash-fill " ></i></button>
                        </form>
                    </td>
                </tr>
                <?php
                    $i++;
                ?>
                @endforeach
            </tbody>
        </table>
@endsection