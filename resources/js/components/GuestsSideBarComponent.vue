<template>
    <div class="guests-container">
        <div class="guests-list">
            <div  class="row guests-header">Guests</div>
            <div class="row list-group-item border-0 guest" v-for="(guest, index) in guests" :key="index">
                <img class="rounded-circle" src="https://www.gravatar.com/avatar/a3175a452c7a8fea80c62a198a40f6c9?s=180&d=monsterid&r=g" height="50em" width="50em" alt="test image">
                <span>{{guest.username}}</span>
            </div>
            <div>
                <b-modal id="guestLoginModal" title="Guests Login" ok-title="Join Now" no-close-on-backdrop no-close-on-etc ok-only hide-header-close @ok="handleOk" >
                    <form ref="form" @submit.stop.prevent="joinAsGuest">
                        <a v-if="gameStatus==1&&loggedIn" align="right" @click="joinAsPlayer"><p>Join as a Player</p></a>
                        <b-form-input 
                            id="guest-name"
                            v-model="form.guestName"
                            type="text"
                            placeholder="Username"
                            required>
                        </b-form-input>
                        <br>
                        <b-form-input 
                            id="guest-email"
                            v-model="form.guestEmail"
                            type="email"
                            placeholder="Email (Optional)">
                        </b-form-input>
                    </form>    
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                guests: null,
                gameStatus: null,
                loggedIn: (window.loggedIn),
                form: {
                    guestName: null,
                    guestEmail: null,
                },
            }
        },
        created() {
            this.getGuestsList();
        },
        mounted() {
            this.getGameStatus();
            this.$bvModal.show('guestLoginModal');

            window.Echo.channel('board-channel')
            .listen('UpdateBoardEvent', (event) => {
                if(event.data.guests){
                    this.guests = event.data.guests;
                }
            });
        },
        methods: {
            handleOk: function(bvModelEvent)
            {
                bvModelEvent.preventDefault();
                this.joinAsGuest()
            },
            getGuestsList: function()
            {
                axios.get('api/game/'+this.$route.params.id+'/guests')
                .then(response => {
                    this.guests = response.data.guests
                });
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
                .then(response => {
                    this.$bvModal.hide('guestLoginModal');
                    Cookies.set('guest', true, { expires: 1});
                });
            },
            getGameStatus: function()
            {
                axios.get('api/game/'+this.$route.params.id+'/status')
                .then(response => {
                    this.gameStatus = response.data.status
                });
            },
            joinAsPlayer: function()
            {
                axios.post('api/game/join', {
                    gameId: this.$route.params.id,
                    playerId: window.userId,
                })
                .then(response => {
                    this.$bvModal.hide('guestLoginModal');
                });
            }
        },
    }
</script>

<style scoped>
.guests-container {
    margin-top: 5%;
    
}
.guests-list {
    margin: auto;
    float: right;
    width: 10em;
}
.guest span {
    font-style: italic;
    padding: 0.5em;
}
.guests-header {
    background-color: #CFD8DC;
    padding: 1em;
    font-weight: bold;
}
</style>
