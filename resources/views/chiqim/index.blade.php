

@extends('admin.index')

@section('content')
    <div class="d-flex justify-content-between my-2">
        <h2>Chiqim bo'limi</h2>
        <a href="{{ route('chiqim.create') }}" class="btn btn-outline-primary">Yaratish</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Malumoti</th>
                <th>Summa</th>
                <th>Vaqti</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
        ?>
            @forelse($chiqim as $chiqim)
                <tr>
                    <td>
                        <?php
                            echo $i;
                        ?>
                    </td>
                    <td>{{ $chiqim->desc }}</td>
                    <td>{{ $chiqim->summa }}</td>
                    <td>{{ $chiqim->created_at }}</td>
                    <td class="d-flex align-center justify-content-around">
                        <form action="{{ route('chiqim.destroy',$chiqim->id) }}" method="post" class="form-control">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100"><i class="bi bi-trash"  onclick="return confirmDelete()"></i></button>
                        </form>
                    </td>
                </tr>
                <?php
                    $i++;
                ?>
            @empty
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

