<template>
    <div>
        <span class="postingAs" v-if="mainThumbnail">
            {{ this.data.name }}
            <img :src="mainThumbnail"/>
        </span>
        <span v-else>
            No Main Character
        </span> 
    </div>
</template>

<script>
    export default {
        created() {
            window.events.$on('main', this.setMain);
        },

    	data() {
            return {
                data: null
            };
        },

        computed: {
            mainThumbnail: function () {
                if (this.data) {
                        return `https://render-eu.worldofwarcraft.com/character/${this.data.thumbnail}?alt=/forums/static/images/avatars/wow/${this.data.class}-${this.data.gender}.jpg`
                } else {
                    return null;
                }
            },
        },

        methods: {
            setMain(data) {
                this.data = data;
            }
        }
    }
</script>