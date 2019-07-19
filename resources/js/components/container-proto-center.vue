<template>
    <div v-bind:hidden="isHidden">
        <proto v-on:update-protocol-id="protocolID=$event"></proto>
        <selectCenterComponent v-on:update-center-id="centerID=$event"></selectCenterComponent>
        <p>proto id{{protocolID}}</p>
        <p>centerID{{centerID}}</p>
        <button v-on:click="next">next</button>

    </div>
</template>

<script>

    import selectProtocolComponent from './select-protocol-component.vue'
    import selectCenterComponent from './select-center-component'
    import eventHub from '../app'

    export default {
        name: "containerProtoCenter",
        components:{proto:selectProtocolComponent,selectCenterComponent},
        data(){
            return{
                protocolID: 0,
                centerID: 0,
                isHidden:false
            }
        },
        mounted() {

        },
        methods:{
            next() {
                console.log('next pressed')
                let ids={
                    protocolID: this.protocolID,
                    centerID: this.centerID
                }

                eventHub.$emit('proto-center-confirmed',ids)

                //sert à vérifier s'il y existe deja une correspondance entre le protocole et le centre choisi.
                axios.get(routeToExistsApi,{params:{
                        protocolID: this.protocolID,
                        centerID: this.centerID
                    }})
                    .then(function(response){
                        console.log(response.data)
                        if(response.data.length===0){
            
                        }


                    })

            }


        },
        created() {
            eventHub.$on('update-protocol-id', this.testProtoID)
        },
// Il est bon de nettoyer les écouteurs d'évènements avant
// la destruction du composant.
        beforeDestroy: function () {
            eventHub.$off('update-protocol-id', this.testProtoID)

        },
    }
</script>

<style scoped>

</style>