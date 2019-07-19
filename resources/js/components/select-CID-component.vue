<template>
    <div>
        <select data-placeholder="Choose the CID) ..."  class="selectpicker">
            <option v-bind:value="cid.id" v-for="cid in cids" :key="cid.id">
                {{ cid.name}}
            </option>
        </select>
        <!--<multiselect v-model="value" track-by="id" label="city" :multiple="true" :options="options"></multiselect> -->
    </div>
</template>


<script>
    export default {
        name: "selectCidComponent",
        data(){
            return {
                cids: [
                    //{id: '', name: ''}
                ],
                value:''
            }
        },
        mounted() {
            let that=this;
            axios.get(routeToCidsApi,{})
                .then(function(response){

                    Object.keys(response.data).forEach(function(key) {

                        that.cids.push({
                            id: response.data[key].CID_ID,
                            name: response.data[key].CID_Name

                        })

                    });


                })
        }
    }

</script>



<style scoped>

</style>



