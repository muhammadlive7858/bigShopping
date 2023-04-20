@extends('admin.index')

@section('content')

    <h1>Tavarni tahrirlash</h1>
    <form action="{{ route('qaytuv.update',$product->id) }}" method="post" class="form-control d-flex flex-column " enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        
        <label class="d-flex justify-content-between m-2 p-2">
            <h4 class="w-50">Tavarning soni:</h4>
            <input value="{{ $product->count }}" type="float" name="count" id="" class="input-control  w-50" placeholder="Tavar miqdori:" required>
        </label>
        <button class="btn btn-primary m-2">Tahrirlash</button>
    </form>
@endsection