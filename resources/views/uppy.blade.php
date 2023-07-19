@extends('app')
@section('center_content')
    <div class="d-flex justify-content-center" id="file"></div>
    <x-SmartsUppy width="300" height="200" url="{{route('uploadImage')}}" target="#file" fieldName="file"></x-SmartsUppy>
@endsection
