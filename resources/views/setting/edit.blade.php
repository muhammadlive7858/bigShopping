@extends('admin.index')

@section('content')
<div class="d-flex justify-content-between">
    <h2>Sozlamalar sahifasi</h2>
</div>

<hr>
<form class="form-control" action="{{ route('setting.update') }}" method="post">
    @csrf
    <h4 class="w-80 d-flex justify-content-between">Kam tavarlarni sanash miqdori:<input type="number" name="less_product" value="{{ $setting->less_product }}" required></h4>
    <h4 class="w-80 d-flex justify-content-between">Tavarlarni ko'rsatish miqdori:<input type="number" name="product_paginate_count" value="{{ $setting->product_paginate_count }}" required></h4>
    <!--<h4 class="w-80 d-flex justify-content-between">Menuning rangini:<span><div style="width:40px;height:20px;background-color:{{ $setting->menu_color }};border:1px solid"></div></span><input type="color"  name="menu_color" value="{{ $setting->menu_color }}"></h4>-->
    <!--<h4 class="w-80 d-flex justify-content-between">Tepa qismi rangini:<span><div style="width:40px;height:20px;background-color:{{ $setting->navbar_color }};border:1px solid"></div></span><input type="color"  name="navbar_color" value="{{ $setting->navbar_color }}"></h4>-->
    <h4 class="w-80 d-flex justify-content-between">O'chirish kodi:<input type="text" name="delete_password" value="{{ $setting->delete_password }}" required></h4>
    <button class="btn btn-primary">Saqlash</button>
</form>
@endsection