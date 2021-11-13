<template>
    <div>
        <v-toolbar>
            <v-col cols="12" sm="6" lg="8">
                 <!-- <v-text-field
                    flat
                    solo-inverted
                    hide-details
                    class="hidden-sm-and-down"
                    style= "width: 300px"
                /> -->
                <v-text-field
                    flat
                    filled dense rounded
                    solo-inverted
                    hide-details
                    prepend-inner-icon="mdi-magnify"
                    label="Search Item"
                    v-model="form.search"
                    :items='categories_item'
                />
            </v-col>
        </v-toolbar>
        <v-sheet elevation="6">
            <v-tabs
            background-color="primary"
            dark
            next-icon="mdi-arrow-right-bold-box-outline"
            prev-icon="mdi-arrow-left-bold-box-outline"
            show-arrows
            center-active
            fixed-tabs
            >
            <v-tabs-slider color="white"></v-tabs-slider>
            <v-tab
                v-for="i in categories"
                :key="i.id"
                @click="get_items(i.id)"
            >
                 {{ i.name }}
            </v-tab>
            </v-tabs>
        </v-sheet>
        <v-container class="">
            <v-layout row wrap>
                <v-flex xs12 v-if="!data_loaded">
                    <v-skeleton-loader
                        type="table-tbody"
                    ></v-skeleton-loader>
                </v-flex>
                <v-flex xs12 v-else >
                    <v-layout row wrap v-if="categories_item.length">
                        <v-flex  xs12 sm2  v-for="(items,index) in categories_item" :key="items.id" >
                            <v-card>
                                <v-list-item>
                                <v-list-item-avatar color="grey">
                                    <v-img class="pa-2"
                                        :src="items.owner.profile_pic"
                                    ></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title >{{items.owner.username}}</v-list-item-title>
                                    <v-list-item-subtitle>10 minutes ago</v-list-item-subtitle>
                                </v-list-item-content>
                                </v-list-item>
                                <v-img class="pa-2"
                                aspect-ratio="1.5"
                                contain
                                :src="items.images.length ? items.images[0].image : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg' "
                                ></v-img>
                                <v-list-item>
                                <v-list-item-content class="text-capitalize">
                                    <v-list-item-title class="py-1 font-weight-bold" >  {{items.title}}</v-list-item-title>
                                    <v-list-item-subtitle > <v-icon>mdi-coin</v-icon> PHP {{items.price}}</v-list-item-subtitle>
                                    <v-list-item-subtitle class="py-1"> <v-icon>mdi-comment</v-icon> {{items.description}}</v-list-item-subtitle>
                                    <v-list-item-subtitle ><v-icon>mdi-star-box</v-icon> {{items.status}}</v-list-item-subtitle>
                                </v-list-item-content>
                                </v-list-item>
                                <v-divider></v-divider>
                                <v-card-actions >
                                <v-btn icon>
                                    <v-icon color="primary">mdi-eye</v-icon>
                                </v-btn>
                                <v-btn icon @click="destroy(items.id , index)">
                                    <v-icon color="error">mdi-delete</v-icon>
                                </v-btn>
                                </v-card-actions>
                                
                            </v-card>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap v-else>
                        <v-flex >
                           <v-alert
                            border="right"
                            colored-border
                            type="error"
                            elevation="2"
                            >
                            no items for this category
                            </v-alert>
                        </v-flex>
                    </v-layout>

                </v-flex>
            </v-layout>
        </v-container>
        
    </div>
</template>
<script>
export default {
    data: () => ({
        categories:[],
        categories_item:[],
        data_loaded : true ,
        form:{
            search:'',
        }
    }),
    methods: {
        search_item(key){
            axios.post('/api/search', {searchkey:key}).then((data) => {
                console.log(data, 'chan_search')
                this.categories_item = data.data
            });
        },

        get_categories() {
            axios.get('/category', {})
            .then(response => {
                this.categories = response.data;
                this.get_items(response.data[0].id)
            });
        },
        get_items(id) {
            this.data_loaded=false ;
            axios.get('/category_items/' + id, {})
            .then(response => {
                this.categories_item = response.data.data ;
                console.log(this.categories_item)
                this.data_loaded=true ;
            })
        },
    
        destroy(id , index) {
            this.$root.$confirm('Are you sure you want to delete ?').then((result) => {
                if(result) {
                    axios.delete('/item/'+id, {})
                    .then(response => {
                        this.categories_item.splice(index,1)
                        console.log(response.data)
                        alert('delete')
                    });
                }
            });
        }
    },
    created() {
        this.get_categories(),
        this.get_items()
       
	},
    watch:{
        "form.search":{
            handler(val){
                this.search_item(val)
            }
        }
    }
}
</script>
<style scoped>
 .row {
     margin-left: 5px ;
     margin-right: 5px ;
 }
 .sm2 {
     margin: 10px;
 }
</style>