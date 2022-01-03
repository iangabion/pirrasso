<template>
    <v-dialog v-model="dialog" persistent width="30%">
        <v-card>
            <v-card-title class="text-h5 grey lighten-2">
                NEW SELLER
            </v-card-title>
            <v-card-text>
                <v-container fluid>
                    <v-row>
                        <div class="js--image-preview" style="margin: auto;">
                            <v-img
                                style="width: 200px; height: 150px"
                                :src="formData.profile_picture || '/images/profile.jpg'"
                            ></v-img>
                        </div>
                        <div class="upload-options" required style="padding-top: 5px;">
                            <label>
                                <input
                                    id="fileData"
                                    type="file"
                                    @change="onFileChange"
                                />
                            </label>
                        </div>
                        <v-flex xs12>
                            <v-subheader class="px-0">Full Name</v-subheader>
                            <v-text-field
                                v-model="formData.full_name"
                                name= "Full Name"
                                ref="Full Name"
                                dense
                                filled
                                solo
                                hide-details
                                v-validate="'required'"
                                data-vv-name="First Name"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-subheader class="px-0">Email</v-subheader>
                            <v-text-field
                                v-model="formData.email"
                                ref="email"
                                v-validate="'required|email'"
                                data-vv-name="Email"
                                dense
                                hide-details
                                filled
                                solo
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-subheader class="px-0">Gender</v-subheader>
                            <v-text-field
                            v-model="formData.gender"
                                name="Gender"
                                ref="Gender"
                                v-validate="'Gender'"
                                data-vv-name="Gender"
                                dense
                                filled
                                solo
                                hide-details
                            ></v-text-field>
                        </v-flex>
                         <v-flex xs12>
                            <v-subheader class="px-0">Bio</v-subheader>
                            <v-text-field
                            v-model="formData.bio"
                                name="Bio"
                                ref="Bio"
                                v-validate="'Bio'"
                                
                                data-vv-name="Bio"
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
                                data-vv-name="Username"
                                dense
                                filled
                                solo
                                hide-details
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-subheader class="px-0">Password</v-subheader>
                            <div style="display:flex; gap: 20px">
                                <v-text-field
                                    id="password"
                                    v-model="formData.password"
                                    ref="password"
                                    v-validate="'required'"
                                    data-vv-name="Password"
                                    dense
                                    style="width: 200px"
                                    hide-details
                                    filled
                                    type="password"
                                    solo
                                ></v-text-field>
                                <button @click="switchVisibility()"><v-icon :color="is_true ? 'primary': 'error'">{{ is_true ? 'mdi-eye' : 'mdi-eye-off'}}</v-icon></button>
                            </div>
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
                    @click="create()"
                >
                    Submit
                </v-btn>
                <v-btn
                id="close"
                    color="error"
                    small
                    width="70px"
                    @click="$emit('close')"
                    @click.prevent= 'reset()'
                >
                    Close
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import { CreateClient } from '@api/client.api'
export default {
    data(){
        return {
            formData:{
                profile_picture:'',
                first_name:'',
                last_name:'',
                mobile:'',
                username:'',
                email:'',
                password:'password',
            },
            is_true:false,
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
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            this.createImg(files[0]);
        },
        createImg(file){
            var image = new Image;
            var reader = new FileReader;

            reader.onload = (e) => {
                this.formData.profile_picture = e.target.result;
                };
            reader.readAsDataURL(file)
        },
        create() {
            alert("clicked")
            let payload = this.formData
            CreateClient(payload).then((data)=> {
                console.log("data",data.data);

            })
        },
        reset(){
            this.formData.profile_picture='';
            this.formData.first_name='';
            this.formData.last_name='';
            this.formData.mobile='';
            this.formData.username='';
            this.formData.email='';
            this.formData.password='password';

            document.getElementById('fileData').value='';
        },
        switchVisibility() {
            const passwordField = document.querySelector('#password')
            if (passwordField.getAttribute('type') === 'password'){
                 passwordField.setAttribute('type', 'text');
                 this.is_true = true
            }
            else{
                passwordField.setAttribute('type', 'password');
                this.is_true = false
            } 
        },
    }
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
</style>