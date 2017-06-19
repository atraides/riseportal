<template>
<div class='charContainer'>
    <div class="Characters" v-if="modal">
        <div class="Character" v-for="(character, index) in characters" :key="character.id" >
            <character :data="character" @main="changeMain(index)"></character>
        </div>        
    </div>
    <div :class="[{active: active},'characterSelectModal']" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true" @click="hide" v-else>
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
    <div class="animationload" v-show="loading">
        <div class="osahanloading"></div>
        <div class="loadingText">Kérlek várj...</div>
    </div>
</div>
</template>

<script>
    import Character from './Character.vue';
    export default {
        props: ['attributes'],

        components: { Character },

        created() {
            window.addEventListener('keydown', (e) => {
                if (this.active && e.keyCode == 27) {
                    this.hide();
                }
            });
            if (this.signedIn && !_.includes(location.pathname,'new')) {
                this.startLoading();
            }

            window.events.$on('openCharacterChanger', this.show );
            window.events.$on('updateCharacters', this.startLoading );
            window.events.$on('openLoadingScreen', this.showLoading );
            window.events.$on('closeLoadingScreen', this.hideLoading );
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
                modal: this.attributes.no_modal ? this.attributes.no_modal : false,
                listAll: false,
                buttonCss: ['btn', 'btn-primary'],
                buttonText: "Processing Order",
                active: false,
                main: null,
                signedIn: window.App.signedIn,
                loading: false
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
        },

        methods: {
            startLoading() {
                this.fetch();
            }, 

            show() {
                this.active = true;
            },

            hide() {
                this.active = false;
            },

            showLoading() {
                // this.loading = true;
            },

            hideLoading() {
                // this.loading = false;
            },

            fetch(page) {
                this.showLoading();
                axios.get(this.url(page))
                .then(this.refresh)
            },

            url(page) {
                return page ? page : '/character';
            },

            getAllCharacters() {
                this.listAll = true;
                this.fetch('/character/?showAll');
            },

            refresh({data}) {
                if (data.code && data.type) {
                    if (data.code == 403) {
                        if (_.includes(data.detail,'Account Inactive')) {
                            console.info(`Reuthentication required. Redirecting to '/oauth/battlenet?redirectBack=${location.pathname}'`);
                            window.location = `/oauth/battlenet?redirectBack=${location.pathname}`;
                        } else  if (_.includes(data.detail,'Not Authorized')) {
                            console.info('The user revoked our authorization. Logging out.');
                            window.location = '/logout';
                        } else { 
                            console.log(data);
                        }
                    }
                } else {
                    this.characters = _.orderBy(data, ['main','lastModified'], ['desc','desc']);    
                }
                this.hideLoading();
            },

            changeMain(index) {
                console.log(index);
                if ((index != null && index != undefined) && (index != 0 || this.characters[0].main === false )) {
                    var old_main = _.find(this.characters, function(o) { return o.main === true; })
                    
                    if (old_main) {
                        old_main.main = false;
                    }

                    this.characters[index].main = true;
                    this.characters = _.orderBy(this.characters, ['main','lastModified'], ['desc','desc']);

                    if (_.includes(location.pathname, 'new')) {
                        // this.showLoading();
                        this.loading = true;
                        window.location = '/home'; 
                    } else {
                        if (this.active) {
                            this.hide();
                        } else {
                            console.info('No Modal window to close');
                        }
                    }
                }
            }
        }
    }
</script>