<template>
<div id="userDetailsModal">
    <div :class="[{active: active},'modal-main']" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
        <div class="modal-inner" role="document"  @click.stop>
            <span class="title">Felhasználói adatok</span>
            <div class='text-center'>
                <div class="message mx-15 p-4">Most először jársz nálunk ezért egy pár adatot meg kell kérdezzünk. Kérlek töltsd ki az alábbi mezőket majd kattints a tovább gombra.<br/>
                <br/>
                Köszonettel,<br/>
                Rise Legacy Officer Team
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

                    <button type="submit" class="btn btn-primary w-75" :disabled="sendable ? 'disabled' : null" @click="submitUserData">{{ this.buttonText }}</button>
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
            window.events.$emit('openLoadingScreen');
            this.getInitialUserData();
        },

        data() {
            return {
                active: true,
                required: 'Ez a mező kötelező.',
                validEmail: 'Érvényes E-Mail címet kell megadni.',
                userAlreadyExists: 'Ez a felhasználónév már foglalt.',
                emailAlreadyExists: 'Ez az E-Mail cím már regisztrálva van.',
                user_id: this.attributes.user_id,
                username: '',
                email: '',
                userUniq: null,
                emailUniq: null,
                btnDisabled: false,
                buttonText: 'Küldés!'
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

            async getInitialUserData() {
                this.deactivateButton();
                this.buttonText = 'Karaktereid Letöltése...';
                axios.post(`/api/update/user/${this.user_id}/characters`)
                .then(response => {
                    if (response.status == 200) {
                        console.info('Update was succesfull.');
                        window.events.$emit('updateCharacters');
                        this.buttonText = 'Küldés!';
                        this.activateButton();
                    } else {
                        console.warn('Update failed.');
                        console.info(response);
                    }
                })
                .catch(e => {
                   console.error(e);
                })   
            }
        }
    }
</script>