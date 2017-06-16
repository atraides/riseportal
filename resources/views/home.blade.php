@extends('layouts.app')

@section('content')
<div class="container">
    <characters :attributes="{{ $attributes }}"></characters>
</div>
@endsection
