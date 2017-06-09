@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                <ul>
                @foreach ( $characters as $character ) 
                    @foreach ( $character as $chardata )
                        <li class="{{ $chardata->class }}">@if ($chardata->lastModified > 0) 
                        <img src="https://render-eu.worldofwarcraft.com/character/{{ $chardata->thumbnail }}"/>
                        @endif
                        {{ $chardata->name }}-{{ $chardata->realm}} @ {{ $chardata->level }}</li>
                    @endforeach
                @endforeach
                </ul>
        </div>
    </div>
</div>
@endsection
