import Vue from 'vue'
import Vuex from 'vuex'
//importar o chat
import chat from './modules/chat'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        chat
    }
})
///exportar a variável store
export default store