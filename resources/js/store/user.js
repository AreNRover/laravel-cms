import Vue from "vue";

const state = {
    users : []
}

const getters = {
    getUsers(state){
        return state.users ;
    }
}

const mutations  = {
    setUsers(state , users ){
        state.users = users
    }
}

const actions = {
    getUsersFromServer(context){
        Vue.http.get("api/user")
            .then( data => {
                context.commit("setUsers" , data );
            })
    }
}


export default {
    state,
    getters,
    mutations,
    actions
}
