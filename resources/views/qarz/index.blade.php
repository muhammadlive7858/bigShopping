@extends('admin.index')

@section('content')
@if(Session::has('error'))
<div class="alert alert-danger">
    {{Session::get('error')}}
</div>
<div class="d-flex justify-content-between align-center my-2">
    <h1 class="w-100">Qarz sahifasi</h1>


    @endif
    <form action="{{ route('qarzsearch') }}" method="post" class="form-control d-flex justify-content-between">
        @csrf
        <input type="text" name="search" class=" form-control" placeholder="Qarz qidiruvi" />
        <button class="btn btn-outline-primary">Qidirish</button>
    </form>
    <a href="{{ route('qarz.create') }}" class="btn btn-success">Yaratish</a>
</div>
<div class="row">
    <div class="col-3">

    </div>
    <div class="col-9">
        <table class="table table-bordered mx-auto ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nomi</th>
                    <th>Umumiy summa</th>
                    <th>Qoldiq summa</th>
                    <th>Malumoti</th>
                    <th>Telefon</th>
                    <th>Vaqt</th>
                    <th scope="col" style="width:10% !important">Amallar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                ?>
                @forelse($qarz as $qarz)
                <tr>
                    <td scope="row">
                        <?php
                            echo $i;
                        ?>
                    </th>
                    <td>{{ $qarz->name }}</td>
                    <td class="bg-primary text-white">
                        
                        <?php
                                    setlocale(LC_MONETARY,'en_US');
                                    $tolavSumma = money_format('%(#10n',$qarz->tolav_summa);
                                    $tolavSumma = explode(' ',$tolavSumma);
                                    echo end($tolavSumma);
                                ?>
                        </td>
                    <td class="bg-success text-white">
                        
                        <?php
                                    setlocale(LC_MONETARY,'en_US');
                                    $qarzi = money_format('%(#10n',$qarz->qarzi);
                                    $qarzi = explode(' ',$qarzi);
                                    echo end($qarzi);
                                ?>
                        </td>
                    <td>
                        @if(is_numeric($qarz->desc))
                        <a href="{{ route('debt-shop',$qarz->desc) }}">Malumot uchun bosing</a>
                        @else
                        <span>Ma'lumot mavjud emas</span>
                        @endif
                    </td>
                    <td class="bg-danger text-white">{{ $qarz->phone }}</td>
                    <td>{{ $qarz->vaqt }}</td>
                    <td class="d-flex align-center justify-content-around align-center">
                        @if($qarz->qarzi == 0 )
                        <a href="#" class="mt-2 btn btn-primary mx-1"><i class="bi bi-check"></i></a>
                        @else
                        <a href="{{ route('qarz.edit',$qarz->id) }}" class="mt-2 btn btn-primary mx-1">To'lash</a>
                        @endif
                        <a href="{{ route('qarz.show',$qarz->id) }}" class="btn btn-success mt-2 mx-1"><i class="bi bi-bag-fill"></i></a>
                        <form action="{{ route('qarz.destroy',$qarz->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger mt-2 mx-1"  onclick="return confirmDelete();"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php
                    $i++;
                ?>
                @empty
                <div class="d-flex justify-content-between align-center">
                    <h1>Hozircha qarzlar mavjud emas!</h1>
                </div>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection