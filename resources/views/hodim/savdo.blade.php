@extends('admin.index')

@section('content')
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:10%">#</th>
                    <th style="width:30%"">Hodim</th>
                    <th style="width:50%"">Malumot</th>
                    <th>Vaqti</th>
                    <th style="width:10%"">Amallar</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
            ?>
                @forelse($savdo as $savdo)
                    <tr>
                        <td>
                            <?php
                                echo $i;
                            ?>
                        </td>
                        <td>{{ App\Models\Hodimlar::findorfail($savdo->hodim_id)->name }}</td>
                        <td>{{ $savdo->desc }} </td>
                        <td class="w-25">{{ $savdo->created_at }}</td>                       
                        <td class="d-flex align-center justify-content-around">
                            <form action="{{ route('hodimsavdo.delte',$savdo->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
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
@endsection