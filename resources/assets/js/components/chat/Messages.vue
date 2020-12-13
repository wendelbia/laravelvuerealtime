<template>
  <div class="messages scroll" ref="messages">
      <scale-loader
          :loading="loading">
      </scale-loader>

      <message
          v-for="message in messages"
          :key="message.id"
          :message="message">
      </message>
  </div>
</template>

<script>
import ScaleLoader from 'vue-spinner/src/ScaleLoader.vue'

export default {

    created () {
      this.loadMessages()
    },
    
    data () {
      return {
        loading: false,
      }
    },

    computed: {
      messages () {
        return this.$store.state.chat.messages
        //return this.$store.getters.messages
      }
    },

    methods: {
      loadMessages () {
        this.loading = true

        this.$store.dispatch('loadMessages')
                    .finally(() => {
                      this.loading = false
                      
                      //poderia fazer com javascript
                      //document.getElementsByClassName()

                      //this e refs que é a referência q menssages e faço o que qero que é o scroll o primeiro params q é o zero é left zero o segundo é topo q é também referênciará a altura desse tag 
                      //this.$refs.messages.scrollTo(0, this.$refs.messages.scrollHeight)
                      this.scrollMessages()
                    })
      },
//método só para o scroll da mensagem
      scrollMessages () {
        //esse scrollHeight pega a altura antiga, para resolver isso usamos o setTimeout, que vai fazer funcionar em 100 milisegundos
        setTimeout(() => {
          //se eu usar o scrollTo posso fazer algumas configs com um efeito como o smooth q move de uma forma mais interesante
          // this.$refs.messages.scrollTo(0, this.$refs.messages.scrollHeight)
          this.$refs.messages.scroll({

            top: this.$refs.messages.scrollHeight,
            let: 0,
            behavior: 'smooth'
          })
        }, 100)
      }
    },
//vai ficar escutando a propriedade menssage, quan houve alteração no mensagem 
    watch: {
      messages () {
        this.scrollMessages()
      }
    },

    components: {
      ScaleLoader
    }
}
</script>

<style scoped>
.messages{
  height: 400px;
  max-height: 400px;
  overflow-x: hidden;
  overflow-y: auto;
}

</style>
