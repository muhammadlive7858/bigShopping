@extends('admin.index')

@section('content')

<div class="d-flex justify-content-between" >
    <h4>Taminotchilar ro'yxati</h4>
    <a href="{{route('taminot.create')}}" class="btn btn-info text-white">Taminotchi qoshish</a>
   
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">ismi</th>
            <th scope="col">Firmasi</th>
            <th scope="col">O'chirish</th>

        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
        ?>
        @forelse($toms as $tom)
        <tr>
            <th scope="row">
                <?php
                    echo $i;
                ?>
            </th>
            <td>{{$tom->name}}</td>
            <td>{{$tom->firma}}</td>
            <td class="d-flex juctify-between align-center">   
                <a href="{{ route('taminot.show',$tom->id) }}" class="btn btn-success mt-2 mx-1"><i class="bi bi-bag-fill"></i> </a>
                <a href="{{ route('taminot.edit',$tom->id) }}" class="btn btn-primary mt-2 mx-1"><i class="bi bi-pencil"></i> </a>
                <form action="{{route('taminot.destroy', $tom->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button  onclick="return deleteAlert();" class="btn btn-danger mt-2 mx-1"><i class="bi bi-trash"></i> </button>
                </form>
            </td>
        </tr>
        <?php
            $i++;
        ?>
        @empty
        <tr>
            <td>Taminotchilar yoq</td>
        </tr>
        @endforelse
    </tbody>
</table>
<script>
    function deleteAlert(){
        let test = prompt('Parolni kiriting:');
        if(test == "muzik"){
            return confirmDelete();
        }
        return false;
    }
</script>




@endsection