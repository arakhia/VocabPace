<template>
    <div class="guests-container">
        <div class="guests-list">
            <div  class="row guests-header">Guests</div>
            <div class="row list-group-item border-0 guest">
                <img class="rounded-circle" src="https://www.gravatar.com/avatar/a3175a452c7a8fea80c62a198a40f6c9?s=180&d=monsterid&r=g" height="50em" width="50em" alt="test image">
                <span>User</span>
            </div>
            <div class="row list-group-item border-0 guest">
                <img class="rounded-circle" src="https://www.gravatar.com/avatar/a3175a452c7a8fea80c62a198a40f6c9?s=180&d=monsterid&r=g" height="50em" width="50em" alt="test image">
                <span>User</span>
            </div>
            <div class="row list-group-item border-0 guest">
                <img class="rounded-circle" src="https://www.gravatar.com/avatar/a3175a452c7a8fea80c62a198a40f6c9?s=180&d=monsterid&r=g" height="50em" width="50em" alt="test image">
                <span>User</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        created() {
            
        },
        methods: {

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
