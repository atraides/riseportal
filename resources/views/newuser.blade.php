@extends('layouts.app')

@section('content')
<div class="container">
	<userdetails :attributes="{{ $attributes }}"></userdetails>
</div>
@endsection
