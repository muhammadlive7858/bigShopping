@extends('admin.index')

@section('content')
<div class="d-flex justify-content-between align-center my-2">
    <h1 class="w-100">Qarz tarixi sahifasi</h1>
</div>
<table class="table table-bordered w-100">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th>To'lav</th>
                <th>Vaqti</th>
                <th></th>
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
                    <td>{{ $qarz->tolav }}</td>
                    <td>{{ $qarz->created_at }}</td>
                    <td>
                        <form action="{{ route('qarzhistory.destroy',$qarz->id) }}" method="post" class="d-flex align-center ">
                            @csrf
                            @method('delete')
                            <button class="btn-danger w-100 p-1 "style='border-radius:5px'  onclick="return confirmDelete();"><i class="bi bi-trash-fill " ></i></button>
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
        <script>
            function delet(){
                confirm('Haqiqatdan ham ochirmoqchimisiz?')
            }
            // $(document).ready(function() {}
        </script>
@endsection