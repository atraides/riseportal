<template>
<div id="RLPVote">
    <div :class="[{active: active},'modal-main']" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" @click="hide" aria-hidden="true">
        <div class="modal-inner" role="document"  @click.stop>
            <span class="title">{{ this.header }}</span>
            <transition name="slide-fade">
            <div class='text-center'>
                <div class="text-center message mx-15 p-4" v-html="message"></div>
                <votevalidity :attributes="validity"></votevalidity>

                <table class="message mx-auto w-75" v-for="(option, index) in options" :key="option.id" >
                    <tr>
                        <td class="text-left">{{ option.text }} ({{option.count}}):</td>
                        <td class="w-75 m-auto">
                            <div class="progress">
                                <div :class="['progressbar', option.color]" :style="progressStyle(option)" role="progressbar" :aria-valuenow="option.count" aria-valuemin="0" :aria-valuemax="votesTotal"></div>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="mx-auto w-75 mt-2" v-if="userRank <= 5">
                        <button :class="['mx-2','w-25','btn',option.color]" v-for="(option, index) in options" @click="postVote(option)">{{ option.text }}</button>
                </div>
            </div>
            </transition>

            <div class="carousel-control-prev" role="button" @click="prevSlide">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </div>
            <div class="carousel-control-next" role="button" @click="prevSlide">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import votevalidity from './VoteValidity.vue'; 
    export default {
        props: ['attributes'],

        components: { votevalidity },

        created() {
            window.addEventListener('keydown', (e) => {
                if (this.active && e.keyCode == 27) {
                    this.hide();
                }
            });

            window.events.$on('openRLPVoteWindow', this.show );
            window.events.$on('closeRLPVoteWindow', this.hide );

            if (this.signedIn) { 
                this.fetch();
            }
        },

        data() {
            return {
                signedIn: this.signedIn,
                validity: this.data,
                active: false,
                options: this.data,
                header: 'Header',
                message: '',
                voteId: 1,
                allowed: 0,
                userRank: this.user_rank
            }
        },

        computed: {
            votesTotal: function() {
                var count = 0;
                _.each(this.options, function(value) {
                    count += value.count;
                });
                return count;
            },

            allowedPerc: function() {
                return _.ceil((this.votesTotal / this.allowed)*100);
            },

            voteUrl: function() {
                return `/api/poll/${this.voteId}`;
            }
        },

        methods: {
            progressStyle(option) {
                var optionPercent = _.ceil((option.count / this.votesTotal) * 100);
                return `height: 4px; width: ${optionPercent}%;`;
            },

            postVote(option) {
                axios.post('/api/vote', {
                    'data': option
                })
                .then(this.fetch);
            },

            fetch() {
                axios.get(this.voteUrl)
                    .then(this.refresh);
            },

            prevSlide() {
                if (this.voteId == 1) {
                    this.voteId = 2;
                } else if (this.voteId == 2) {
                    this.voteId =1;
                }
                this.fetch();
            },

            refresh({data}) {
                this.options = data.data.options;
                this.allowed = data.data.allowedToVote;
                this.message = data.data.message;
                this.header = data.data.name;
                this.validity = {
                    'allowed': this.allowed,
                    'votesTotal': this.votesTotal,
                    'moreInfoUrl': data.data.infourl
                }
            },

            hide() {
                this.active = false;
            },

            show() {
                this.fetch();
                this.active = true;
            }
        }
    }
</script>