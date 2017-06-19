<template>
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-faded">
      <span class="navbar-brand" href="#">
        <img src="/storage/images/rise-text-small.png" height="40" class="d-inline-block align-middle" alt="">
      </span>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav my-auto mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item" v-if="signedIn">
            <a class="nav-link" href="#" @click="showRLPVote">RLP</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Disabled</a>
          </li>
        </ul>
        <!-- Authentication Links -->
        <usermenu v-if="signedIn"/>
        <div class="navbar-text my-auto characterMenu" v-else>
          <div class="p-1 mx-2 h-100">
              Login with: <a class="bi_battlenet" href="/oauth/battlenet">Battle.net</a>
          </div>
        </div>
      </div>
    </nav>
</template>

<script>
    import usermenu from './UserMenu.vue';
    import rlpvote from './RLPVote.vue';

    export default {
        props: ['data'],

        components: { usermenu, rlpvote },

        data() {
            return {
                signedIn: window.App.signedIn,
                id: window.App.user_id
            }
        },

        methods: {
            showRLPVote() {
                window.events.$emit('openRLPVoteWindow');
            }
        }
    }
</script>