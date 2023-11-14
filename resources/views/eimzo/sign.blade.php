@extends('adminlte::page')

@section('title', 'Example App')

@section('content_header')
@stop
@section('content')
<form name=testform>
    <label id="message"></label>
    Выберите ключ <br />
    <select name="key" onchange="cbChanged(this)"></select><br />
    Текст для подписи <br />
    <textarea class="form-control" name="data"></textarea><br />
    <button onclick="sign()" type="button">Подписать</button><br />
    ID ключа <label id="keyId"></label><br />
    Подписанный документ PKCS#7<br />
    <textarea class="form-control" name="pkcs7"></textarea><br />
</form>
@stop
@section('css')
    <script src="http://dls.yt.uz/e-imzo.js"></script>
    <script src="http://dls.yt.uz/e-imzo-client.js"></script>
@stop

@section('js')
    <script src="/eimzo.js"></script>
@stop
