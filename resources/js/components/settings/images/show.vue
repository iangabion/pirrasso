<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Apps Images</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>

        <v-container grid-list-xs >
        <!-- <v-layout row wrap> -->
        <v-card>
            <v-row no-gutters>
                <v-card width="50%" align="center" elevation=0>
                        
                        <v-img
                            max-height="400"
                            min-height="400"
                            max-width="400"
                            min-width="400"
                            contain=""
                            src="images/app_images/logo.jpeg"
                        >
                        </v-img >
                        <v-card-subtitle align="center" class ="mt-0 pt-0">
                            <h1>Current App Logo</h1>
                        </v-card-subtitle>
                </v-card>

                <v-card width="50%" elevation="0">
                    <v-row no-gutters align="center" class="mt-8">
                            <v-img

                                max-height="200"
                                min-height="200"
                                class="mx-auto mt-12"
                                max-width="200"
                                min-width="200"
                                contain=""
                                :src="logo.image || 'https://thumbs.dreamstime.com/b/no-image-available-icon-photo-camera-flat-vector-illustration-132483141.jpg'"
                            >
                            </v-img>
                            <v-file-input
                                class="pr-12"
                                small-chips
                                accept="image/*"
                                label="Change Logo"
                                v-validate="'image'"
                                :error-messages="errors.collect('Logo')"
                                data-vv-name="Logo"
                                @change="onFileChange('cat', $event)"
                                >
                            </v-file-input>
                    </v-row>
                    <v-flex xs12 class="text-left mt-6 ml-9">
                            <v-btn color="success" small title @click.prevent="save_logo">
                                <v-icon left>mdi-content-save-edit-outline</v-icon>
                                save logo
                            </v-btn>
                    </v-flex>
                </v-card>
            </v-row>
        </v-card>
        <!-- </v-layout> -->
        </v-container>
    </div>
</template>

<script>
export default {
    data:() => ({
        logo:{
            image:'',
            id:'',
        }     
    }),
    methods:{

        onFileChange(hint,files) {
                // var files = e.target.files || e.dataTransfer.files;

                if (files == "") {
                    return
                }

                var reader = new FileReader();
                reader.onload = (e) => {
                    hint === 'cat' ,  this.logo.image = e.target.result ;
                };
                reader.readAsDataURL(files);
        },

        save_logo(){
            const id = this.logo.id
            axios.post('api/add_photo4Logo/' + id, this.logo).then((response)=>{
                console.log(response.data, 'save log status')
                this.subcatclear()
                window.location.reload()
            })
        },

        subcatclear(){
            this.$validator.reset()
            for (var key in this.logo){
                this.logo[key] = '';
            }
        },
    },
}
</script>

