<template>
    <div class="container" style="width: 500px">
      <form>
        <v-toolbar-title class="mdi mdi-account-plus">SMTP Setting</v-toolbar-title>
        <v-text-field
          v-model="formData.MAIL_MAILER"
          name= "MAIL_MAILER"
          ref="MAIL_MAILER"
          label="MAIL_MAILER"
          v-validate="'required'"
          :error-messages="errors.collect('MAIL_MAILER')"
          data-vv-name="MAIL_MAILER" 
        ></v-text-field>
        <v-text-field
          v-model="formData.MAIL_HOST"
          name="MAIL_HOST"   
          ref="MAIL_HOST"
          label="MAIL_HOST"
          v-validate="'required'"
          :error-messages="errors.collect('MAIL_HOST')"
          data-vv-name="MAIL_HOST"
        ></v-text-field>
        <v-text-field
          v-model="formData.MAIL_PORT"
          ref="MAIL_PORT"
          label="MAIL_PORT"
          v-validate="'required'"
          :error-messages="errors.collect('MAIL_PORT')"
          data-vv-name="MAIL_PORT"
        ></v-text-field>
        <v-text-field
          v-model="formData.MAIL_USERNAME"    
          label="MAIL_USERNAME"
          ref="MAIL_USERNAME"
          v-validate="'required'"
          :error-messages="errors.collect('MAIL_USERNAME')"
          data-vv-name="MAIL_USERNAME"
        ></v-text-field>
        <v-text-field
          v-model="formData.MAIL_PASSWORD"   
          label="MAIL_PASSWORD"
          ref="MAIL_PASSWORD"
          v-validate="'required'"
          :error-messages="errors.collect('MAIL_PASSWORD')"
          data-vv-name="MAIL_PASSWORD"
        ></v-text-field>
        <v-text-field
          v-model="formData.MAIL_ENCRYPTION"   
          label="MAIL_ENCRYPTION"
          ref="MAIL_ENCRYPTION"
          v-validate="'required'" 
          :error-messages="errors.collect('MAIL_ENCRYPTION')"
          data-vv-name="MAIL_ENCRYPTION"
        ></v-text-field>
        <v-btn
          class="mr-4"
          @click="create"
        >Submit</v-btn>
      </form>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        is_success: false,
        dialog_alert: false,
        dialog: false,
        formData: {
          MAIL_MAILER: '',
          MAIL_HOST: '',
          MAIL_PORT: '',
          MAIL_USERNAME: '',
          MAIL_PASSWORD: '',
          MAIL_ENCRYPTION: '',
        },
      }
    },
    watch: {
      'drawer'() {
        if(!this.drawer) {
          this.clearInput()
        }
      },
    },
    mounted(){ 
    },
    methods: {
      closeUsersCreate() {
        this.$store.commit('closeRightSidebar',false)
        this.$emit('closeUserRegister');
        this.clearInput()
      }
    },
  }
</script>
<style scoped>
  .formWrapper{
    padding: 1rem;
  }
  
  .ss{
  color: red;
  }
</style>