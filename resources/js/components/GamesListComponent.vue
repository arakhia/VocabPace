<template>
    <div class="container">
        <h1><b>Live Competitions</b></h1>
        <br>
        <ol class="games">
            <new-game-card></new-game-card>
            <li class="game" v-for="(game, index) in games" :key="index">
                <router-link class="game_link" :to="`/game/${game.id}`" >
                    <div class="game_content game_content--lhs">
                        <h2 class="game_title">{{game.name}}</h2>
                        <div class="row game_players" style="display: flex; justify-content: space-between;">
                            <div v-if="game.users[0]" class="player-pane">
                                <img class="rounded-circle" :src="getUserAvatarByEmail(game.users[0].email)" height="50em" width="50em" alt="test image">
                                <span>{{game.users[0].username}}</span>
                            </div>
                            <div v-else class="player-pane"> </div>
                            <div class="player-pane">
                                <svg class="bi bi-lightning-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                                </svg>
                            </div>
                            <div v-if="game.users[1]" class="player-pane">
                                <img class="rounded-circle" :src="getUserAvatarByEmail(game.users[1].email)" height="50em" width="50em" alt="test image">
                                <span>{{game.users[1].username}}</span>
                            </div>
                            <div v-else class="player-pane"> </div>
                        </div>
                        <div class="game_footer">
                            <p>{{game.vocabulary_count}} Vocabulary</p><time>{{getRelativeTime(game.created_at)}}</time>
                        </div>
                    </div>
                    <div class="game_content game_content--rhs" aria-hidden="true">
                        <h2 class="game_title">{{game.name}}</h2>
                        <div class="row game_players" style="display: flex; justify-content: space-between;">
                            <div v-if="game.users[0]" class="player-pane">
                                <img class="rounded-circle" :src="getUserAvatarByEmail(game.users[0].email)" height="50em" width="50em" alt="test image">
                                <span>{{game.users[0].username}}</span>
                            </div>
                            <div v-else class="player-pane"> </div>
                            <div class="player-pane">
                                <svg class="bi bi-lightning-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                                </svg>
                            </div>
                            <div v-if="game.users[1]" class="player-pane">
                                <img class="rounded-circle" :src="getUserAvatarByEmail(game.users[1].email)" height="50em" width="50em" alt="test image">
                                <span>{{game.users[1].username}}</span>
                            </div>
                            <div v-else class="player-pane"> </div>
                        </div>
                        <div class="game_footer">
                            <p>{{game.vocabulary_count}} Vocabulary</p><time>{{getRelativeTime(game.created_at)}}</time>
                        </div>
                    </div>
                </router-link>
            </li>
        </ol>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                games: null,
            }
        },
        created: function() {
            this.getGamesList();
        },
        methods: {
            getGamesList: function()
            {
                axios.get('/api/games/list')
                .then(response => {
                    this.games = response.data.games
                });
            },
            getRelativeTime: function(datetime){
                return window.moment(datetime).fromNow();
            }
        }
    }
</script>
<style scoped>
.player-pane {
    margin-top: 1em;
    padding: 1em;
    display: flex;
    flex-direction: column;
    font-style: oblique;
    font-weight: bold;
}
.player-pane svg{
    margin-top: 1.5em;
}
</style>

