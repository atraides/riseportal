<template>
<div id="loginDetails">
    <div :class="[{active: active},'modal-main']" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" @click="hide" aria-hidden="true">
        <div class="modal-inner" role="document"  @click.stop>
            <span class="title">Belépés</span>
            <div class='text-center'>
                <div class="message mx-15 p-4">Az általad kért oldal elérésehez be kell jelentkezned.<br/><br/> Ezt a lent talalhato <b>Battle.net</b> gombra kattintva tudod megtenni. Ha bõvebben érdekel miért változott meg a belépés menete akkor <a href="/battlenet">ITT</a> utána olvashatsz.
                <br/><br/>
                Köszonettel,<br/>
                Rise Legacy Officer Team
                </div>

                <div class="w-100 text-center">
                    <div class="p-1 mx-2 h-100 btn btn-primary btn-lg">
                        <a class="bi_battlenet" href="/oauth/battlenet">Battle.net</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['attributes'],

        created() {
        },

        data() {
            return {
                active: true
            }
        },

        methods: {
            hide() {
                this.active = false;
            },

            show() {
                this.active = true;
            }
        }
    }
</script>