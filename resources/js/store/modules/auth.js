import router from '../../routes'
export default {
    state:{
        authenticated:false,
        user:{}
    },
    mutations: {
        SET_AUTHENTICATED(state, payload) {
            state.authenticated = payload;
        },
        SET_USER(state, payload) {
            state.user = payload;
        },
    },
    actions:{
        login({commit}){
            return axios.get('/api/user').then(({data}) => {
          
                commit('SET_USER',data)
                commit('SET_AUTHENTICATED',true)
                router.push({ name:'dashboard' })

            }).catch(({res}) => {
                commit('SET_USER',{})
                commit('SET_AUTHENTICATED',false)
                router.push({ name:'login' })
            })
        },
        logout({commit}){
            commit('SET_USER',{})
            commit('SET_AUTHENTICATED',false)
            router.push({ name:'login' })
        }
    }
}