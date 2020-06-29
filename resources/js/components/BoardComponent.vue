<template>
    <div class="row" style="width: 100%;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 board-container">
                    <div class="players-container">
                        <div class="player-pane">
                            <img class="rounded-circle" src="https://www.gravatar.com/avatar/a3175a452c7a8fea80c62a198a40f6c9?s=180&d=monsterid&r=g" height="50em" width="50em" alt="test image">
                            <span>User</span>
                        </div>
                        <div class="current-results">
                            <span v-if="results&&playerId" >{{results.filter(item=>item.player_id == playerId && item.status == 1).length}}</span>
                            <svg class="bi bi-lightning-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                            </svg>
                            <span v-if="results&&playerId" >{{results.filter(item=>item.player_id != playerId && item.status == 1).length}}</span>
                        </div>
                        <div class="player-pane">
                            <img class="rounded-circle" src="https://www.gravatar.com/avatar/a3175a4aaa7a8fea80c62a198a40f6c9?s=180&d=monsterid&r=g" height="50em" width="50em" alt="test image">
                            <span>Admin</span>
                        </div>
                    </div>
                    <div class="card" align="center">
                        <div  class="card-header" >Vocabulary Board</div>
                        <div class="card-body row" style="align-items: center; align-content: center;">
                            <div class="vocabulary-container" v-for="(vocab, index) in vocabulary" :key="index" >
                                <input class="vocabulary" type="text"  :value="vocab.value" :id="'voc'+vocab.id" v-on:click="typing(vocab.id)" :disabled="isDisabled(vocab.id)">
                                <progress class="m-progress" :id="vocab.id" :ref="index" value="0" max="4"> </progress>
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
                results: null,
                activeInput: null,
                available: true,
                playerId: window.userId,
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
            isDisabled: function(vocabulary_id){
                var player_id = this.results.find(item=>item.vocabulary_id === vocabulary_id).player_id;
                var answer = this.results.find(item=>item.vocabulary_id === vocabulary_id).answer;
                if(player_id == window.userId && answer != null){
                    return true;
                } else if(player_id != null && player_id != window.userId){
                    return true;
                }
                return false;
            },
            getVocabularyList: function(){
                axios.get('api/game/'+this.$route.params.id)
                .then(response => {
                    this.gameId = response.data.gameId,
                    this.vocabulary = response.data.vocabulary,
                    this.results = response.data.results
                });
            },
            typing: function(index) {
                this.updateGame(index);
                if(index == this.activeInput){
                    return;
                }
                if(this.activeInput != null){
                    this.isAnswerCorrect(index);
                    document.getElementById('voc'+index).disabled = true;
                }
                this.activeInput = index;
                this.startProgressbar(index, 4);
            },
            startProgressbar: function(id, timer)
            {    
                var self = this;
                document.getElementById('voc'+id).value = '';
                
                var runTimer = setInterval(function() {
                    document.getElementById(id).value = 4 - timer;
                    timer--;
                    if (timer < 0)
                    {
                        self.isAnswerCorrect(id);
                        document.getElementById('voc'+id).disabled = true;
                        self.activeInput = null;
                        clearInterval(runTimer);
                    }
                }, 1000);
            },
            isAnswerCorrect: function(vocabularyIndex)
            {
                var answer = document.getElementById('voc'+vocabularyIndex).value;
                var originalVocabulary = this.vocabulary.find(item=>item.id === vocabularyIndex).value;
                if(originalVocabulary.localeCompare(answer, undefined, {sensitivity: 'accent'}) === 0){
                    this.updateGame(vocabularyIndex, answer, 1);
                } else {
                    this.updateGame(vocabularyIndex, answer, 0);
                }
            },
            updateGame: function (vocabularyId, answer, status) 
            {
                //update results
                axios.post('api/game/update', {
                    gameId: this.gameId,
                    vocabularyId: vocabularyId,
                    playerId: window.userId,
                    answer: answer,
                    status: status,
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
                
                //console.log('SS ', this.form.guestName);
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
