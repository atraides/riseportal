<template>
    <div :id="'character-'+id" :class="['Author', cssRank, { main: data.main }]" @click="setMain">
        <span class="Author-avatar ">
            <img :src="thumbnail" :alt="this.data.name" @error="imageLoadError"/>
        </span>

        <div class="Author-details">
            <span class="Author-name" v-text="data.name"></span>
            <span class="Author-job" v-if="data.rank <=10">{{ charRankName  }}</span>
            <span class="Author-guild" v-else-if="data.guild">&lt;{{ data.guild }}&gt;</span>
            <span class="Author-class" :class="cssClass">
                    {{ charLevel }} {{ charRace }} {{ charClass }}
            </span>
            <span class="Author-realm">{{ charRealm }}</span>  
        </div>
    </div> 
</template>

<script>
    export default {
    	props: ['data'],

        created() {
            if (this.data.main) {
                this.eventMain();
            }
        },

    	data() {
             return {
                id: this.data.id,
                charLevel: this.data.level,
                charRace: this.data.race_name,
                charClass: this.data.class_name
            };
        },

        computed: {
            thumbnail: function () {
                if (this.data.thumbnail) {
                    return `https://render-eu.worldofwarcraft.com/character/${this.data.thumbnail}?alt=/forums/static/images/avatars/wow/${this.data.class}-${this.data.gender}.jpg`
                }
            },

            charRankName: function () { 
                return this.data.rank_name ? _.startCase(this.data.rank_name) : null;
            },

            charRealm: function () {
                return this.data.realm ? _.toUpper(this.data.realm) : null;
            },

            cssRank: function () {
                return this.data.rank_name ? _.snakeCase(this.data.rank_name) : null;
            },

            cssClass: function () {
                return this.data.class_name ? _.snakeCase(this.data.class_name) : null;
            }
        },

        methods: {
        	setMain() {
        		axios.patch('/character/' + this.data.id + '/main', {
                    body: this.body
                });

                this.data.main = true;
                this.eventMain(this.data);
        	},

            imageLoadError() {
                console.log('Image failed to load for character ' + this.data.name);
            },

            eventMain(data) {
                this.$emit('main');
                window.events.$emit('main',data);
            } 
        }
    }
</script>