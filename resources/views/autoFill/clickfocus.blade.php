@extends('adminlte::page')

@section('title', 'Example App')
@section('content_header')
@stop
@section('content')
    <x-SmartsTable tableId="report"  :options="['autoFill' => 'true']" dom='QBlfrtip' getData="{{ route('report') }}" exportId="{{\App\Reports\One::class}}" startDate="{{request()->input('startDate')}}" endDate="{{request()->input('endDate')}}"></x-SmartsTable>
@stop
@section('css')
    <link css="https://cdn.datatables.net/autofill/2.6.0/css/autoFill.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    @bukStyles(true)
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/autofill/2.6.0/js/dataTables.autoFill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/DataTables/Plugins@1.10.19/sorting/datetime-moment.js"></script>
@stop
