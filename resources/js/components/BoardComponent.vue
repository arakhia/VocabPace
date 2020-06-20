<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" align="center">
                    <div  class="card-header" >Vocabulary Game</div>

                    <div class="card-body row" style="align-items: center; align-content: center;">
                        <div class="vocabulary-container" v-for="(vocab, index) in vocabulary" :key="index" >
                            <input class="vocabulary" type="text"  :value="vocab.value" :id="'voc'+index" v-on:click="typing(index)">
                            <progress class="m-progress" :id="index" :ref="index" value="1" max="4"> </progress>
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
                vocabulary: [
                    {id: 1, value: 'play'},
                    {id: 2, value: 'match'},
                    {id: 3, value: 'computer'},
                    {id: 4, value: 'college'},
                    {id: 5, value: 'university'},
                ]
            }
        },
        mounted() {
            window.Echo.channel('board-channel')
            .listen('UpdateBoardEvent', (event) => {
                console.log(event);
            });
        },
        methods: {
            typing: function(index) {
                
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
