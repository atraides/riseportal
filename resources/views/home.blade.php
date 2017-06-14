@extends('layouts.app')

@section('content')
<div class="container">
    <characters :attributes="{{ json_encode($attributes) }}"></characters>
</div>
@endsection
