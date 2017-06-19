@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <div class="text-center">
                        <a href="{{ url('/oauth/battlenet') }}" class="btn btn-primary">Register with Battle.net</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
