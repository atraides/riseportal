<template>
    <div :class="[{active: active},'characterSelectModal']" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true" @click="hide">
        <div class="characterSelectInner" role="document"  @click.stop>
            <div class="text-center">
                <p class="Title">Válassz Main Karaktert</p>
            </div>
            <div class="Characters">
                <div class="Character" v-for="(character, index) in characters" :key="character.id" >
                  <character :data="character" @main="changeMain(index)"></character>
                </div>        
            </div>
            <div class="load-more" v-if="false === this.listAll">
                <a href='#!' class="thin" @click="getAllCharacters">Van Még...</a>
            </div>
        </div>
    </div>
</template>

<script>
    import Character from './Character.vue';
    export default {
        props: ['attributes'],

        components: { Character },

        created() {
            console.log(location.pathname);
            this.fetch();

            window.addEventListener('keydown', (e) => {
                if (this.active && e.keyCode == 27) {
                    this.hide();
                }
            });

            window.events.$on('openCharacterChanger', this.show);
        },

        ready: function() {
            document.addEventListener("keydown", (e) => {
                if (this.active && e.keyCode == 27) {
                    this.hide();
                }
            });
        },

        data() {
            return {
                characters: this.data,
                user_id: this.attributes.user_id,
                listAll: false,
                active: false,
                main: null
            }
        },

        computed: {
            modalCss: function() {
                if (this.active) {
                    return `characterSelectModal${this.active}`;
                } else {
                    return 'characterSelectModal';
                }
            },
            requestPage: function() {
                 if (!this.listAll) {
                    return `/user/${this.user_id}/characters`;
                } else {
                    return `/user/${this.user_id}/characters?showAll=1`;
                }
            }
        },

        methods: {
            show() {
                this.active = true;
            },

            hide() {
                this.active = false;
            },

            fetch(page) {
                axios.get(this.url(page)).then(this.refresh);
            },

            url(page) {
               return this.requestPage;
            },

            getAllCharacters() {
                this.listAll = true;
                this.fetch();
            },

            refresh({data}) {
                this.characters = _.orderBy(data, ['main','lastModified'], ['desc','desc']);
            },

            changeMain(index) {
                if (this.main != index) {
                    if (this.main !== null && this.main !== undefined)  {
                    this.characters[this.main].main = false;
                    }
                    this.main = index;
                    // this.characters = _.orderBy(this.characters, ['main','lastModified'], ['desc','desc']);
                    this.hide();
                }
            }
        }
    }
</script>