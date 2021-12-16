<template>
    <v-dialog v-model="dialog" persistent width="30%">
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    NEW SELLER
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row>
                            <v-flex xs12>
                                <v-subheader class="px-0">First Name</v-subheader>
                                <v-text-field
                                    v-model="formData.first_name"
                                    name= "First Name"
                                    ref="First Name"
                                    dense
                                    filled
                                    solo
                                    hide-details
                                    v-validate="'required'"
                                    :error-messages="errors.collect('First Name')"
                                    data-vv-name="First Name"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-subheader class="px-0">Last Name</v-subheader>
                                <v-text-field
                                v-model="formData.last_name"
                                    name="Last Name"
                                    ref="Last Name"
                                    v-validate="'required'"
                                    :error-messages="errors.collect('Last Name')"
                                    data-vv-name="Last Name"
                                    dense
                                    filled
                                    solo
                                    hide-details
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-subheader class="px-0">Mobile Number</v-subheader>
                                <v-text-field
                                    type="number"
                                    v-model="formData.mobile"
                                    ref="Mobile Number"
                                    v-validate="'required'"
                                    :error-messages="errors.collect('Mobile Number')"
                                    data-vv-name="Mobile Number"
                                    dense
                                    filled
                                    solo
                                    hide-details
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-subheader class="px-0">Username</v-subheader>
                                <v-text-field
                                    v-model="formData.username"
                                    ref="Username"
                                    v-validate="'required'"
                                    :error-messages="errors.collect('Username')"
                                    data-vv-name="Username"
                                    dense
                                    filled
                                    solo
                                    hide-details
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-subheader class="px-0">Email</v-subheader>
                                <v-text-field
                                    v-model="formData.email"
                                    ref="email"
                                    v-validate="'required'"
                                    :error-messages="errors.collect('Email')"
                                    data-vv-name="Email"
                                    dense
                                    hide-details
                                    filled
                                    solo
                                ></v-text-field>
                            </v-flex>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        small
                        width="70px"
                    >
                        Submit
                    </v-btn>
                    <v-btn
                        color="error"
                        small
                        width="70px"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
    </v-dialog>
</template>
<script>
export default {
    data(){
        return {
            formData:{
                first_name:'',
                last_name:'',
                mobile:'',
                username:'',
                email:'',
            }
        }
    },
    props: {
        dialog:{
            required: true,
            type: Boolean,
            default: false
        },
    },
    methods: {

    }
}
</script>