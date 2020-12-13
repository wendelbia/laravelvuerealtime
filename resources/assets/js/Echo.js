//importo o store da pasta store
import store from './store/store'
//aqui mostro qual canal qro escutar
Echo.join('chat')
//usuer todos os usuários q estão nesse canal
        .here(users => {
        	//console.log('here')
        	//console.log(users)
        	//utilizo o mutation e passo o users q recebi como paramas de do nosso callback
            store.commit('LOAD_USERS', users)
        })
        //quem acabou de entrrar no nosso canal
        .joining(user => {
        	//console.log('joining')
        	//console.log(user)
            store.commit('JOINING_USER', user)
        })
        //quando o usu sai do chat
        .leaving(user => {
        	//console.log('living')
        	//console.log(user)
            store.commit('LEAVING_USER', user)
        })
        //
        .listen('Chat.MessageCreated', e => {
        	//console.log(e)
        	//uso o ADD_message
            store.commit('ADD_MESSAGE', e.message)
        })