//importaria o axios mas já é feito isso no bootstrap.js
export default {
//crio o state o estado 
    state: {
        //mensagens
        messages: [],
        //estados online
        users: [],
    },

    mutations: {
        
        LOAD_MESSAGES (state, messages) {
            //
            state.messages = messages
        },
//vincula a mensagem para o topo da lista
        ADD_MESSAGE (state, message) {
            state.messages.push(message)
        },

        LOAD_USERS (state, users) {
            state.users = users
        },
/**/
        JOINING_USER (state, user) {
            state.users.push(user)
        },

        LEAVING_USER (state, user) {
            //u é cada elemanto do nosso state users
            state.users = state.users.filter(u => {
                return u.id !== user.id
            })
        }
    },

    actions: {
        /*action para fazer o load das mensagens*/
        loadMessages (context) {
            //retorno o get q é o vergo e a url que qro requisitar
            return axios.get('/chat/messages')
            //se eu colocar .data traz os dados, armazeno isso no state mensage lá no state, mas não posso fazer isso pelo meu action, faço pelo mutations, pra ficar no histórico
                            //.then(response => console.log(response.data))
                            //pego o params context e no comit flo qual mutation qero chamr e passo o response q é o retorno da api .data
                           .then(response => context.commit('LOAD_MESSAGES', response.data))
        },

        storeMessage (context, params) {
            //vamos usar o axios para requisições ajax, uso o verbo de requisição post e a url de requisição /chat/message e o params, dou um return para analisar oq vai retornar  
            return axios.post('/chat/message', params)
                        .then(response => context.commit('ADD_MESSAGE', response.data))
                //para um retorno se foi salva a mensagem
                //.catch(() => console.log('error'))
            /*
            return axios.post('/chat/message', params)
                        .then(response => context.commit('ADD_MESSAGE', response.data))*/

                        // .catch(() => console.log('error'))
        },
    },
    
    getters: {
        /**/
        messages (state) {
            return _.orderBy(state.messages, 'id', 'asc')
        }
        
    }
    
}