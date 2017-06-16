<template>
    <div class="dropdown navbar-text my-auto characterMenu">
        <div class="dropdown-toggle p-1 mx-2 h-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <mainchar/>
        </div>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#" @click="changeChar">Main Karakter</a>
            <a class="dropdown-item" href="#" @click="logout">Kilepes</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" @click="deleteAccount">Account Torlese</a>
        </div>
    </div>
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
                window.events.$emit('openCharacterChanger',this.data.thumbnail);
            },

            logout() {
                window.location = '/logout';
            },

            deleteAccount() {
                axios.delete(`/user/${this.id}`, { data: this.data })
                .then(window.location = '/logout')
                .catch(function (error) {
                    if (error.response) {
                            // The request was made and the server responded with a status code
                            // that falls out of the range of 2xx
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                        console.log(error.config);
                    });
            }
        }
    }
</script>