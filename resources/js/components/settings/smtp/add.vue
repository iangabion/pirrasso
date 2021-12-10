<template>
    <div class="container" style="width: 500px">
        <form>
            <v-text-field
              v-model="formData.mail_mailer"
              name= "MAIL_MAILER"
              ref="MAIL_MAILER"
              label="MAIL_MAILER"
              v-validate="'required'"
              :error-messages="errors.collect('MAIL_MAILER')"
              data-vv-name="MAIL_MAILER" 
            ></v-text-field>
            <v-text-field
              v-model="formData.mail_host"
              name="MAIL_HOST"   
              ref="MAIL_HOST"
              label="MAIL_HOST"
              v-validate="'required'"
              :error-messages="errors.collect('MAIL_HOST')"
              data-vv-name="MAIL_HOST"
            ></v-text-field>
            <v-text-field
              type="number"
              v-model="formData.mail_port"
              ref="MAIL_PORT"
              label="MAIL_PORT"
              v-validate="'required'"
              :error-messages="errors.collect('MAIL_PORT')"
              data-vv-name="MAIL_PORT"
            ></v-text-field>
            <v-text-field
              v-model="formData.mail_username"    
              label="MAIL_USERNAME"
              ref="MAIL_USERNAME"
              v-validate="'required'"
              :error-messages="errors.collect('MAIL_USERNAME')"
              data-vv-name="MAIL_USERNAME"
            ></v-text-field>
            <v-text-field
              v-model="formData.mail_password"   
              label="MAIL_PASSWORD"
              ref="MAIL_PASSWORD"
              v-validate="'required'"
              :error-messages="errors.collect('MAIL_PASSWORD')"
              data-vv-name="MAIL_PASSWORD"
            ></v-text-field>
            <v-text-field
              v-model="formData.mail_encryption"   
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
          mail_mailer: '',
          mail_host: '',
          mail_port: '',
          mail_username: '',
          mail_password: '',
          mail_encryption: '',
        },
      }
    },
    methods: {
      clearformData() {
          this.formData.mail_mailer ='',
          this.formData.mail_host= '',
          this.formData.mail_port= '',
          this.formData.mail_username= '',
          this.formData.mail_password= '',
          this.formData.mail_encryption= ''
          this.$validator.reset();
      },
      create() {
        this.$validator.validateAll().then(result => {
          if(result) {
            alert("sulod");
            axios.post('smtp/', this.formData).then((data)=> {
              console.log(data)
              this.clearformData()
            }).catch((error)=> {
              console.log(error)
            });
          }
        })
      }
    },
  }
</script>