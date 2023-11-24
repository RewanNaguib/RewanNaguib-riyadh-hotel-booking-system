@extends('adminlte::page')

@section('title', 'Edit Room')

@section('content_header')
    <h1>Edit Room</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="errorBox"></div>
            <div class="col-3">
                <form method="POST" action="{{route('rooms.update', $room->id)}}" enctype="multipart/form-data">
                    @method("patch")
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
                                <input type="number" class="form-control" name="number" placeholder="Enter Room Number" value="{{$room->number}}">
                                @if($errors->has('number'))
                                    <span class="text-danger">{{$errors->first('number')}}</span>
                                @endif
                            </div>
                            <!-- Type Dropdown -->
                            <div class="form-group">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="type">
                                    <option value="single" {{ $room->type == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="double" {{ $room->type == 'double' ? 'selected' : '' }}>Double</option>
                                    <option value="suite" {{ $room->type == 'suite' ? 'selected' : '' }}>Suite</option>
                                </select>
                                @if($errors->has('type'))
                                    <span class="text-danger">{{$errors->first('type')}}</span>
                                @endif
                            </div>
                            <!-- Status Dropdown -->
                            <div class="form-group">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status">
                                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="pending" {{ $room->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="booked" {{ $room->status == 'booked' ? 'selected' : '' }}>Booked</option>
                                </select>
                                @if($errors->has('status'))
                                    <span class="text-danger">{{$errors->first('status')}}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="price" class="form-label">Price / night</label>
                                <input type="decimal" class="form-control" name="price" placeholder="Enter Room Price Per Night" value="{{$room->price}}">
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
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
