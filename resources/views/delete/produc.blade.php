

@extends('admin.index')

@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th>Kodi</th>
      <th scope="col">Nomi</th>
      <th scope="col">Baxosi</th>
      <th scope="col">Kelish baxosi</th>
      <th>Amalllar</th>
    </tr>
  </thead>
  <tbody>
      <?php
            $i = 1;
        ?>
      @forelse($pro as $pro)
    <tr>
     
      <td>
          <?php
            echo $i;
        ?>
      </td>
      <td><b>{{ $pro->id }}</b></td>
      <td>{{$pro->name}}</td>
      <td>{{$pro->shop_price}}</td>
      <td>{{$pro->price}}</td>
      <td class="d-flex form-control">
          <a href="{{route('restore', $pro->id)}}" class="btn btn-primary mx-1"><i class="bi bi-arrow-clockwise"></i></a>
          <form   action="{{ route('del',$pro->id )}}" method="post">
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