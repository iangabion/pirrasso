<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Apps Images</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-container grid-list-xs>

<!-- first sample -->
            <!-- <v-card min-height="100" elevation="0">
                <span>Items</span> <br>
                <v-row v-if="item_image!=''">
                    <v-col v-for="item in item_image" :key="item.id" cols="3" class="d-flex child-flex">
                        <v-img aspect-ratio="1" class="grey lighten-2" :src="item.icon" >
                            <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                >
                                    <v-progress-circular
                                    indeterminate
                                    color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                            </template>
                        </v-img>
                    </v-col>
                </v-row>
                <span v-else class="d-flex justify-center"> no content </span>
            </v-card>
                <v-divider inset></v-divider>
// division
            <v-card min-height="100" elevation="0">
                <span>Categories</span><br>
                <v-row v-if="cat_image.icon!=null">
                    <v-col v-for="item in cat_image" :key="item.id" cols="3" class="d-flex child-flex">
                        <v-img aspect-ratio="1" class="grey lighten-2" :src="item.icon" :alt="item.icon">
                            <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center">
                                    <v-progress-circular
                                    indeterminate
                                    color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                            </template>
                        </v-img>
                    </v-col>
                </v-row>
                <span v-else class="d-flex justify-center"> no content </span>
            </v-card>
                <v-divider inset></v-divider>
// division
            <v-card>
                <span>SubCategories</span> <br>
                <v-row v-if="subcat_image!=''">
                    <v-col v-for="item in subcat_image" :key="item.id" cols="3" class="d-flex child-flex">
                        <v-img aspect-ratio="1" class="grey lighten-2" :src="item.icon" >
                            <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                >
                                    <v-progress-circular
                                    indeterminate
                                    color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                            </template>
                        </v-img>
                    </v-col>
                </v-row>
                <span v-else class="d-flex justify-center"> no content </span>
            </v-card>
                <v-divider inset></v-divider> -->
<!-- first sample -->
        
         <v-card>
                <span>All Images</span> <br>
                <v-row v-if="sample!=''">
                    <v-col v-for="item in sample" :key="item.id" cols="3" class="d-flex child-flex">
                        <v-img aspect-ratio="1" class="grey lighten-2" :src="item.filename" >
                            <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                >
                                    <v-progress-circular
                                    indeterminate
                                    color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                            </template>
                        </v-img>
                    </v-col>
                </v-row>
                <span v-else class="d-flex justify-center"> no content </span>
            </v-card>
                <v-divider inset></v-divider>

        </v-container>
    </div>
</template>

<script>
export default {
    data:() => ({
        cat_image:'',
        subcat_image:'',
        item_image:'',

        sample:'',
    }),
    methods:{

        getAllPhoto(){
            axios.get('api/get_allPhoto/').then((data)=>{
                this.sample = data.data
                console.log(this.sample, 'chan here all photo')
            }).catch((error)=>{
                console.log(error)
            })
        }

        // getsubcategory(){
        //     axios.get('api/get_sub_image').then((response)=>{
        //         this.subcat_image=response.data
        //         console.log(this.subcat_image, "sub image Chan")
        //     })
        // },
        // getcategory(){
        //     axios.get('api/get_catgry_image').then((response)=>{
        //         this.cat_image=response.data
        //         console.log(this.cat_image, "cat image Chan")
        //     })
        // },
        // getitem(){
        //     axios.get('api/').then((response)=>{
        //         this.item_image=response.data
        //         console.log(this.item_image, "cat image Chan")
        //     })
        // }
    },
    mounted(){
        this.getAllPhoto()
        // this.getsubcategory()
        // this.getcategory()
        // this.getitem()
    }
}
</script>

