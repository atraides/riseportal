<character :attributes="{{ $character }}" inline-template>
<div xmlns="http://www.w3.org/1999/xhtml" class="col s3 Author-block" @click="setMain">
    @if ($character->lastModified > 0) 
    <div class="Author {{ snake_case($character->getRankName()) }}" v-bind:class="{ main: isMain }" id="">
        <span class="Author-avatar ">
            <img src="https://render-eu.worldofwarcraft.com/character/{{ $character->thumbnail }}" alt="" />
        </span>

        <div class="Author-details"> 
            <span class="Author-name">
                {{ $character->name }}
            </span>
            @if ( isset($character->rank) && $character->rank <= 10 )
            <span class="Author-guild">
                <span class="Author-job {{ snake_case($character->getRankName()) }}"> {{ ucwords($character->getRankName()) }}</span>
            </span>
            @elseif ( isset($character->guild) )
            <span class="Author-guild">
                &lt;{{ $character->guild }}&gt;
            </span>
            @endif
            <span class="Author-class {{ snake_case( $character->getClassName() ) }}">
                {{ $character->level }} {{ $character->getRaceName() }} {{ $character->getClassName() }}
            </span>
            <span xmlns="http://www.w3.org/1999/xhtml" class="Author-realm">
                {{ strtoupper($character->realm) }}
            </span>
        </div>
    </div> 
    @endif
</div>
</character>