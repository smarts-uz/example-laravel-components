<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel DataTables Editor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.4/css/select.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.4.0/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="/css/editor.dataTables.css">
    <link rel="stylesheet" href="/css/editor.bootstrap.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
@php
    $buttons = "[
                { extend: 'create', editor: editor },
                { extend: 'edit', editor: editor },
                { extend: 'remove', editor: editor }
            ]";
@endphp
        {{$dataTable->table(['id' => 'users'])}}
    {{--<x-SmartsTable tableId="dataTableBuilder" select="true" :options="['buttons' => $buttons]" getData="{{ route('report') }}" exportId="{{\App\Reports\One::class}}" startDate="{{request()->input('startDate')}}" endDate="{{request()->input('endDate')}}"></x-SmartsTable>--}}
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/searchbuilder/1.4.0/js/dataTables.searchBuilder.min.js"></script>
<script src="{{asset('js/dataTables.editor.js')}}"></script>
<script src="{{asset('js/editor.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.bootstrap.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    var editor = new $.fn.dataTable.Editor({
        ajax: {
            url: "/post",
            type: "POST",
        },
        buttons: [
            { extend: 'create', editor },
            { extend: 'edit', editor },
            { extend: 'remove', editor }
        ],
        table: "#users",
        display: "bootstrap",
        fields: [
            {label: "Name:", name: "name"},
            {label: "Email:", name: "email"},
        ]
    });

    $('#users').on('click', 'tbody td:not(:first-child)', function (e) {
        editor.inline(this);
    });
    {{$dataTable->generateScripts()}}
</script>
</body>
</html>