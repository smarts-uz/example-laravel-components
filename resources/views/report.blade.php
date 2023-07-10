@extends('app')
@section('center_content')
    <x-SmartsTable tableId="report" stateSave=true dom='QBlfrtip' getData="{{ route('report') }}" exportId="{{\App\Reports\One::class}}" startDate="{{request()->input('startDate')}}" endDate="{{request()->input('endDate')}}" language="ru"></x-SmartsTable>
@endsection
