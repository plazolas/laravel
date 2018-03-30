@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="col-md-6"><a href="{{ url("/tasks") }}">Tasks</a></div>
                    <div class="col-md-6">Edit Tasks</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
