@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-hotel"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Rooms</span>
                    <span class="info-box-number">150</span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-bed"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Occupied Rooms</span>
                    <span class="info-box-number">75</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Reservations</h5>
                    <!-- Display upcoming reservations or a message if none -->
                    <p>No upcoming reservations.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning card-outline">
                <div class="card-body">
                    <h5 class="card-title">Revenue Overview</h5>
                    <!-- Display a simple chart or revenue information -->
                    <p>Total Revenue: $10,000</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    <h5 class="card-title">Housekeeping Status</h5>
                    <!-- Display housekeeping status or a message -->
                    <p>All rooms are clean and ready for check-in.</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Add additional CSS styles for your customizations -->
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }

        .content-wrapper {
            margin: 0; /* Remove default margin */
        }

        .row {
            margin: 0; /* Remove default margin for rows */
        }

        .info-box {
            color: #fff; /* Text color for info boxes */
        }

        .card-primary.card-outline .card-header,
        .card-success.card-outline .card-header,
        .card-warning.card-outline .card-header,
        .card-danger.card-outline .card-header {
            border-bottom: 0; /* Remove card header border */
        }

        .card {
            border: none; /* Remove card border */
            border-radius: 10px; /* Add border-radius for cards */
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
    <script></script>
@stop
