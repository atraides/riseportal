<template>
    <div class="message mx-auto mb-3 text-center">
        Az egyes opciók részletes leírása <a :href="infoUrl">ITT!</a><br/>
        <div class="mt-2 text-success" v-if="(allowedPerc) >= 60">
            A szavazás érvényes.<br/>
            A szavazásra jogosult guildtagok {{ this.allowedPerc }}%-a szavazott.
        </div>
        <div class="mt-2 text-danger" v-else>
            Jelenleg a szavazás NEM érvényes.<br/>
            A szavazásra jogosult guildtagok csak {{ this.allowedPerc }}%-a szavazott.
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],

        created() {
            console.log(this.attributes);
        },

        data() {
            return {
            }
        },

        computed: {
            infoUrl: function() {
                if (this.attributes && this.attributes.moreInfoUrl) {
                    return this.attributes.moreInfoUrl;
                } else {
                    return '#!';
                }
            },

            allowedPerc: function() {
                if (this.attributes) {
                    return _.ceil((this.attributes.votesTotal / this.attributes.allowed)*100);
                } else {
                    return 0;
                }
            }
        }
    }
</script>