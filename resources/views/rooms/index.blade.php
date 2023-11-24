@extends('adminlte::page')

@section('title', 'All Rooms')

@section('content_header')
    <h1>All Rooms</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="errorBox"></div>
            <div class="col-3">
                <form method="POST" action="{{route('rooms.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h5>Add New</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="number" class="form-label">Number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="number" placeholder="Enter Room Number" value="{{old('number')}}">
                                @if($errors->has('number'))
                                    <span class="text-danger">{{$errors->first('number')}}</span>
                                @endif
                            </div>
                            <!-- Type Dropdown -->
                            <div class="form-group">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="type">
                                    <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="double" {{ old('type') == 'double' ? 'selected' : '' }}>Double</option>
                                    <option value="suite" {{ old('type') == 'suite' ? 'selected' : '' }}>Suite</option>
                                </select>
                                @if($errors->has('type'))
                                    <span class="text-danger">{{$errors->first('type')}}</span>
                                @endif
                            </div>
                            <!-- Status Dropdown -->
                            <div class="form-group">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status">
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                                </select>
                                @if($errors->has('status'))
                                    <span class="text-danger">{{$errors->first('status')}}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="price" class="form-label">Price / night</label>
                                <input type="decimal" class="form-control" name="price" placeholder="Enter Room Price Per Night" value="{{old('price')}}">
                                @if($errors->has('price'))
                                    <span class="text-danger">{{$errors->first('price')}}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" name="image" placeholder="Upload Room Image">
                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-9">
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
                ajax:"{{route('rooms.index')}}",
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
            $('body').on('click', '#btnDel', function(){
                var id = $(this).data('id');
                if(confirm('Delete room with ID '+id+'?')==true){
                    var route = "{{route('rooms.destroy', ':id')}}";
                    route = route.replace(':id', id);
                    $.ajax({
                        url:route,
                        type:"delete",
                        success:function(res){
                            $("#tblData").DataTable().ajax.reload();
                        },
                        error:function(res){
                            $('#errorBox').html('<div class="alert alert-dander">'+response.message+'</div>');
                        }
                    });
                }else{
                }
            });
        });
    </script>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
