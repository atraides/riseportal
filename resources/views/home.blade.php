@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @foreach(array_chunk($characters, 4) as $character)
                <div class="row">
                @foreach($character as $chardata)
                    <div xmlns="http://www.w3.org/1999/xhtml" class="col s3 Author-block">
                        @if (isset($chardata['rank']) && ($chardata['rank'] <= 6))
                           <div class="Author {{ $chardata['rank_name'] }}" id="">
                        @else
                            <div class="Author" id="">
                        @endif
                        <a href="https://worldofwarcraft.com/en-gb/character/arathor/{{ snake_case( $chardata['name'] ) }}" class="Author-avatar "><img src="https://render-eu.worldofwarcraft.com/character/{{ $chardata['thumbnail'] }}" alt="" /></a>

                            <div class="Author-details"> 
                                <span class="Author-name">
                                <a class="Author-name--profileLink" href="https://worldofwarcraft.com/en-gb/chardata/arathor/{{ snake_case( $chardata['name'] ) }}">{{ $chardata['name'] }}</a>
                                </span>
                                @if (isset($chardata['rank']) && ($chardata['rank'] <= 7))
                                <span class="Author-job">{{ ucwords($chardata['rank_name']) }}</span>
                                @endif
                                @if (isset($chardata['rank']) && ($chardata['rank'] >= 3))
                                    @if ( isset($chardata['guild']))
                                    <span class="Author-guild">
                                    <a class="Author-guild--link" href="#">&lt;{{ $chardata['guild'] }}&gt;</a>
                                    </span>
                                    @endif
                                    <span class="Author-class {{ snake_case( $chardata['class'] ) }}">
                                    {{ $chardata['level'] }} {{ $chardata['race'] }} {{ $chardata['class'] }}
                                    </span>
                                @endif
                                <span class="Author-achievements">
                                <a href="https://worldofwarcraft.com/en-gb/chardata/arathor/{{ snake_case( $chardata['name'] ) }}/achievements" class="Author-achievements--link">
                                <i class="Icon"></i>{{ $chardata['achievementPoints'] }}
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div> 
                @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
