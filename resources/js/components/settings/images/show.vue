<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Apps Images</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-container grid-list-xs>
            <v-layout row wrap>
                <v-flex xs12 sm6 >
                    <v-form ref="form">
                         <v-container  grid-list-md>
                            <v-layout row wrap>
                                <v-flex xs12 >
                                    <v-card class="pa-5" >
                                        <v-layout row wrap mb-3 class="text-capitalize">
                                            <v-flex xs12>
                                                <p class="subheading pa-0 font-weight-bold">Image Information/Changing</p>
                                            </v-flex>
                                            <v-flex xs6>
                                                <div class="preview" >
                                                    <v-img
                                                        max-height="200"
                                                        class="mx-auto"
                                                        max-width="200"
                                                        contain=""
                                                        :src="category.icon || 'https://thumbs.dreamstime.com/b/no-image-available-icon-photo-camera-flat-vector-illustration-132483141.jpg' "

                                                    >
                                                    </v-img>

                                                </div>
                                            </v-flex>
                                            <v-flex xs6>
                                                <v-file-input small-chips
                                                    accept="image/*"
                                                    label="Icon/Images"
                                                   
                                                    data-vv-name="Icon/Images">
                                                </v-file-input>
                                                 <!-- @change="onFileChange('cat', $event)"
                                                    v-validate="'image'"
                                                    :error-messages="errors.collect('Icon')" -->
                                                <v-text-field
                                                    type="text"
                                                   
                                                    data-vv-name="Global Folder Name"
                                                    label="Global Folder Name" required>
                                                </v-text-field>
                                                 <!-- v-model="category.name"
                                                    v-validate="'required'"
                                                    :error-messages="errors.collect('Category Name')" -->
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap mb-3 justify-end>
                                            <v-flex xs12 class="text-right">
                                                <v-btn color="success" tile >
                                                     <!-- @click="submit"  -->
                                                    <v-icon left>mdi-content-save-edit-outline</v-icon>
                                                    save category
                                                </v-btn>
                                                <v-btn color="primary" tile  >
                                                     <!-- @click="clear" -->
                                                    <v-icon left>mdi-lock-reset</v-icon>
                                                    reload form
                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-form>
                </v-flex>
                
            </v-layout>
        </v-container>
    </div>
</template>

<script>
export default {
    data:() => ({
        category:''
    }),
    methods:{

    }
}
</script>

