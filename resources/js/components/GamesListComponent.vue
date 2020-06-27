<template>
    <div class="container">
        <h1><b>Live Competitions</b></h1>
        <ol class="games">
            <li class="game" v-for="(game, index) in games" :key="index"> 
                <a class="game_link">
                    <div class="game_content game_content--lhs">
                        <h2 class="game_title">Game</h2>
                        <div class="game_footer">
                            <p>{{game.vocabulary_count}} Vocabulary</p><time>{{getRelativeTime(game.created_at)}}</time>
                        </div>
                    </div>
                    <div class="game_content game_content--rhs" aria-hidden="true">
                        <h2 class="game_title">Game</h2>
                        <div class="game_footer">
                            <p>{{game.vocabulary_count}} Vocabulary</p><time>{{getRelativeTime(game.created_at)}}</time>
                        </div>
                    </div>
                </a>
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
            getGamesList: function(){
                axios.get('/json/games/list')
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

