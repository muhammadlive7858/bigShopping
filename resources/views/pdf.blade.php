
<div style="width:100%;height:100%;display:flex;flex-column:column;display-flex:between;align-items:center">
    <div style="height:15%">
        <h1>Muzaffar  Xos Tavar  do'kani</h1>
        <h5><span>Manzil</span> BERUNIY TUMANI ....</h5>
        <p >Do'kan egasi <b>Muzaffar</b></p>
        <hr>     
    </div>
    <div>
        <div class="divv" style="display:flex;justify-content:around;align-items:center;">

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nomi</th>
                <th>Hisobi</th>
                <th>Baxosi</th>
                <th>Soni</th>
            </tr>
        </thead>
        <tbody>
            {{$i = 1}}
            {{$n = 0}}
            @foreach($name as $names)
                <tr>
                    
                    <td>{{$i}}</td>
                        @foreach($names as $key => $value)
                            @if($key === "name")
                                <td>{{$value}}</td>
                            @endif
                            @if($key === "count")
                                <td>{{$value}}</td>
                                {{$n = $n + $value}}
                            @endif
                            @if($key === "price")
                                <td>{{$value}}</td>
                            @endif
                            @if($key === "hisobot")
                                <td>{{$value}}</td>
                            @endif
                        @endforeach
                        
                    </tr>
                      {{$i++}}
                    @endforeach
                    <tr>
                        <th></th>
                        <th>Jami hisobot</th>
                        <th>{{$s['savdo']}}so'm</th>
                        <th>{{$s['created_at']}}</th>
                        <th>{{ $n }}</th>
                    </tr>
        </tbody>
    </table>

    <!--<div class="left" style="width:50%; float:left;">-->
    <!--    <h3 style="padding:15px">Summa:</h3>-->
    <!--    <h3 style="padding:15px">Vaqti:</h3>-->
    <!--</div>-->
    <!--<div class="right" style="width:50%; float:right;">-->
    <!--    <h3 style="padding:15px">{{$s['savdo']}}so'm</h3>-->
    <!--    <h3 style="padding:15px">{{$s['created_at']}}</h3>-->
    <!--</div>-->
</div>
    </div>
    <div style="height:15%;bottom:0;margin-bottom:0;">
        <h3 style="text-align:center">Haridingiz Uchun Rahmat </h3>
        <div style="width:100%;margin:50px 0; display:flex;justify-content:around;align-items:center;">
            <h4 style="width:50% ;float:left">Tadbirkor:</h4>
            <h4 style="width:50%; float:right;display:flex;justify-content:between;">Muzaffar <span>+998997478083</span></h6>
        </div>
        <div style="width:100%;margin:50px 0; display:flex;justify-content:between;align-items:center;">
            <h4 style="width:80%;float:left">{{ $s->hodim }}</h4>
            <h4 style="width:50%;float:right;display:flex;justify-content:between;">Xizmat ko'rsatuvchi:</h6>
        </div>
    </div>
</div>









<style>
    h1 , p  ,h5 , h2{
        text-align: center;
    }
    b{
        font-size: 20px;
    }
    div{
        align-items: center
    }
    table{
        border-collapse: collapse;
        width: 100%;
    }
    thead,tbody,tr,td,th{
        border: 1px solid black;
    }
    .d-flex{
        display: flex;
    }
</style>