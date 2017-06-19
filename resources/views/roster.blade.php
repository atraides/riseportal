@extends('layouts.app')

@section('content')
<div class="container">
        <div class="col s12">
            @foreach($members as $member)
            <div class="row Characters">
                @foreach($member as $chardata)
                    <div xmlns="http://www.w3.org/1999/xhtml" class="col s3 Author-block">
                        <div class="Author {{ $chardata->rank ?: '' }}" id="">
                        <span class="Author-avatar ">
                            <img src="https://render-eu.worldofwarcraft.com/character/{{ $chardata->character->thumbnail }}" alt="" />
                        </span>

                            <div class="Author-details"> 
                                <span class="Author-name">{{ $chardata->character->name }}</span>
                                @if (isset($chardata->rank))
                                <span class="Author-job">{{ ucwords($chardata->rank) }}</span>
                                @else
                                    @if ( isset($chardata->character->guild))
                                    <span class="Author-guild">
                                    <a class="Author-guild--link" href="#">&lt;{{ $chardata->character->guild }}&gt;</a>
                                    </span>
                                    @endif
                                @endif
                                <span class="Author-class {{ snake_case( $chardata->character->class ) }}">
                                    {{ $chardata->character->level }} {{ $chardata->character->race }} {{ $chardata->character->class }}
                                </span>
                                <span class="Author-achievements">
                                <a href="https://worldofwarcraft.com/en-gb/chardata/arathor/{{ snake_case( $chardata->character->name ) }}/achievements" class="Author-achievements--link">
                                <i class="Icon"></i>{{ $chardata->character->achievementPoints }}
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
@endsection
