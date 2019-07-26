<template>
    <div>
        <select data-placeholder="Choose the protocol(s) ..." v-on:change="$emit('update-protocol-id',selected)" v-model="selected" >
            <optgroup label="Longitudinal">
                <option v-bind:value="protocol.id" v-for="protocol in protocols" :key="protocol.id" v-if="protocol.type==='Longitudinal'">
                    {{ protocol.name }}
                </option>
            </optgroup>
            <optgroup label="Transversal">
                <option v-bind:value="protocol.id" v-for="protocol in protocols" :key="protocol.id" v-if="protocol.type==='Transversal'">
                    {{ protocol.name }}
                </option>
            </optgroup>
        </select>
        <p>select protocompo{{selected}}</p>
    </div>
</template>
<!--
<select data-placeholder="Choose the protocol(s) ..." class="chosen-tag" multiple="true" name="protocol[]">

    //Creation du groupe Longitudinal
    <optgroup label="Longitudinal">
        @foreach($protocols as $protocol)
        @if($protocol->Protocol_Type === "Longitudinal")
        <option value="{!! $protocol->Protocol_ID !!}">{!! $protocol->Protocol_Name !!}</option>
        @endif
        @endforeach
    </optgroup>

    //Creation du groupe Transversal
    <optgroup label="Transversal">
        @foreach($protocols as $protocol)
        @if($protocol->Protocol_Type === "Transversal")
        <option value="{!! $protocol->Protocol_ID !!}">{!! $protocol->Protocol_Name !!}</option>
        @endif
        @endforeach
    </optgroup>
</select>
-->
<script>
    import eventHub from '../app'
    export default {
        name: "selectProtocolComponent",
        data(){
            return {
                protocols: [
                    //{id: '', name: ''}
                ],
                selected:0

            }
        },
        mounted() {
            let that=this;
            axios.get(routeToProtocolsApi,{})
                .then(function(response){
                    Object.keys(response.data).forEach(key =>
                        that.protocols.push({
                            id:response.data[key].Protocol_ID,
                            name:response.data[key].Protocol_Name,
                            type:response.data[key].Protocol_Type
                        })
                    );


                })
        },
        methods:{
            emit(){

            }
        }

    }

</script>

<style scoped>

</style>