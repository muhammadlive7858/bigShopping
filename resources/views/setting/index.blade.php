@extends('admin.index')

@section('content')
<div class="d-flex justify-content-between">
    <h2>Sozlamalar sahifasi</h2>
    <a href="{{ route('setting.edit') }}" class="btn btn-primary">Sozlash</a>
</div>

<hr>
<h4 class="w-80 d-flex justify-content-between">Kam tavarlarni sanash miqdori:<span>{{ $setting->less_product }}</span></h4>
<h4 class="w-80 d-flex justify-content-between">Tavarlarni ko'rsatish miqdori:<span>{{ $setting->product_paginate_count }}</span></h4>
<!--<h4 class="w-80 d-flex justify-content-between">Menuning rangini:<span><div style="width:40px;height:20px;background-color:{{ $setting->menu_color }};border:1px solid"></div></span></h4>-->
<!--<h4 class="w-80 d-flex justify-content-between">Tepa qismi rangini:<span><div style="width:40px;height:20px;background-color:{{ $setting->menu_color }};border:1px solid"></div></span></h4>-->
<h4 class="w-80 d-flex justify-content-between">O'chirish kodi:<span>{{ $setting->delete_password }}</span></h4>
@endsection