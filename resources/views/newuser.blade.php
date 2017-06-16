@extends('layouts.app')

@section('content')
<div class="container">
	<userdetails :attributes="{{ $attributes }}"></userdetails>
    <characters :attributes="{{ $attributes }}"></characters>
</div>
@endsection
