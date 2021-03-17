<template>
    <v-container class="fill-height">
        <v-row align="center" justify="center">
          <v-col class="text-center">
            <v-icon size="140">mdi-send-lock</v-icon>
            <div class="display-4 text-uppercase font-weight-bold" color="blue-grey lighten-4">NO ITEMS FOUND</div>
            <div class="title">Opps! It seems you dont have any items yet.</div>
            <!-- <v-btn color="primary mt-10" rounded to="dashboard">get me out of here!</v-btn> -->
          </v-col>
        </v-row>
    </v-container>
</template>
<script>
  export default {
    data () {
      return {
        justify: 'center',
      }
    },
  }
</script>
