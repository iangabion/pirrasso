<template>
    <v-container class="fill-height">
        <v-row align="center" justify="center">
          <v-col class="text-center">
            <v-icon size="140">mdi-send-lock</v-icon>
            <div class="display-4 text-uppercase font-weight-bold" color="blue-grey lighten-4">{{ $t('error.error404.error404_not_found')}}404 NOT FOUND</div>
            <div class="title">{{ $t('error.error404.opps_we_cant_find_the_page_you_are_looking_for')}}.</div>
            <v-btn color="primary mt-10" rounded to="dashboard">{{ $t('error.error404.get_me_out_of_here')}}!</v-btn>
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