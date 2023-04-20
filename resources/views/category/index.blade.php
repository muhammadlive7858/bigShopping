@extends('admin.index')

@section('content')

    <h1>Hamma kategoriyalar sahifasi</h1>
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nomi</th>
                    <th scope="col" colspan="2">Malumoti</th>
                    <th scope="col" style="width:10% !important">Amallar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                ?>
                @foreach($cate as $cate)
                <tr>
                    <td scope="row">
                        <?php
                            echo $i;
                        ?>
                    </th>
                    <td class="d-flex"><a  class="mx-1 link-primary" href="{{route('category.show', $cate->id)}}"><i class="bi bi-folder-fill"></i>{{ $cate->name }}</a></td>
                    <td colspan="2">{{ $cate->desc }}</td>
                    <td  class="d-flex align-center justify-content-around">
                        <a href="{{ route('category.edit',$cate->id) }}" class="mt-2"><i class="bi bi-pencil btn-success w-100 p-2" style='border-radius:5px'></i></a>
                        <form action="{{ route('category.destroy',$cate->id) }}" method="post" class="d-flex align-center ">
                            @csrf
                            @method('delete')
                        <button  onclick="return deleteAlert();" class="btn-danger w-100 p-1 "style='border-radius:5px' ><i class="bi bi-trash-fill " ></i></button>
                        </form>
                    </td>
                </tr>
                <?php
                    $i++;
                ?>
                @endforeach
            </tbody>
        </table>

        <script>
            function deleteAlert(){
                let test = prompt('Parolni kiriting:');
                
            //     $(document).ready(function(){
            //         if(test == ""){
            //             return false;
            //         }else {
            //             $.get("{{ URL::to('getsetting') }}", function(data) {
            //                 console.log(data)
            //             })
            //         }
            // });
                
                if(test == "muzik"){
                    return confirmDelete();
                }
                return false;
            }
        </script>
@endsection
