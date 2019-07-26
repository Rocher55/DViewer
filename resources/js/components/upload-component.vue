<template>
    <div >
        <table>
          <tr>
              <th>{{header}}</th>
          </tr>
          <tr>
              <td>
                  <form method="POST" v-bind:action="upurl" accept-charset="UTF-8" enctype="multipart/form-data">
                      <slot></slot>
                      <input name="csv" type="file">
                      <input name="filetype" type="hidden" v-bind:value="filetype">
                      <input name="ids" type="hidden" v-bind:value="JSON.stringify(ids)">
                      <input type="submit" value="upload">
                      {{ids}}
                  </form>
                  <a v-bind:href="downurl">Download template</a>
              </td>
           </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "upload-component",
        props:['header','upurl','downurl','filetype','ids'],
        data(){
            return{
                a:''
                /*
                header:'',
                upUrl:'',
                downUrl:''

                 */
            }
        }
    }
</script>

<style scoped>

</style>