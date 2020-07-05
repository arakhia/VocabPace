<template>
    <div>
        <div>
            <li class="game" @click="createGame"> 
                <router-link class="game_link" to="" >
                    <div class="game_content game_content--lhs">
                        <h2 class="game_title">Create Your own</h2>
                        <div class="row game_players" style="display: flex; justify-content: space-between;">
                            <div v-if="user" class="player-pane">
                                <img class="rounded-circle" :src="getUserAvatarByEmail(user.email)" height="50em" width="50em" alt="test image">
                                <span>{{user.username}}</span>
                            </div>
                            <div class="player-pane">
                            
                            </div>
                            <div class="player-pane" algin="center">
                                <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-folder-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9.828 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H9.828zm-2.95-1.707L7.587 3H2.19c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293z"/>
                                    <path fill-rule="evenodd" d="M13.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                    <path fill-rule="evenodd" d="M13 12.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="game_content game_content--rhs" aria-hidden="true">
                        <h2 class="game_title">Create Your own</h2>
                        <div class="row game_players" style="display: flex; justify-content: space-between;">
                            <div class="player-pane">
                                <img class="rounded-circle" src="https://www.gravatar.com/avatar/a3175a452c7eefea80c62a198a40f6c9?s=180&d=monsterid&r=g" height="50em" width="50em" alt="test image">
                                <span>++1+</span>
                            </div>
                            <div class="player-pane">
                            
                            </div>
                            <div class="player-pane" algin="center">
                                <svg width="3em" height="3em"  viewBox="0 0 16 16" class="bi bi-folder-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9.828 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H9.828zm-2.95-1.707L7.587 3H2.19c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293z"/>
                                    <path fill-rule="evenodd" d="M13.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                    <path fill-rule="evenodd" d="M13 12.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </router-link>
            </li>
        </div>
        <div>
            <b-modal id="createGameModal" title="Create Competition" ok-title="Join Now" @ok="handleOk" >
                <form ref="form">
                    <b-form-input 
                        id="competition-name"
                        v-model="form.competitionName"
                        type="text"
                        placeholder="Competition Name"
                        required>
                    </b-form-input>
                    <br>
                    <b-form-input 
                        id="vocabulary-count"
                        v-model="form.vocabularyCount"
                        type="number"
                        max="30"
                        placeholder="Number of Vocabulary"
                        required>
                    </b-form-input>
                    <br>
                    <b-form-input 
                        id="vocabulary-timer"
                        v-model="form.vocabularyTimer"
                        type="number"
                        max="30"
                        placeholder="Vocabulary Timer"
                        required>
                    </b-form-input>
                </form>    
            </b-modal>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                competitionName: null,
                vocabularyCount: null,
                vocabularyTimer: null,
            },
            user: null,
        }
    },
    created() {
        this.getUserProfile();
    },
    methods: {
        createGame: function()
        {
            this.$bvModal.show('createGameModal');
            
        },
        handleOk: function(bvModelEvent)
        {
            bvModelEvent.preventDefault();
            this.CreateGame();
        },
        getUserProfile: function()
        {
            axios.get('api/profile')
            .then(response => {
                this.user = response.data.user
            });
        },
        CreateGame: function()
        {
            if(!this.$refs.form.checkValidity()){
                return;
            }
            
            axios.post('api/game/create', {
                competitionName: this.form.competitionName,
                vocabularyCount: this.form.vocabularyCount,
                vocabularyTimer: this.form.vocabularyTimer,
            })
            .then(response => {
                window.router.push({name: 'game', params: {id: response.data.gameId} });
            })
            .catch(function(error){
                console.log("ERROR  ", error);
            });
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
    margin-top: 1em;
    margin-right: 2em;
}
</style>