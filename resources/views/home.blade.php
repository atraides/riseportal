@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @foreach ( $characters as $character ) 
                @foreach(array_chunk($character, 3) as $chunk)
                    <div class="row">
                        @foreach($chunk as $chardata)
                            @if ($chardata->lastModified > 0) 
                            <div xmlns="http://www.w3.org/1999/xhtml" class="col s4 Author-block">
                                <div class="Author" id="">
                                    <a href="https://worldofwarcraft.com/en-gb/character/arathor/{{ snake_case( $chardata->name ) }}" class="Author-avatar "><img src="https://render-eu.worldofwarcraft.com/character/{{ $chardata->thumbnail }}" alt="" /></a>

                                    <div class="Author-details"> 
                                        <span class="Author-name">
                                            <a class="Author-name--profileLink" href="https://worldofwarcraft.com/en-gb/character/arathor/{{ snake_case( $chardata->name ) }}">{{ $chardata->name }}</a>
                                        </span>
                                        @if ( isset($chardata->guild))
                                        <span class="Author-guild">
                                            <a class="Author-guild--link" href="#">&lt;{{ $chardata->guild }}&gt;</a>
                                        </span>
                                        @endif
                                        <span class="Author-class {{ $chardata->cssClass }}">
                                            {{ $chardata->level }} {{ $chardata->race }} {{ $chardata->class }}
                                        </span>
                                        <span class="Author-achievements">
                                            <a href="https://worldofwarcraft.com/en-gb/character/arathor/{{ snake_case( $chardata->name ) }}/achievements" class="Author-achievements--link">
                                                <i class="Icon"></i>{{ $chardata->achievementPoints }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                            @endif
                        @endforeach
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection
