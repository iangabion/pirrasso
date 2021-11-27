<template>

    <div>
        
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
                                    <!-- <v-list-item-subtitle>10 minutes ago</v-list-item-subtitle> -->
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
                                    <v-list-item-subtitle >
                                    <span v-if="(items.is_urgent)==1">
                                        <v-icon>mdi-alert-octagon</v-icon>
                                         Urgent 
                                    </span>  
                                    </v-list-item-subtitle>
                                    <v-list-item-subtitle>
                                        <span v-if="(items.is_active)==1">
                                            <v-icon>mdi-alert-octagon</v-icon>
                                            ACTIVE 
                                        </span>
                                        <span v-if="(items.is_active)==0">
                                            <v-icon>mdi-alert-octagon</v-icon>
                                            UNACTIVE 
                                        </span>
                                    </v-list-item-subtitle>
                                <!-- <v-list-item-subtitle>
                        
                                            <span v-if="(items.is_active)==1">
                                            <v-icon>mdi-check</v-icon>
                                            </span>
                                       
                                      
                                            <span v-if="(items.is_active)==0">
                                            <v-icon>mdi-close</v-icon>
                                            </span>
                                      
                                </v-list-item-subtitle> -->
                                </v-list-item-content>
                                </v-list-item>
                                <v-divider></v-divider>
                                <v-card-actions >
                                
                                <v-btn icon>
                                    <v-icon @click="show(items , index)" color="primary">mdi-eye</v-icon>
                                </v-btn>   
                                <v-btn icon @click="destroy(items.id , index)">
                                    <v-icon color="yellow">mdi mdi-coin</v-icon>
                                </v-btn>
                                <v-btn icon @click="destroy(items.id , index)">
                                    <v-icon color="error">mdi-delete</v-icon>
                                </v-btn>
                                <span v-if="(items.is_active)==0">
                                    <v-btn icon>
                                        <v-icon icon @click="show_deactivate(items , index)">mdi-check</v-icon>                                       
                                    </v-btn>
                                </span>
                                 <span v-if="(items.is_active)==1">
                                    <v-btn icon  @click="show_activate(items , index)">
                                        <v-icon>mdi-close</v-icon>                                       
                                    </v-btn>
                                </span>  
                              
                                
                                </v-card-actions>
                                
                            </v-card>
                            <v-dialog
                            v-model="dialogActivate"
                            width="300px"
                            >


                            <v-card>
                                <v-card
                                class="hide"
                                >
                                       <!-- {{ editedItem.username }} -->
                                       {{payload.owner.username}}
                                        <v-responsive class="image_container" height="20%">
                                            <img 
                                                class="image"
                                                :alt="payload.image"
                                                :src="payload.image? payload.image : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg'"
                                            >
                                        </v-responsive>
                                        <v-list-item>
                                        <v-list-item-content class="text-capitalize">
                                             <v-list-item-title class="py-1 font-weight-bold" > {{payload.id}}</v-list-item-title>
                                            <v-list-item-title class="py-1 font-weight-bold" > {{payload.title}}1212</v-list-item-title>
                                            <v-list-item-subtitle > <v-icon>mdi-coin</v-icon> PHP {{payload.price}}13123231</v-list-item-subtitle>
                                            <v-list-item-subtitle class="py-1"> <v-icon>mdi-comment</v-icon> {{items.description}}</v-list-item-subtitle>
                                            <v-list-item-subtitle ><span v-if="(items.is_urgent)==1"><v-icon>mdi-alert-octagon</v-icon> Urgent </span></v-list-item-subtitle>
                                            <v-list-item-subtitle ><v-icon>mdi-alert-octagon</v-icon> {{payload.is_active}} </v-list-item-subtitle>
                                             
                                            
                                        </v-list-item-content>
                                        </v-list-item>
                                    </v-card>
                                   <p>are you sure to activate this Item?</p> 
                                    <span v-if="(items.is_active)==0">
                                            <v-btn icon  @click="activate()">
                                                <v-icon>mdi-check</v-icon>                                       
                                            </v-btn>
                                            <v-btn icon  @click="dialogActivate=false">
                                                <v-icon>mdi-close</v-icon>                                       
                                            </v-btn>
                                    </span> 


                            </v-card>

                            </v-dialog>

                            <v-dialog
                            v-model="dialogDeActivate"
                            width="300px"
                            >


                            <v-card>
                                <v-card
                                class="hide"
                                >
                                       <!-- {{ editedItem.username }} -->
                                       {{payload.owner.username}}
                                        <v-responsive class="image_container" height="20%">
                                            <img 
                                                class="image"
                                                :alt="payload.image"
                                                :src="payload.image? payload.image : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg'"
                                            >
                                        </v-responsive>
                                        <v-list-item>
                                        <v-list-item-content class="text-capitalize">
                                             <v-list-item-title class="py-1 font-weight-bold" > {{payload.id}}</v-list-item-title>
                                            <v-list-item-title class="py-1 font-weight-bold" > {{payload.title}}1212</v-list-item-title>
                                            <v-list-item-subtitle > <v-icon>mdi-coin</v-icon> PHP {{payload.price}}13123231</v-list-item-subtitle>
                                            <v-list-item-subtitle class="py-1"> <v-icon>mdi-comment</v-icon> {{items.description}}</v-list-item-subtitle>
                                            <v-list-item-subtitle ><span v-if="(items.is_urgent)==1"><v-icon>mdi-alert-octagon</v-icon> Urgent </span></v-list-item-subtitle>
                                            <v-list-item-subtitle ><v-icon>mdi-alert-octagon</v-icon> {{payload.is_active}} </v-list-item-subtitle>
                                             
                                            
                                        </v-list-item-content>
                                        </v-list-item>
                                    </v-card>
                                   <p>are you sure to deactivate this Item?</p> 
                                    <span v-if="(items.is_active)==1">
                                            <v-btn icon  @click="deactivate()">
                                                <v-icon>mdi-check</v-icon>                                       
                                            </v-btn>
                                            <v-btn icon  @click="dialogActivate=false">
                                                <v-icon>mdi-close</v-icon>                                       
                                            </v-btn>
                                    </span> 


                            </v-card>

                            </v-dialog>
                             <v-dialog
                                v-model="dialogItem"
                                width="500px"
                                >
                                    <v-card>
                                       {{ editedItem.username }}
                                       {{payload.owner.username}}
                                        <v-responsive class="image_container" height="20%">
                                            <img 
                                                class="image"
                                                :alt="payload.image"
                                                :src="payload.image? payload.image : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg'"
                                            >
                                        </v-responsive>
                                        <v-list-item>
                                        <v-list-item-content class="text-capitalize">
                                            <v-list-item-title class="py-1 font-weight-bold" >  {{payload.title}}}</v-list-item-title>
                                            <v-list-item-subtitle > <v-icon>mdi-coin</v-icon> PHP {{items.price}}</v-list-item-subtitle>
                                            <v-list-item-subtitle class="py-1"> <v-icon>mdi-comment</v-icon> {{items.description}}</v-list-item-subtitle>
                                            <v-list-item-subtitle ><span v-if="(items.is_urgent)==1"><v-icon>mdi-alert-octagon</v-icon> Urgent </span></v-list-item-subtitle>
                                            
                                        </v-list-item-content>
                                        </v-list-item>


                                    </v-card>
                                </v-dialog>
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
       dialogActivate: false,
        dialogDeActivate: false,
        dialogItem:false,
        categories:[],
        categories_item:[],
        data_loaded : true ,
        is_show: true,
        editedIndex: -1,
        editedItem: {
            username: '',
            image: '',
            title: '',
            price: '',
            description: '',
            status:'',
         
        },
        payload: {
            id: '',
            owner:{
            username:'',
            },
            username: '',
            image: '',
            title: '',
            price: '',
            description: '',
            status:''
        }
        
    }),
    methods: {
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

        getweekly() {
             axios.get('expirationDate').then(res => {
                 console.log(res, 'sad')
                 this.week = res.data
                 console.log(this.week,'dawdaw')
             })
            // axios.get('get_items_this_week')
            // .then(response => {
            //     this.categories_week_item = response.data.data ;
            //     console.log(this.categories_week_item)
               
            // })
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
        },

        activate(){
            // axios.put('/subcategories/'+id, this.subcat )
            console.log(this.payload, 'test')
            // return
            axios.put('activate/',this.payload).then(res=> {
                console.log(res, 'activate')
                  this.get_categories()  
                  this.dialogActivate = false                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            })
        },
        deactivate(){
              console.log(this.payload, 'test')
            // return
            axios.put('deactivate/',this.payload).then(res=> {
                console.log(res, 'deactivate')
                  this.get_categories()  
                  this.dialogDeActivate = false                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            })        
        },
        show(items){
            this.editedIndex = this.categories_item.indexOf(items)
            this.payload = JSON.parse(JSON.stringify(items))                                                                               
            this.dialogItem = true
            
        },

        show_activate(items){
            this.editedIndex = this.categories_item.indexOf(items)
            this.payload = JSON.parse(JSON.stringify(items))
            this.dialogActivate = true
            
        },
         show_deactivate(items){
            this.editedIndex = this.categories_item.indexOf(items)
            this.payload = JSON.parse(JSON.stringify(items))
            this.dialogDeActivate = true
            
        }
    },
    created() {
        this.get_categories()
                 
	},            
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
 .hide{
     display: none;
 }
</style>