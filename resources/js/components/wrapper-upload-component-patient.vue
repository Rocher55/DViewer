<template>
    <div  >
        <upload-component v-bind:upurl="upUrl" v-bind:downurl="downUrl" filetype="patient" header="patient" v-bind:ids="ids">
            <slot></slot>
        </upload-component>
    </div>
</template>

<script>
    import uploadComponent from './upload-component'
    import eventHub from '../app'
    export default {
        components:{uploadComponent},
        name: "wrapper-upload-component-patient",
        props:['up-url','down-url'],
        data(){
            return {
                ids:{
                    protocolID: -1,
                    centerID: -1,
                    cidID: -1,
                    weekID: -1,
                }
            }
        },
        created() {
            eventHub.$on('proto-center-confirmed', this.fillID)
        },

        beforeDestroy: function () {
            eventHub.$off('proto-center-confirmed', this.fillID)

        },
        methods:{
            fillID($event){
                this.ids.protocolID=$event.protocolID
                this.ids.centerID=$event.centerID
            }
        }
    }
</script>

<style scoped>

</style>