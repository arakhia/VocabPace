<template>
    <div class="row" style="width: 100%;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 board-container">
                    <div v-if="players" class="players-container">
                        <div v-if="players[0]" class="player-pane">
                            <img class="rounded-circle" :src="getUserAvatarByEmail(players[0].email)" height="50em" width="50em" alt="test image">
                            <span>{{players[0].username}}</span>
                        </div>
                        <div v-else class="player-pane"> </div>
                        <div class="current-results">
                            <span v-if="results&&players[0]" >{{results.filter(item=>item.player_id == players[0].id && item.status == 1).length}}</span>
                            <svg class="bi bi-lightning-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                            </svg>
                            <span v-if="results&&players[1]" >{{results.filter(item=>item.player_id == players[1].id && item.status == 1).length}}</span>
                        </div>
                        <div v-if="players[1]" class="player-pane">
                            <img class="rounded-circle" :src="getUserAvatarByEmail(players[1].email)" height="50em" width="50em" alt="test image">
                            <span>{{players[1].username}}</span>
                        </div>
                        <div v-else class="player-pane"> </div>
                    </div>
                    <div class="card" align="center">
                        <div  class="card-header" >Vocabulary Board</div>
                        <div class="card-body row" style="align-items: center; align-content: center;">
                            <div class="vocabulary-container" v-for="(vocab, index) in vocabulary" :key="index" >
                                <input class="vocabulary" type="text"  :placeholder="vocab.value" :id="'voc'+vocab.id" v-on:click="typing(vocab.id)" :disabled="isDisabled(vocab.id)">
                                <progress class="m-progress" :id="vocab.id" :ref="index" value="0" :max="vocabulary_timer" > </progress>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <guests></guests>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                gameId: null,
                vocabulary: null,
                vocabulary_timer: 0,
                results: null,
                activeInput: null,
                available: true,
                playerId: window.userId,
                vocabulary_local_timer: 0,
                runTimer: null,
                players: null,
            }
        },
        created() {
            this.getVocabularyList();  
        },
        mounted() {
            window.Echo.channel('board-channel')
            .listen('UpdateBoardEvent', (event) => {
                if(event.data.results){
                    this.results = event.data.results;
                }
            });
        },
        methods: {
            isDisabled: function(vocabulary_id)
            {
                var player_id = this.results.find(item=>item.vocabulary_id === vocabulary_id).player_id;
                var answer = this.results.find(item=>item.vocabulary_id === vocabulary_id).answer;
                if(player_id == window.userId && answer != null){
                    return true;
                } else if(player_id != null && player_id != window.userId){
                    return true;
                }
                return false;
            },
            getVocabularyList: function()
            {
                axios.get('api/game/'+this.$route.params.id)
                .then(response => {
                    this.gameId = response.data.game.id,
                    this.vocabulary = response.data.vocabulary,
                    this.results = response.data.results,
                    this.vocabulary_timer = response.data.game.vocabulary_timer,
                    this.players = response.data.players
                });
            },
            typing: function(index) 
            {

                this.updateGame(index);
                if(index == this.activeInput){
                    return;
                }

                if(this.activeInput != null){
                    var finishedTime = (this.vocabulary_timer-this.vocabulary_local_timer);
                    this.isAnswerCorrect(this.activeInput, finishedTime);
                    document.getElementById('voc'+this.activeInput).disabled = true;
                    clearInterval(this.runTimer);
                }
                
                this.activeInput = index;
                this.startProgressbar(index, parseInt(this.vocabulary_timer));
            },
            startProgressbar: function(id, timer)
            {
                
                this.vocabulary_local_timer = timer;
                var self = this;
                document.getElementById('voc'+id).value = '';
                document.getElementById(id).max = timer;
                
                this.runTimer = setInterval(function() {
                    document.getElementById(id).value = parseInt(self.vocabulary_timer) - self.vocabulary_local_timer;
                    self.vocabulary_local_timer--;
                    if (self.vocabulary_local_timer < 0)
                    {
                        self.isAnswerCorrect(id, 10);
                        document.getElementById('voc'+id).disabled = true;
                        self.activeInput = null;
                        clearInterval(self.runTimer);
                    }
                }, 1000);
            },
            isAnswerCorrect: function(vocabularyIndex, finishedTime)
            {
                var answer = document.getElementById('voc'+vocabularyIndex).value;
                var originalVocabulary = this.vocabulary.find(item=>item.id === vocabularyIndex).value;
                if(originalVocabulary.localeCompare(answer, undefined, {sensitivity: 'accent'}) === 0){
                    this.updateGame(vocabularyIndex, answer, 1, finishedTime);
                } else {
                    this.updateGame(vocabularyIndex, answer, 0, finishedTime);
                }
            },
            updateGame: function (vocabularyId, answer, status, finishedTime) 
            {
                //update results
                axios.post('api/game/update', {
                    gameId: this.gameId,
                    vocabularyId: vocabularyId,
                    playerId: window.userId,
                    answer: answer,
                    status: status,
                    finishedTime: finishedTime,
                });
            },
            handleOk: function(bvModelEvent)
            {
                bvModelEvent.preventDefault();
                this.joinAsGuest()
            },
            joinAsGuest: function()
            {
                if(!this.$refs.form.checkValidity()){
                    return;
                }
                
                axios.post('api/game/guest/join', {
                    username: this.form.guestName,
                    email: this.form.guestEmail,
                    join_time: window.moment('YYYY-MM-DD HH:mm:ss').toDate().getTime(),
                    game_id: this.$route.params.id,
                })
                .catch(function(error){
                    console.log("ERROR  ", error);
                });
            }
        }
    }
</script>

<style scoped>
.title {
    align-self: center;
}
.vocabulary-container {
    margin: 0.5em;
    display: grid;
    
}
.vocabulary {
    text-align: center;
    font-style: italic;
    font-weight: bold;
    text-transform: uppercase;
}
.m-progress {
    height: 0.3em; 
    color: red;
}
.board-container {
    display: grid;
}
.players-container {
    display: flex; 
    justify-content: space-between;
}
.player-pane {
    margin-bottom: 0.5em;
    display: flex;
    flex-direction: column;
    text-align: center;
    font-style: oblique;
    font-weight: bold;
}
.current-results {
    font-weight: bold;
    font-size: 200%;
}
</style>
