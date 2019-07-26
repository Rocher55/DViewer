<template>
    <div>
        <ul >
            <li v-for="gene in genes">
                {{ gene }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "Gene-List-Component",
        data(){
            return{
                genes:[1,2]
            }

        },
        mounted(){


            axios.get('api/ajax-genes',{'recherche':'a'})
                .then(response=>this.genes=response)
        }
    }
</script>

<style scoped>

</style>