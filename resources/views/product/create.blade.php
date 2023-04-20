@extends('admin.index')

@section('content')
 
<h1>$ Dollor hisoblash</h1>
<hr>
<!--<div class="d-flex">-->
@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
@endif
<div class="d-flex justify-content-between w-100 flex-column"  style="">
            <form action="{{ route('dollorkurs') }}" method="post" class="w-100 d-flex ">
                @csrf
           
                <input type="text" name="dollor"  class="form-control m-2" placeholder="Tavarning $ dollor qiymati:" value="@if(isset($dollor)){{ $dollor }}@endif">
                <button class="btn-primary m-2">
                    Ko'rish
                </button>
            </form>
        <br>
        <div class="d-flex justify-content-between align-center w-100 pt-3">
                <h4>Tavarning sum qiymati:</h4>
            </div>
           <h4>
                        @if(isset($som))
              {{$som}}
              @endif
           </h4>
</div>
<!--<div>-->
    <hr>
    <h1>Tavarni Yaratish</h1>
<!--<button class="incr">+</button>-->
<!--<button class="decr">-</button>-->
    <form action="{{ route('product.store') }}" method="post" class="form-control d-flex flex-column " enctype="multipart/form-data">
        @csrf
                <label for="floatingInputInvalid">Tavar nomini kiriting:</label>
                  <input type="text" value="{{old('name')}}" id="productnamesearch"  name="name" class="form-control is-invalid" id="floatingInputInvalid" placeholder="Tavar Nomi" required >
                    @error('name')
               <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                 </span>
             @enderror
            <div id="memlist"></div>
           <div class="mt-2" id="res"></div>
<script type="text/javascript" >
$(document).ready(function(){
    $('#productnamesearch').keyup(function() {
        var search = $('#productnamesearch').val();
        if(search == ""){
            $('#memlist').html("");
            $('#res').hide();

        }else {
            $.get("{{ URL::to('productnamesearch') }}", {search:search}, function(data) {
                $('#memlist').empty().html(data);
                $('#res').show();
            })
        }
    });
});

</script>
         <label for="floatingInputInvalid">Tavar Kelish summa</label>
         @if(isset($som))
        <input type="float" name="price" class="form-control is-invalid" id="floatingInputInvalid" value="{{$som}}" placeholder="kelish summa:" >
        @else
         <input type="float" name="price" value="{{old('price')}}" class="form-control is-invalid" id="floatingInputInvalid"  placeholder="kelish summa:" >
                     @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @endif
          <label for="floatingInputInvalid">Tavarning Sotilish summasi kiriting:</label>
        <input type="number" value="{{old('shop_price')}}"  name="shop_price" class="form-control is-invalid numbercount " id="numbercount" placeholder="Sotilish summa:" >
                    @error('shop_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <select name="category_id" value="{{old('category_id')}}" id="" class="form-select form-select-lg mb-3 mt-3" style="width:99%" required>
            <option value="">Kategoriyani tanlang</option>
            @foreach($cate as $cate)
                <option value="{{$cate->id}}">{{ $cate->name }}</option>
            @endforeach
        </select>
                    @error('category_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <select name="taminotchi" id="" value="{{old('taminotchi')}}"   class="form-select form-select-lg mb-3" style="width:99%" required>
            <option >Taminotchini tanlang</option>
            @foreach($taminot as $taminot)
            <option value="{{$taminot->id}}">{{ $taminot->name }}</option>
            @endforeach
        </select>
                    @error('taminotchi')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
       
                      @if(isset($som))
                                  <label for="" class="d-flex justify-content-between m-2">
                <h4>Shaxsiy Qarz $ dollor orqali hisoblansinmi?</h4>
                <input type="checkbox" name="dollorHisob" id="" class="checkbox input-control mx-auto my-2 p-2">
                <h6 id="res" class="h6 d-flex">
                    
                <div id="diger">
                <span id="sp" style="--d: 0s"   >$</span>
                <span id="sp" style="--d: 4s" ><i class="bi bi-check2-all"></i></span>
                <span id="sp" style="--d: 8s" ><i class="bi bi-check2-circle"></i></span>
                </div>
                </h6>
                
                <style>
                #res {
                    margin-right:50px;
                }
#diger {
    margin-right:50px;
}

#sp {
    color:#fff;
    position: absolute;
    padding:10px;
    background: red;
    padding-inline: 10px;
    opacity: 0;
    transform-origin: 10% 75%;
    animation: words 12s var(--d) linear infinite;


}
@keyframes words {
    5% {
        opacity: 1;
    }
    10% ,
    20% {
        opacity: 1;
        transform: rotate(3deg);
    }
    15% {
        transform: rotate(-1deg);

    }
    25% {
        opacity: 0;
        transform: rotate(90px) rotate(10deg);
    }
}
                </style>
                
    
            </label>
              @endif
            <hr>
        <?php
        $time = time();
        echo '<input value="'.$time.'" type="hidden" name="producttime" class="input-control m-2 p-2" placeholder="Tavar uchun id raqam">' ;
        echo '<h4 class="m-2">Tavar ID raqami '.$time.'</h4>';
        ?>
        
          <label for="floatingInputInvalid">Tavar miqdori:</label>
        <input type="float" value="{{old('count')}}"  name="count" class="form-control is-invalid" id="floatingInputInvalid" placeholder="Tavar miqdori:" required >
                    @error('count')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <button class="btn btn-primary m-2">Yaratish</button>
               
    </form>


@endsection
