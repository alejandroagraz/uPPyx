@extends('layouts.app')

@section('content')
<div class="col-md-8 col-md-offset-2">
    <ol class="breadcrumb">
        <li><a href="#">Bienvenido, {{Auth::user()->name}}!</a></li>
    </ol>

    @role(('super-admin'))
        <div class="chart-container">
            @include('layouts.dashboard.dashboard-admin')
        </div>
    @endrole

    @role(('rent-admin'))
        <div class="chart-container">
            @include('layouts.dashboard.dashboard-manager')
        </div>
    @endrole
            {{--@role(('user'))
            <p>Este mensaje solo lo ve un normal.</p>
            @endrole

            @role(('agent'))
            <p>Este mensaje solo lo ve un agent.</p>
            @endrole--}}
</div>
@endsection
