@extends('adminlte::page')
{{-- https://datatables.net/extensions/keytable/examples/initialisation/server-side.html --}}
@section('title', 'Example App')
@section('content_header')
@stop
@section('content')
    <x-SmartsTable tableId="report" keys="true" serverSide="true" getData="{{ route('report') }}" exportId="{{\App\Reports\One::class}}" startDate="{{request()->input('startDate')}}" endDate="{{request()->input('endDate')}}"></x-SmartsTable>
    <x-SmartsTable tableId="report1" keys="true" serverSide="true" getData="{{ route('report') }}" exportId="{{\App\Reports\One::class}}" startDate="{{request()->input('startDate')}}" endDate="{{request()->input('endDate')}}"></x-SmartsTable>
@stop
@section('css')
    @bukStyles(true)
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
@stop

@section('js')
    @bukScripts(true)
@stop
