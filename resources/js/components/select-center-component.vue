

<template>
    <div>
        <select data-placeholder="Choose the center ..."  class="selectpicker" v-model="selected" v-on:change="$emit('update-center-id',selected)">
            <option v-bind:value="center.id" v-for="center in centers" :key="center.id">
                {{ center.acronym.concat(' - ',center.city,' - ',center.country) }}
            </option>
        </select>
        <p> center id {{selected}}</p>
        <!--<multiselect v-model="value" track-by="id" label="city" :multiple="true" :options="options"></multiselect> -->
    </div>
</template>


<script>
    export default {
        name: "selectCenterComponent",
        data(){
            return {
                centers: [
                    //{id: '', name: ''}
                ],
                value:'',
                //options:[]
                selected:0
            }
        },
        mounted() {
            let that=this;
            axios.get(routeToCentersApi,{})
                .then(function(response){
                    console.log(response.data[1].Center_Acronym)
                    Object.keys(response.data).forEach(function(key) {

                        that.centers.push({
                            id: response.data[key].Center_ID,
                            acronym: response.data[key].Center_Acronym,
                            city: response.data[key].Center_City,
                            country: response.data[key].Center_Country
                        })
                       /* that.options.push({
                            id: response.data[key].Center_ID,
                            acronym: response.data[key].Center_Acronym,
                            city: response.data[key].Center_City,
                            country: response.data[key].Center_Country
                        })*/

                    });


                })
        }
    }

</script>

<style scoped>

</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>