@extends('adminlte::page')

@section('title', 'Pending Status Rooms')

@section('content_header')
    <h1>Pending Rooms</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="errorBox"></div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>List</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--DataTable-->
                        <div class="table-responsive">
                            <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Number</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){
            var table = $('#tblData').DataTable({
                responsive:true, processing:true, serverSide:true, autoWidth:false,
                ajax:"{{route('pending-rooms.index')}}",
                columns:[
                    {data:'id', name:'id'},
                    {data:'number', name:'number'},
                    {data:'type', name:'type'},
                    {data:'status', name:'status'},
                    {data:'price', name:'price'},
                    {
                        data: 'image',
                        name: 'image',
                        render: function (data, type, full, meta) {
                            return '<img src="' + '{{ asset("/storage/") }}' + '/' + data + '" alt="Room Image" width="120">';
                        }
                    },
                    {data:'action', name:'action', bSortable:false, className:"text-center"},
                ],
                order:[[0, "desc"]]
            });

            $('body').on('click', '.btnConfirm', function(){
                var id = $(this).data('id');
                var route = "{{route('rooms.confirm', ':id')}}";
                route = route.replace(':id', id);
                $.ajax({
                    url: route,
                    type: "post",
                    success: function(res){
                        $("#tblData").DataTable().ajax.reload();
                    },
                    error: function(res){
                        $('#errorBox').html('<div class="alert alert-danger">'+response.message+'</div>');
                    }
                });
            });

            $('body').on('click', '.btnReject', function() {
                var id = $(this).data('id');
                var route = "{{route('rooms.reject', ':id')}}";
                route = route.replace(':id', id);
                $.ajax({
                    url: route,
                    type: "post",
                    success: function (res) {
                        $("#tblData").DataTable().ajax.reload();
                    },
                    error: function (res) {
                        $('#errorBox').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                });
            });
        });
    </script>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
