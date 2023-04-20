@if (count($product) > 0)
<h3 class="bor" >bor</h3>
@else
<h3  class="yoq">yoq</h3>
@endif
salom
<style>
    .bor{
        background: red;
        color: white;
        width: 50px;
        border-radius: 10px;
        text-align: center;
    }
    .yoq{
        background: blue;
        color: white;
        width: 50px;
        border-radius: 10px;
        text-align: center;
    }
</style>