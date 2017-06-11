@extends('layouts.app')

@section('content')
<div class="container">
        <div class="col s12">
            @foreach(array_chunk($characters, 4) as $character)
                <div class="row Characters">
                @foreach($character as $chardata)
                    <form id="changeMain-{{$chardata['id']}}" method="POST" action="{{ url('characters/'.$chardata['id'].'/main') }}" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    <div xmlns="http://www.w3.org/1999/xhtml" class="col s3 Author-block">
                        <div class="Author {{ $chardata['rank'] ? $chardata['rank_name'] : '' }} {{ $chardata['main'] ? 'main' : '' }}"  onclick="event.preventDefault();
            document.getElementById('changeMain-{{$chardata['id']}}').submit();" id="">
                        <span class="Author-avatar ">
                            <img src="https://render-eu.worldofwarcraft.com/character/{{ $chardata['thumbnail'] }}" alt="" />
                        </span>

                            <div class="Author-details"> 
                                <span class="Author-name">{{ $chardata['name'] }}</span>
                                @if (isset($chardata['rank']))
                                <span class="Author-job">{{ ucwords($chardata['rank_name']) }}</span>
                                @else
                                    @if ( isset($chardata['guild']))
                                    <span class="Author-guild">
                                    <a class="Author-guild--link" href="#">&lt;{{ $chardata['guild'] }}&gt;</a>
                                    </span>
                                    @endif
                                @endif
                                <span class="Author-class {{ snake_case( $chardata['class'] ) }}">
                                    {{ $chardata['level'] }} {{ $chardata['race'] }} {{ $chardata['class'] }}
                                </span>
{{--                                 <span class="Author-achievements">
                                <a href="https://worldofwarcraft.com/en-gb/chardata/arathor/{{ snake_case( $chardata['name'] ) }}/achievements" class="Author-achievements--link">
                                <i class="Icon"></i>{{ $chardata['achievementPoints'] }}
                                    </a>
                                </span> --}}
                            </div>
                        </div>
                    </div> 
                @endforeach
                </div>
            @endforeach
        </div>
</div>
@endsection
