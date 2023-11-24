@extends('adminlte::page')

@section('title', 'All Users')

@section('content_header')
    <h1>All Users</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="errorBox"></div>
            <div class="col-3">
                <form method="POST" action="{{route('users.store')}}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h5>Add New</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Full Name" value="{{old('name')}}">
                                @if($errors->has('name'))
                                    <span class="text-danger">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Users Email" value="{{old('email')}}">
                                @if($errors->has('email'))
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Enter Users Password" value="{{old('password')}}">
                                @if($errors->has('password'))
                                    <span class="text-danger">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="roles" class="form-label">Roles <span class="text-danger">*</span></label>
                                <select class="form-control" name="roles">
                                    <option value="admin" {{ old('roles') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="employee" {{ old('roles') == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="guest" {{ old('roles') == 'guest' ? 'selected' : '' }}>Guest</option>
                                </select>
                                @if($errors->has('roles'))
                                    <span class="text-danger">{{$errors->first('roles')}}</span>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>password</th>
                                    <th>Roles</th>
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
                ajax:"{{route('users.index')}}",
                columns:[
                    {data:'id', name:'id'},
                    {data:'name', name:'name'},
                    {data:'email', name:'email'},
                    {data:'password', name:'password'},
                    {
                        data: 'roles',
                        name: 'roles',
                        render: function (data) {
                            return data.map(role => role.name).join(', ');
                        }
                    },
                    {data:'action', name:'action', bSortable:false, className:"text-center"},
                ],
                order:[[0, "desc"]]
            });
            $('body').on('click', '#btnDel', function(){
                var id = $(this).data('id');
                if(confirm('Delete user with ID '+id+'?')==true){
                    var route = "{{route('users.destroy', ':id')}}";
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
