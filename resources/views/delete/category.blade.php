@extends('admin.index')


@section('content')
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">nomi</th>
            <th>Malumoti</th>
            <th>Amalllar</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
        ?>
        @forelse($cats as $pro)
        <tr>

            <td>
                <?php
                 echo    $i;
                ?>
            </td>
            <td>{{$pro->name}}</td>
            <td>{{$pro->desc}}</td>
            <td class="d-flex ">
              <a href="{{route('catsrestore', $pro->id)}}" class="btn btn-primary">Tiklash</a>
              <form   action="{{ route('deletecate',$pro->id )}}" method="post">
                @csrf 
                @method('DELETE')
              <button class="btn btn-danger" onclick="return confirmDelete()"><i class="bi bi-trash"></i></button>
              </form>
            </td>
        </tr>
        <?php
            $i++;
        ?>
        @empty
        <tr>
            <td>O'chirilganlar yoq</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection