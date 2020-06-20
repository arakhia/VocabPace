<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" align="center">
                    <div  class="card-header" >Vocabulary Board</div>

                    <div class="card-body row" style="align-items: center; align-content: center;">
                        <div class="vocabulary-container" v-for="(vocab, index) in vocabulary" :key="index" >
                            <input class="vocabulary" type="text"  :value="vocab.value" :id="'voc'+index" v-on:click="typing(index)">
                            <progress class="m-progress" :id="index" :ref="index" value="0" max="4"> </progress>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                gameId: null,
                vocabulary: null,
                activeInput: null,
            }
        },
        created() {
            this.getVocabularyList();
        },
        mounted() {
            window.Echo.channel('board-channel')
            .listen('UpdateBoardEvent', (event) => {
                console.log(event);
            });
        },
        methods: {
            getVocabularyList: function(){
                axios.post('game/create', {count: "12"})
                .then(response => {
                    this.gameId = response.data.gameId,
                    this.vocabulary = response.data.vocabulary
                });
            },
            typing: function(index) {
                
                if(this.activeInput != null){
                    document.getElementById('voc'+this.activeInput).disabled = true;
                }
                this.activeInput = index;
                this.startProgressbar(index, 4);
            },
            startProgressbar: function(id, timer){
                
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
                var originalVocabulary = this.vocabulary[vocabularyIndex].value;
                if(originalVocabulary.localeCompare(answer, undefined, {sensitivity: 'accent'}) === 0){
                    //Correct
                } else {
                    //Incorrect
                    
                }
            },
            updateGame: function () {
                //update results
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
</style>
