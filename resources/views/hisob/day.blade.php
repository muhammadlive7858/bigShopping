@extends('admin.index')

@section('content')
<h1><b>{{ $n }}</b> - oy uchun hisobot </h1>
<hr>
<table class="table table-bordered">
    <thead>
        <tr >
            <th class="text-white bg-secondary">№</th>
            <th class="text-white bg-secondary">Savdo</th>
            <th class="text-white bg-secondary">Foyda</th>
            <th class="text-white bg-secondary">Qaytim</th>
            <th class="text-white bg-secondary">Chiqim</th>
            <th class="text-white bg-secondary">Qarz Savdo</th>
            <th class="text-white bg-secondary">To'langan Qarzlar</th>
            <th class="text-white bg-secondary">SHaxsiy qarz to'lavlari $</th>
            <th class="text-white bg-secondary">SHaxsiy qarz to'lavlari </th>
            <th class="text-white bg-secondary">Jami Qaytgan Tavarlar </th>
            <th class="text-white bg-secondary">Kirim</th>
        </tr>
        
    </thead>
    <tbody>
        <?php
            $jamiSavdo = 0;
            $jamiFoyda = 0;
            $jamiQaytim = 0;
            $jamiChiqim = 0;
            
            $jamiqarzSavdo = 0;
            $jamiqarzTolavlari = 0;
            $jamidollorTolavlari = 0;
            $jamisumTolavlari = 0;
            $JQT = 0;
        ?>
        @forelse($date as $day)
            <tr>
                <td class="bg-warning text-black fw-bold">{{ $day }}</td>
                <?php
                $savdo = 0;
                $foyda = 0;
                $qaytim = 0;
                    foreach($data['sotuvlar'][$day] as $sot){
                        $savdo =$savdo + intval($sot['savdo']);
                        $foyda =$foyda + intval($sot['foyda']);
                        $qaytim =$qaytim + intval($sot['skidka']);
                        
                        $jamiSavdo =$jamiSavdo + intval($sot['savdo']);
                        $jamiFoyda =$jamiFoyda + intval($sot['foyda']);
                        $jamiQaytim =$jamiQaytim + intval($sot['skidka']);
                    }
                    echo "<td class='bg-success text-white'>".$savdo."</td>";
                    echo "<td class='bg-success text-white'>".$foyda."</td>";
                    echo "<td class='bg-success text-white'>".$qaytim."</td>";
                    // chiqim
                    $chiqim = 0;
                    foreach($data['chiqim'][$day] as $chiqimsumma){
                        $chiqim =$chiqim + $chiqimsumma['summa'];
                        $jamiChiqim =$jamiChiqim + $chiqimsumma['summa'];
                    }
                        echo "<td class='bg-success text-white'>".$chiqim."</td>";
                    // qsavdo
                    $qarzsavdo = 0;
                    foreach($data['qarz'][$day] as $qarz){
                        $qarzsavdo =$qarzsavdo + $qarz['qarzi'];
                        $jamiqarzSavdo = $jamiqarzSavdo + $qarz['qarzi'];
                    }
                    echo "<td class='bg-success text-white'>".$qarzsavdo."</td>";
                    
                    $tolanganqarz = 0;
                    foreach($data['qarzhistory'][$day] as $qarzhistory){
                        $tolanganqarz =$tolanganqarz + $qarzhistory['tolav'];
                        $jamiqarzTolavlari = $jamiqarzTolavlari + $qarzhistory['tolav'];
                    }
                        echo "<td class='bg-success text-white'>".$tolanganqarz."</td>";
                    
                    $shtolanganqarz = 0;
                    $shtolanganqarzsom = 0;

                    foreach($data['shqarzhistory'][$day] as $shqarzhistory){
                        $shtolanganqarz =$shtolanganqarz + $shqarzhistory['dollor'];
                        $shtolanganqarzsom =$shtolanganqarzsom + $shqarzhistory['som'];
                        
                        $jamidollorTolavlari = $jamidollorTolavlari + $shqarzhistory['dollor'];
                        $jamisumTolavlari = $jamisumTolavlari + $shqarzhistory['som'];

                    }
                        echo "<td class='bg-success text-white'>".$shtolanganqarz."</td>";
                    
                        echo "<td class='bg-success text-white'>".$shtolanganqarzsom."</td>";
                    
                    $son = 0;
                    foreach($data['JQT'][$day] as $qaytip){
                        $son = ($qaytip['shop_price'] * $qaytip['count']);
                        $JQT = $JQT + $son;

                    }
                    echo "<td class='bg-success text-white'>".$son."</td>";
                ?>
                    <td>
                        <form action="{{ route('kirimHisobot') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $n }}" name="oy">
                            <input type="hidden" value="{{ $day }}" name="kun">
                            <button class="btn btn-secondary text-white">Kirim</button>
                        </form>
                    </td>
            </tr>
        @empty
        @endforelse
            <tr>
                <td class="bg-primary text-white">Jami:</td>
                <td class="bg-primary text-white">{{ $jamiSavdo }}</td>
                <td class="bg-primary text-white">{{ $jamiFoyda }}</td>
                <td class="bg-primary text-white">{{ $jamiQaytim }}</td>
                <td class="bg-primary text-white">{{ $jamiChiqim }}</td>
                <td class="bg-primary text-white">{{ $jamiqarzSavdo }}</td>
                <td class="bg-primary text-white">{{ $jamiqarzTolavlari }}</td>
                <td class="bg-primary text-white">{{ $jamidollorTolavlari }}</td>
                <td class="bg-primary text-white">{{ $jamisumTolavlari }}</td>
                <td class="bg-primary text-white">{{ $JQT }}</td>
            </tr>
    </tbody>
</table>

@endsection

