<template>
    <div >
        <v-toolbar>
            <v-toolbar-title class="px-4">{{$t('setting.sms.the_sms_sender_settings')}}SMS Sender Settings</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-container class="mt-4">
            <v-card no-gutter>
              
                <div class="background_circle ml-5 mt-5 mr-5">
                    <v-icon small class="pt-1 pl-1 pb-1" color="primary">
                        mdi-alert-circle
                    </v-icon>
                    <span text-caption class="pt-1 pb-1 sms_text">
                        {{$t('settings.sms.the_sms_settings')}}
                    </span>
                </div>
                <div class="background_sms ml-5 mt-5 mr-5 pt-1 pl-2 pb-1">
                <h2 >SMS</h2>
                </div>
                <v-container  align=center>
                    <v-card class="mx-auto my-12" width=80% no-gutter position="center" elevation="0">
                        <v-card-title class="background_sms">{{$t('settings.sms.twilio_account_settings')}}</v-card-title>
                           <v-simple-table class="flex" justify-center>
                                <tbody>
                                    <tr>
                                        <th>{{$t('settings.sms.twilio_sms_enabled')}}</th>
                                        <td> 
                                            <v-select @change="enable_disable" dense v-model="sms1" return-object
                                            :items="on_off">
                                            </v-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{$t('settings.sms.twilio_phone_number')}}</th>
                                        <td>+16203191424</td>
                                    </tr>
                                    <tr>
                                        <th>{{$t('settings.sms.twilio_account_sid')}}</th>
                                        <td>xxxxxxxxxxxxxxxxxxxx</td>
                                    </tr>
                                    <tr>
                                        <th>{{$t('settings.sms.twilio.twilio_auth_token')}}</th>
                                        <td>********************</td>
                                    </tr>
                                    <tr>
                                        <th>{{$t('setting.sms.twilio.country_code')}}</th>
                                        <td>
                                            <!-- :hint="`${select.nation}`" -->
                                            <v-select dense v-model="select" :items="country" item-text="nation" item-value="number"
                                                persistent-hint return-object prepend-icon="mdi-map">
                                            </v-select>    
                                        </td>
                                    </tr>
                                     <tr>
                                        <th>{{$t('settings.sms.test_twilio_settings')}}</th>
                                        <td><v-btn @click="test">Test</v-btn></td>
                                    </tr>
                                </tbody>
                           </v-simple-table>
                    </v-card>
                </v-container>
            </v-card>
        </v-container>

        <v-dialog v-model="dialog" persistent width="30%">
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    {{$t('settings.sms.twilio_sms_testing')}}
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-subheader class="px-0">Enter a number to Test</v-subheader>
                        <v-combobox
                        dense filled solo
                        :items="country_code"
                        item-text="code"
                        v-model="select2"
                        :hint="`${select2.nation}`"
                        item-value="nation"
                        return-object
                        outlined
                        :search-input.sync="new_num"
                        >
                        </v-combobox>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        small
                        width="70px"
                        @click="send_sms_test()"
                    >
                        Submit
                    </v-btn>
                    <v-btn
                        color="error"
                        small
                        width="70px"
                        @click="dialog= false"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>

export default {
    data(){
        return{
            dialog: false,
            select2:{code:'+33', nation:'France, +33'},
            new_num:'',
            sms1:'',
            sms:'',
            on_off:['Off','On'],
            on_off1:'',
            country:[
                {nation: 'France, +33', number:'+33', icon:'mdi-alert-circle'},
                {nation: 'Philippines, +63', number:'+63', icon:'mdi-alert-circle'},
            ],
            select: {nation:'France, +33', number:'+33', icon:'mdi-alert-circle'},
            country_code:[{ code:'+63', nation:'Philippines, +63'},{code:'+33', nation:'France, +33'}],
        }
    },
    methods:{
        send_sms(){
            if(this.new_num==''){
                return alert('Error!! Text Field is empty')
            }
            else{
                let payload = {
                    new: this.new_num
                }
                axios.put('api/change_number', payload, {} ).then((response)=>{
                    console.log(response.data);
                })
            }
        },
        test(){
            if(this.sms[0].switch==1){
                this.dialog = true
            }else{
                alert("Twilio is currently Disabled.")
            }
        },
        send_sms_test(){
                let payload = { new:this.new_num}
                axios.post('api/send_sms_test', payload).then((response)=>{
                    console.log(response)
                })
        },
        get_admin(){
            axios.get('api/get_admin').then((response)=>{
                this.sms = response.data
                console.log(this.sms, "sms owner")
                if(this.sms[0].switch==1){
                    this.sms1 = 'On'
                }else{
                    this.sms1 = 'Off'
                }
                console.log(this.sms1, "sms owner")
            }).catch((errors)=>{
                console.log(errors)
            })
        },
        enable_disable(){
            console.log(this.sms1 , "hey")
            if(this.sms1=='On'){
                alert("SMS Enabled")
                let payload= { switch:1 }
                axios.post('api/enable_disable', payload).then((response)=>{
                    console.log(response.data)
                })
            }else{
                alert("Twilio Disabled")
                let payload= { switch:0 }
                axios.post('api/enable_disable', payload).then((response)=>{
                    console.log(response.data)
                })
            }
            this.get_admin()
        }
    },
    mounted(){
        this.get_admin()
    }
}
</script>

<style>
.background_circle{
    background-color: rgb(169, 182, 197);
}
.background_sms{
    background-color: rgb(235, 232, 232);
}
.sms_text{
    font-size: small;
}
.sms_text2{
    font-size: small;
}
</style>