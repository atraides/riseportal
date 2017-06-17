<template>
<div id="userDetailsModal">
    <div :class="[{active: active},'modal-main']" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
        <div class="modal-inner" role="document"  @click.stop>
            <span class="title">Felhasználoi adatok</span>
            <div class='text-center'>
                <div class="message mx-15 p-4">Most elosszor jarsz nalunk ezert egy par adatot meg kell kerdezzunk. Kerlek toltsd ki az alabbi mezoket majd kattints a tovabb gombra.<br/>
                <br/>
                Koszonettel,<br/>
                Rise Legacy
                </div>

                <div class="mx-auto w-50 p-4">
                    <div class="form-group" :class="hasCss($v.username)">
                        <div class="input-group">
                            <div class="input-group-addon">#</div>
                            <input class="form-control" :class="formCss($v.username)" 
                                v-model.trim="username" @input="$v.username.$touch()" placeholder="Username">
                        </div>
                        <div class="form-control-feedback" v-if="!$v.username.required"><small>{{ required }}</small></div>
                        <div class="form-control-feedback" v-else-if="!$v.username.minLength"><small>{{ minLength($v.username) }}</small></div>
                        <div class="form-control-feedback" v-else-if="!$v.username.isUnique"><small>{{ userAlreadyExists }}</small></div>
                        <div class="form-control-feedback" v-else><small>&nbsp;</small></div>
                    </div>
                    <div class="form-group" v-bind:class="hasCss($v.email)">
                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            <input class="form-control" :class="formCss($v.email)" 
                                v-model.trim="email" @input="$v.email.$touch()" placeholder="xyz@gmail.com">
                        </div>
                        <div class="form-control-feedback" v-if="!$v.email.required"><small>{{ required }}</small></div>
                        <div class="form-control-feedback" v-else-if="!$v.email.email"><small>{{ validEmail }}</small></div>
                        <div class="form-control-feedback" v-else-if="!$v.email.isUnique"><small>{{ emailAlreadyExists }}</small></div>
                        <div class="form-control-feedback" v-else><small>&nbsp;</small></div>
                    </div>

                    <button type="submit" class="btn btn-primary" :disabled="sendable ? 'disabled' : null" @click="submitUserData">Kuldés</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import { required, minLength, between, email } from 'vuelidate/lib/validators'

    export default {
        props: ['attributes'],

        validations: {
            username: {
                required,
                minLength: minLength(4),
                async isUnique (value) {
                    if (value === '' || value.length < 4) return true;
                    axios.get(`/api/uniq/name/${value}`)
                    .then(response => {
                        if (response.status == 200) {
                            this.userUniq = Boolean(response.data.uniq);
                        }
                    })
                    return (this.userUniq);
                }
            },
            email: {
                required,
                email,
                minLength: minLength(4),
                async isUnique (value) {
                    if (value === '' || value.length < 4 || !this.$v.email.email) return true;
                    axios.get(`/api/uniq/email/${value}`)
                    .then(response => {
                        if (response.status == 200) {
                            this.emailUniq = Boolean(response.data.uniq);
                        }
                    })
                    return (this.emailUniq);
                }
            }
        },

        created() {
            // window.addEventListener('keydown', (e) => {
            //     if (this.active && e.keyCode == 27) {
            //         this.hide();
            //     }
            // });

            window.events.$on('openUserDetailsWindow', this.show );
        },

        data() {
            return {
                active: false,
                required: 'Ez a mezo kotelezo.',
                validEmail: 'Ervenyes E-Mail cimet kell megadni.',
                userAlreadyExists: 'Ez a felhasznalonev mar foglalt.',
                emailAlreadyExists: 'Ez az E-Mail cim mar regisztralva van.',
                username: '',
                btnDisabled: false,
                email: '',
                userUniq: null,
                emailUniq: null
            }
        },

        computed: {
            sendable: function () {
                if (this.btnDisabled || this.$v.username.$invalid || this.$v.email.$invalid) {
                    return true;
                } else {
                     return false;
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

            minLength(validation) {
                return `Minimum ${validation.$params.minLength.min} karakternek kell lenni.`;
            },

            formCss(validation) {
                if (validation.$error) {
                    return 'form-control-danger';
                } else if (validation.$invalid && !validation.$dirty) {
                    return 'form-control-warning';
                } else if (!validation.$invalid && !validation.$error && validation.$dirty) {
                    return 'form-control-success';
                }
            },

            hasCss(validation) {
                if (validation.$error) {
                    return 'has-danger';
                } else if (validation.$invalid && !validation.$dirty) {
                    return 'has-warning';
                } else if (!validation.$invalid && !validation.$error && validation.$dirty) {
                    return 'has-success';
                }
            },

            deactivateButton() { this.btnDisabled = true; },
            activateButton() { this.btnDisabled = false; },

            submitUserData() {
                this.deactivateButton();
                axios.patch('/user/' + this.attributes.user_id, {
                    name: this.username,
                    email: this.email
                })
                .then(response => {
                    this.activateButton();
                    this.hide();
                    window.events.$emit('openCharacterChanger');
                })
                .catch(e => {
                    console.error(e);
                })
            },
        }
    }
</script>