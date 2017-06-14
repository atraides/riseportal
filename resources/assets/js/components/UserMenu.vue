<template>
    <li class="dropdown">
        <a class="dropdown-toggle" href="#!" data-toggle="dropdown" role="button" aria-expanded="false">
            <mainchar/>
        </a>

        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="#" @click="changeChar">Main Karakter</a>
            </li>
        </ul>
    </li>
</template>

<script>
    import mainchar from './MainCharacter.vue';
    export default {
        props: ['data'],

        components: { mainchar },

        data() {
            return {
                id: this.data.id
            }
        },

        methods: {
            changeChar() {
                events.$emit('openCharacterChanger',this.data.thumbnail);
            }
        }
    }
</script>