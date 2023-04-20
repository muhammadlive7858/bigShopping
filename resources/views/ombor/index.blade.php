@extends('admin.index')

@section('content')
    
    <form action="{{ route('searchombor') }}" method="POST" class="form-control w-100" >
        @csrf
        @method('POST')
        <select name="category_id" id="" class="form-select m-2" style="width:99%">
            <option value="">Kategoriyani tanlang</option>
            @foreach($cate as $cate)
                <option value="{{$cate->id}}">{{ $cate->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-success mx-2" >Tanlang</button>
    </form> 
    
<!--<h1>Voice</h1>-->
<!--    <textarea name="" id="text" cols="30" rows="10"></textarea>-->
<!--    <button onclick="voice()">click</button>-->
<!--    <script>-->
<!--        function voice(){-->
<!--            var recognitio = new webkitSpeechRecognition();-->
<!--            recognitio.lang = "en-GB";-->
<!--            recognitio.onresult  = function(event){-->
<!--                console.log(event);-->
<!--                document.getElementById("text").value = event.results[0][0].transcript;-->
                
<!--            }-->
<!--            recognitio.start();-->
<!--        }-->
<!--    </script>-->
@endsection




