<template>
    <!-- <div class= "text-center"> -->
    <div >
        <v-toolbar>
            <v-toolbar-title class="px-4">SMS Sender Settings</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-container>
            <v-card no-gutter>
                <v-row>
                    <v-btn @click="send_sms" color="success ml-8 mt-5">
                        save
                    </v-btn>
                    <v-btn class="grey lighten-2 ml-10 mt-5">
                        export settings
                    </v-btn>
                </v-row>
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
                            <v-row class="ml-5" no-gutters>
                                <!-- <v-col cols="12"> -->
                                    <v-col cols=6>
                                        <h5>Input your new number:</h5>
                                    </v-col>
                                    <v-col cols=6 >
                                        <v-text-field label="+09112211221" solo
                                        >
                                            <v-tooltip slot="append" bottom color="primary">
                                                <template v-slot:activator="{on}">
                                                    <v-icon slot="activator" v-on="on" color="primary" dark>mdi-help-circle-outline</v-icon>
                                                </template>
                                                    <h6>Input your new number, then click save.</h6>
                                            </v-tooltip>
                                        </v-text-field>
                                    </v-col>
                                <!-- </v-col> -->
                            </v-row>
                            <v-row class="ml-5" no no-gutters>
                                <v-col cols=6>
                                    <h5>Your number:</h5>
                                </v-col>
                                <v-col cols=6>
                                    <v-text-field readonly solo
                                        
                                    >
                                        <v-tooltip slot="append" bottom >
                                                <template v-slot:activator="{on}">
                                                    <v-icon slot="activator" v-on="on" color="primary" dark>mdi-help-circle-outline</v-icon>
                                                </template>
                                                    <h6>This is your current number.</h6>
                                        </v-tooltip>
                                    </v-text-field>
                                </v-col>
                            </v-row>

                            <v-row no-gutters>
                                <v-col offset="6" cols=6>
                                    <v-icon small color="primary">mdi-alert-circle</v-icon>
                                    <span class="ml-3 sms_text2">
                                        Phone number must be complete with country calling code, with no spaces.(ex +09112211221)</span>
                                </v-col>
                            </v-row>

                    </v-card>
                </v-container>
            </v-card>
        </v-container>
    </div>
</template>

<script>

export default {
    // data(){

    // },
    methods:{
        send_sms(){
            axios.get('/sendMessage/').then((response)=>{
                console.log(response.data)
            }).catch((errors)=>{
                console.log(errors)
            })
        }
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