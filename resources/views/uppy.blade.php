@extends('app')
@section('center_content')
    <div id="file"></div>
    <x-laravelUppy width="300" height="200" url="{{route('uploadImage')}}" target="#file" fieldName="file"></x-laravelUppy>
@endsection
