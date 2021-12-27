<template>
    <div >
        <v-toolbar>
            <v-toolbar-title class="px-4">SMS Sender Settings</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-container class="mt-4">
            <v-card no-gutter>
                <!-- <v-row>
                    <v-btn @click="send_sms" color="success ml-8 mt-5">
                        save
                    </v-btn>
                    <v-btn class="grey lighten-2 ml-10 mt-5">
                        export settings
                    </v-btn>
                </v-row> -->
                <div class="background_circle ml-5 mt-5 mr-5">
                    <v-icon small class="pt-1 pl-1 pb-1" color="primary">
                        mdi-alert-circle
                    </v-icon>
                    <span text-caption class="pt-1 pb-1 sms_text">
                        The SMS settings will notify you once your item is approved.
                    </span>
                </div>
                <div class="background_sms ml-5 mt-5 mr-5 pt-1 pl-2 pb-1">
                <h2 >SMS</h2>
                </div>
                <v-container  align=center>
                    <v-card class="mx-auto my-12" width=80% no-gutter position="center" elevation="0">
                        <v-card-title class="background_sms">Twilio Account Settings</v-card-title>
                           <v-simple-table class="flex" justify-center>
                                <tbody>
                                    <!-- <tr>
                                        <th> Twilio SMS Enabled</th>
                                        <td> 
                                            <v-select :items="items"></v-select>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <th> Twilio Phone Number</th>
                                        <td>+16203191424</td>
                                    </tr>
                                    <tr>
                                        <th> Twilio Account Sid</th>
                                        <td>xxxxxxxxxxxxxxxxxxxx</td>
                                    </tr>
                                    <tr>
                                        <th> Twilio Auth Token</th>
                                        <td>********************</td>
                                    </tr>
                                    <tr>
                                        <th> Twilio Country Code</th>
                                        <td>+63</td>
                                    </tr>
                                     <tr>
                                        <th>Test Twilio Settings</th>
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
                    Twilio SMS Testing
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-subheader class="px-0">Enter a number to Test</v-subheader>
                        <v-text-field
                            v-model="new_num"
                            prefix="+"
                            dense
                            filled
                            solo
                        >
                        </v-text-field>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        small
                        width="70px"
                        @click="send_sms_test"
                    >
                        Submit
                    </v-btn>
                    <v-btn
                        color="error"
                        small
                        width="70px"
                        @click="dialog= false"
                    >
                    <!-- @click.prevent= 'clearformData()' -->
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
            new_num:'',
            sms:'',
            // headers: [
            //     {text: , }
            // ]
            items:['No','Yes']
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
                axios.put('api/change_number/', payload, {} ).then((response)=>{
                    console.log(response.data);
                })
            }
        },
        test(){
            this.dialog = true
        },
        send_sms_test(){
            let payload = { new:this.new_num}
            axios.post('api/send_sms_test/', payload).then((response)=>{
                console.log(response)
            })
        }

        // get_number(){
        //     axios.get('api/get_number/').then((response)=>{
        //         this.sms = response.data
        //         console.log(this.sms, "sms owner")
        //     }).catch((errors)=>{
        //         console.log(errors)
        //     })
        // }
    },
    // mounted(){
    //     this.get_number()
    // }
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