<template>
    <div  >
        <p v-bind:hidden="isWarningHidden">Warning: no link between protocol and center detected yet</p>
        <upload-component v-bind:upurl="upUrl" v-bind:downurl="downUrl" filetype="patient" header="patient" v-bind:ids="ids" v-bind:hidden="isHidden">
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
                isWarningHidden:true,
                isHidden:true,
                ids:{
                    protocolID: -1,
                    centerID: -1,
                    cidID: -1,
                    weekID: -1,
                }
            }
        },
        created() {
            eventHub.$on('proto-center-confirmed', this.fillIDAndShow)
            eventHub.$on('warn-center-protocol', this.updateIsWarningHidden)
        },

        beforeDestroy: function () {
            eventHub.$off('proto-center-confirmed', this.fillID)
            eventHub.$off('warn-center-protocol',this.updateIsWarningHidden)

        },
        methods:{
            fillIDAndShow($event){
                this.ids.protocolID=$event.protocolID
                this.ids.centerID=$event.centerID
                this.isHidden=false;
            },
            updateIsWarningHidden($event){
                this.isWarningHidden=$event;
            }
        }
    }
</script>

<style scoped>

</style>