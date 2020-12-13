<template>
  <div>
      <messages></messages>

      <textarea @keydown="keydownMessage" v-model="body" placeholder="Sua mensagem:"></textarea>
      <button :disabled="loading" @click.prevent="sendMessage" class="btn btn-success">
      	<!--posso passar diversas configs loading se é falso ou não, a cor, e tamanho e posso adicionar a class-->
        <pulse-loader
          :loading="loading"
          :color="'#FFF'"
          :size="'8px'"
          class="float-left">
        </pulse-loader>
        Enviar
      </button>
  </div>
</template>

<script>

import PulseLoader from 'vue-spinner/src/PulseLoader'

export default {
  data () {
    return {
      body: '',
      //para o spinner passo nosso vl para true pra dizer q etá carregando e no finally volto pra falso
      loading: false,
    }
  },
  methods: {
    //rebece um paras e que retorna vário informações q retonam o código da tecla
	keydownMessage (e) {
		//se a tecla apertarda for igual a 13 q é o enter então limpa o input
		//if (e.keyCode === 13) {
		//se a tecla enter e chift forem apertadas juntas então não via envia a mensagem
		if (e.keyCode === 13 && !e.shiftKey) {
			//co o preventDefault não passar para a linha de baixo mas sim enviar a mensagem
	        e.preventDefault()

	        this.sendMessage()
		}
    },
    sendMessage () {
    	//se body(conteúdo q a pessoa informou ) for vazio igual a trim, a pessoa ñ digitou nada ou também ñ enviará enquato estiver no loading
      if (!this.body || this.body.trim() == '' || this.loading)
          return
          this.loading = true
	      //alert('sendMessage')
			//chamo o nosso action para isso chamo o nosso dispatch q passa a action q quero utilizar e como params passo os dados que é a mensagem que vou enviar q é o proprio body através do data-bide, de modo que tudo que o usu digitar em v-model="body" reblica no body, assim pego esse valor no textearea, então envio o params body com this.body
			this.$store.dispatch('storeMessage', {body: this.body})
			//isso fará com q o texto q foi digitado antes fique vazio, aqui no axios temos o retorno then quando dá certo, o catch quando falha e também o finally q é finalizado
	                    .then(() => this.body = '')
	                    .finally(() => this.loading = false)
	    }
  },

  components: {
    PulseLoader
  }
}

</script>

<style scoped>
.float-left{float: left;}
textarea {
    width: 700px;
    border-radius: 5px;
    border: 1px solid #CCC;
    padding: 6px;
    max-width: 100%;
    float: left;
}
button {margin: 12px 6px;}
</style>




