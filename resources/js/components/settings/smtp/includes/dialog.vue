<template>
<v-dialog
            v-model="dialog"
            persistent
            width="30%"
          >
           
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    SMTP {{$t('settings.smtp.credentials')}}
                </v-card-title>
              <v-form
                  ref="form"
                  v-model="valid"
                  lazy-validation
                  class="padding"
                >
                <v-flex xs12>
                     <v-subheader class="px-0">{{$t('settings.smtp.mail_mailer')}}</v-subheader>
                        <v-text-field
                        dense
                        filled
                        solo
                        v-model="formData.mail_mailer"
                        :rules="mailerRules"
              
                        required
                        ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-subheader class="px-0">{{$t('settings.smtp.mail_host')}}</v-subheader>
                        <v-text-field
                            dense
                            filled
                            solo
                            v-model="formData.mail_host"                  
                            :rules="hostRules"
             
                            required
                        ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-subheader class="px-0">{{$t('settings.smtp.mail_port')}}</v-subheader>

                        <v-text-field
                            dense
                            filled
                            solo
                            v-model="formData.mail_port"                  
                            :rules="portRules"
                            type="number"
                            required
                        ></v-text-field>
                </v-flex>

                <v-flex xs12>
                   <v-subheader class="px-0">{{$t('settings.smtp.mail_username')}}</v-subheader>
                        <v-text-field
                            dense
                            filled
                            solo
                            v-model="formData.mail_username"                  
                            :rules="usernameRules"
                   
                            required
                        ></v-text-field>
                </v-flex>
                 <v-flex xs12>
                    <v-subheader class="px-0">{{$t('settings.smtp.mail_password')}}</v-subheader>
                        <v-text-field
                            dense
                            filled
                            solo
                            v-model="formData.mail_password"                  
                            :rules="passwordRules"
                 
                            required
                        ></v-text-field>
                 </v-flex>

                 <v-flex xs12>
                    <v-subheader class="px-0">{{$t('settings.smtp.mail_encryption')}}</v-subheader>
                        <v-text-field
                            dense
                            filled
                            solo
                            v-model="formData.mail_encryption"                  
                            :rules="encryptionRules"
                    
                            required
                        ></v-text-field>
                 </v-flex>

                  
             <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        small
                        width="70px"
                        @click="create"
                    >
                        {{$t('send')}}
                    </v-btn>
                    <v-btn
                        color="error"
                        small
                        width="70px"
                        @click="$emit('close')"
                        @click.prevent= "clearformData"
                    >
                        {{$t('cancel')}}
                    </v-btn>
                </v-card-actions>

                
                </v-form>
            </v-card>
          </v-dialog>



</template>
<script>
import { ShowSmtp, UpdateSmtp, CreateSmtp } from "@api/smtp.api";


export default {
    data(){
        return {
             valid: true,
    
      mailerRules: [
        v => !!v || this.$t('settings.smtp.mail_mailer_is_required'),
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],

       hostRules: [
        v => !!v || this.$t('settings.smtp.mail_host_is_required'),
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],

       portRules: [
        v => !!v || this.$t('settings.smtp.mail_port_is_required'),
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
      
       usernameRules: [
        v => !!v || this.$t('settings.smtp.mail_username_is_required'),
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],

       passwordRules: [
        v => !!v || this.$t('settings.smtp.mail_password_is_required'),,
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],

       encryptionRules: [
        v => !!v || this.$t('settings.smtp.mail_encryption_is_required'),,
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
      
      
            formData:{
                id:'',
                mail_mailer:'',
                mail_host:'',
                mail_port:'',
                mail_username:'',
                mail_password:'',
                mail_encryption:'',
            }
        }
    },
    props: {
        dialog:{
            required: true,
            type: Boolean,
            default: false
        },
        id:{
            type:Number,
        }
    },
     watch:{
        id: function(val){
            if(val != 0){
                console.log(val, 'val')
                this.edit(val)
            }
        }
    },
    methods: {
          create() {

            let payload = this.formData
            if(!this.$refs.form.validate()) return;
           this.$root.$confirm(this.$t('settings.smtp.are_you_sure_you_want_to_save')).then((result) => {
                    if(result) {
                        let dis = this ;
                        let id = this.formData.id;
                        if(id != 0) {
                            UpdateSmtp(id, payload ).then(function (response) {
                            dis.clearformData()
                            dis.$emit('search')
                            dis.$emit('close')
                            dis.loading = false
                            alert('Successfully Updated');
                        })
                        }else{
                            CreateSmtp(payload).then((data)=> {
                                console.log(data)
                                this.clearformData()
                                this.$emit('search')
                                this.$emit('close')
                                this.loading = false
                                alert('Successfully Created');
                            }).catch((error)=> {
                                console.log(error)
                            });
                        }
                    }
                })
                
            },

        edit(id) {
            ShowSmtp(id, {}).then(response => {
                console.log(response.data, 'test')
                this.formData.id = response.data.id;
                this.formData.mail_mailer = response.data.mail_mailer;
                this.formData.mail_host= response.data.mail_host;
                this.formData.mail_port= response.data.mail_port;
                this.formData.mail_username= response.data.mail_username;
                this.formData.mail_password= response.data.mail_password;
                this.formData.mail_encryption= response.data.mail_encryption;
            });
        },

        clearformData() {
            this.formData.mail_mailer ='',
            this.formData.mail_host= '',
            this.formData.mail_port= '',
            this.formData.mail_username= '',
            this.formData.mail_password= '',
            this.formData.mail_encryption= '',
            this.formData.id= ''
            this.$refs.form.reset();

           
        },

        },
       

        
    
}
</script>
<style scoped>
.v-subheader{
    height: 30px !important;
    margin-bottom: 1px;
    margin-top: 14px;
    font-weight: bold;
    letter-spacing: 2px;
}
.padding {
    padding-left: 1em;
    padding-right: 1em;
}
</style>
