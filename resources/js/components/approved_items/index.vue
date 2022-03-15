<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Items</v-toolbar-title>
            <v-spacer></v-spacer>
            <div class="search1">
                <v-text-field
                    hide-details
                    placeholder="Search"
                    v-model="form.search"
                    filled
                    rounded
                    dense
                    single-line
                    append-icon="mdi-magnify" class=" mx-4"
                    :value="prefill"
                     style="display:none"
                />
            </div>
            <v-btn @click="dialog2 = true" class="d-none">
                <v-icon class="mr-2">
                    mdi-cart
                </v-icon>
                    Add Setting
            </v-btn>
        </v-toolbar>
        <disapprovedDialog
            :dialog="dialog"
            @closedisapproved="disapproved_close"
            :item="selected_item"
            @close="dialog=false"
        ></disapprovedDialog>
<!-- here -->
        <div>
            <v-container grid-list-xs>
                <v-card min-height="80vh">
                <v-layout row wrap>
<!-- here -->
                    <v-flex xs2>
                    <v-list color="deep-orange darken-2" dark dense 
                         width="270" max-height="77vh" min-height="77vh" class="mx-auto scroll2">
                        <template v-for="item in categories">
                            <v-row v-if="item.heading" :key="item.heading" align="center">
                            </v-row>
                            <v-list-group
                                v-else-if="item.subcategories!=0" :key="item.name" v-model="item.model"
                                sub-group :value="true"
                            >
                                <template v-slot:activator>
                                    <v-list-item dense style="cursor:pointer;">
                                        <v-list-item-content>
                                            <v-list-item-title>
                                               <h5>{{ item.name }}</h5>
                                            </v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                </template>
                                <v-list-item v-for="(subcat, i) in item.subcategories"
                                    :key="i" @click="selected_category = subcat.id"
                                    v-bind:class="{'chan_grey' : highlight(subcat.id) }"
                                    v-on:click="isgrey = subcat.id" dense
                                >
                                    <v-list-item-content >
                                        <v-list-item-title v-bind:class="{'chan_grey' : highlight(subcat.id) }">
                                           <h6> {{ subcat.name }} </h6>
                                        </v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list-group>
                            <v-list-item v-else :key="item.id" @click.prevent="get_items(item.id)"
                                v-bind:class="{'chan_grey' : highlight(item.id) }" v-on:click="isgrey = item.id"
                            >
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title v-bind:class="{'chan_grey' : highlight(item.id) }">
                                            <h5>{{ item.name }}</h5>
                                        </v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list-item>
                        </template>
                    </v-list>
                    </v-flex>
<!-- divide -->
                <v-flex xs10>
                <v-card min-height="77vh" max-height="77vh" class="ma-2 scroll">
                    <v-container >
<!-- start -->
                            <v-layout row wrap>
                                <!-- <v-card> -->
                                    <v-flex xs12 v-if="!data_loaded">
                                        <v-skeleton-loader
                                            type="table-tbody"
                                        ></v-skeleton-loader>
                                    </v-flex>
                                    <v-flex xs13 v-else>
                                        <v-layout row wrap v-if="categories_item.length">
                                            <v-flex  xs6 sm6  v-for="(items,index) in categories_item" :key="items.id" >
                                                <v-card
                                              
                                                >
                                                    <v-list-item>
                                                    <v-list-item-avatar grey>
                                                        <v-img class="pa-2"
                                                            :src="items.owner.profile_pic ? items.owner.profile_pic : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg' "
                                                        ></v-img>
                                                      
                                                    </v-list-item-avatar>
                                                    <v-list-item-content>
                                                        <v-list-item-title >{{items.owner.username ? items.owner.username : items.owner.email}}</v-list-item-title>
                                                    </v-list-item-content>
                                                    </v-list-item>
                                                    <!-- <v-img class="pa-2"
                                                    aspect-ratio="1.5"
                                                    contain
                                                    :src="items.images.length ? items.images[0].filename : 'images/default.png' "
                                                    ></v-img> -->
                                                    <div class="pa-4">
                                                        <v-carousel
                                                            height="300"
                                                            interval="5000"
                                                            cycle
                                                            hide-delimiters
                                                            show-arrows-on-hover
                                                        >
                                                            <v-carousel-item
                                                                v-for="(item,i) in items.images"
                                                                :key="i"
                                                                :src="item.filename ? item.filename : 'images/default.png'"
                                                                reverse-transition="fade-transition"
                                                                transition="fade-transition"
                                                            ></v-carousel-item>
                                                        </v-carousel>

                                                    </div>
                                                    <!-- <v-img
                                                        lazy-src="https://picsum.photos/id/11/10/6"
                                                        max-height="150"
                                                        max-width="250"
                                                        src="https://picsum.photos/id/11/500/300"
                                                        ></v-img> -->
                                                    <!-- :src="items.images.length ? items.images[0].image : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg' " -->
                                                    
                                                    <v-list-item>
                                                    <v-list-item-content class="text-capitalize">
                                                        <v-list-item-title class="py-1 font-weight-bold" >  {{items.title}}</v-list-item-title>
                                                            <div class="row">
                                                                <div class="column column2" width="30px">   
                                                                    <v-tooltip left>
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-list-item-subtitle >
                                                                                <v-icon
                                                                                    v-bind="attrs"
                                                                                    v-on="on"
                                                                                >mdi-grid-large</v-icon> 
                                                                                    {{items.category.name}}
                                                                            </v-list-item-subtitle>
                                                                        </template>
                                                                        <span>Category Type</span>
                                                                    </v-tooltip>
                                                                    <v-tooltip left>
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-list-item-subtitle > 
                                                                                <v-icon
                                                                                    v-bind="attrs"
                                                                                    v-on="on"
                                                                                >mdi-cash-usd</v-icon> 
                                                                                    {{items.price}}
                                                                                </v-list-item-subtitle>
                                                                        </template>
                                                                        <span>Price</span>
                                                                    </v-tooltip>
                                                                    <v-tooltip left>
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-list-item-subtitle class="py-1"> 
                                                                                <v-icon
                                                                                    v-bind="attrs"
                                                                                    v-on="on"
                                                                                >mdi-comment</v-icon> 
                                                                                    <span class="location_font">{{items.description}}</span>
                                                                            </v-list-item-subtitle>
                                                                        </template>
                                                                        <span>Description</span>
                                                                    </v-tooltip>
                                                                    <br>
                                                                  
                                                                    <v-tooltip left>
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-list-item-subtitle >
                                                                                <v-icon
                                                                                    v-bind="attrs"
                                                                                    v-on="on"
                                                                                >mdi-star-box</v-icon> {{items.status}}
                                                                            </v-list-item-subtitle>
                                                                        </template>
                                                                        <span>Status</span>
                                                                    </v-tooltip>
                                                                </div> 
                                                                <div class="column column3 child" style="text-align: bottom">
                                                                    <div style="padding-top:65px"> 
                                                                    <v-tooltip left>
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-list-item-subtitle class="py-1"> 
                                                                                <v-icon
                                                                                    v-bind="attrs"
                                                                                    v-on="on"
                                                                                >mdi-map-marker</v-icon>
                                                                                    <span class="location_font">{{items.location}}</span>
                                                                                </v-list-item-subtitle>
                                                                        </template>
                                                                        <span>Location</span>
                                                                    </v-tooltip>
                                                                    <v-tooltip left>
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-list-item-subtitle >
                                                                                <v-icon
                                                                                    v-bind="attrs"
                                                                                    v-on="on"
                                                                                >mdi-calendar</v-icon> 
                                                                                {{items.created_at}}
                                                                                </v-list-item-subtitle>
                                                                        </template>
                                                                        <span>Date Created</span>
                                                                    </v-tooltip>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <v-list-item-subtitle >
                                                        <span v-if="(items.is_urgent)==1">
                                                            <v-icon>mdi-alert-octagon</v-icon>
                                                            {{$t('item.show.urgent')}}
                                                        </span>
                                                        </v-list-item-subtitle>
                                                        <v-list-item-subtitle>
                                                            <span v-if="(items.is_active)==1">
                                                                <v-icon>mdi-alert-octagon</v-icon>
                                                                {{$t('item.show.active')}}
                                                            </span>
                                                            <span v-if="(items.is_active)==0">
                                                                <v-icon>mdi-alert-octagon</v-icon>
                                                                {{$t('item.show.unactive')}}
                                                            </span>
                                                        </v-list-item-subtitle>
                                                    <!-- <v-list-item-subtitle>

                                                                <span v-if="(items.is_active)==1">
                                                                <v-icon>mdi-check</v-icon>
                                                                </span>

                                                                <span v-if="(items.is_active)==0">
                                                                <v-icon>mdi-close</v-icon>
                                                                </span>

                                                                <span v-if="(items.is_active)==0">
                                                                <v-icon>mdi-close</v-icon>
                                                                </span>

                                                    </v-list-item-subtitle> -->
                                                    </v-list-item-content>
                                                    </v-list-item>
                                                    <v-divider></v-divider>
                                                    <v-card-actions >
                                                        <v-spacer></v-spacer>

                                                    <!-- <v-btn icon>
                                                        <v-icon @click="show(items , index)" color="primary">mdi-eye</v-icon>
                                                    </v-btn> -->
                                                    <!-- <v-btn icon @click="destroy(items.id , index)">
                                                        <v-icon color="yellow">mdi mdi-coin</v-icon>
                                                    </v-btn> -->
                                                     <v-btn icon @click="approve(items, index)">
                                                        <v-icon color="green">mdi-check-circle</v-icon>
                                                    </v-btn>
                                                    <!-- <v-btn icon @click="destroy(items.id , index)">
                                                        <v-icon color="error">mdi-delete</v-icon>
                                                    </v-btn> -->
                                                    <v-btn icon @click="disapproved(items)">
                                                        <v-icon color="error">mdi-delete</v-icon>
                                                    </v-btn>
                                                                                                 
                                                    <v-checkbox  
                                                        type="checkbox"
                                                        v-model="test"                                             
                                                        :value="items.id"
                                                                                           
                                                    ></v-checkbox>
                                                  

                                                     
                                                   


                                                    </v-card-actions>
                        
                                                </v-card>
<!-- dia1 -->
                                                                        
<!-- dia3 -->
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
                                                    {{$t('item.show.no_items_for_this_category')}}
                                                </v-alert>
                                            </v-flex>
                                        </v-layout>
                                        
                                    </v-flex>
                                <!-- </v-card> -->
                            </v-layout>
                           
                    </v-container>
                </v-card>
                </v-flex>
<!-- here -->
            </v-layout>
            
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                        style="color:white"
                        color="green"
                        @click="updatechecked()"
                        >
                            Approved Marked
                        </v-btn>

                       
                        <v-btn
                        style="color:white"
                        color="red"
                        @click="deletechecked()"
                        >
                            Delete Marked
                        </v-btn>
                    </v-card-actions>
            </v-card>
            
            <v-dialog
            v-model="dialogreason"
            width="500"

            >
                <!-- <v-card>
                    {{payload.id}}
                    {{payload.owner.full_name}}
                    {{payload.owner.email}}
                    {{payload.title}}
                </v-card> -->
                <v-card>
                    <v-card-title class="text-h5 grey lighten-2">
                        {{$t('approved_items.disapproved_dialog.disapprovement_notice')}}
                    </v-card-title>
                    <v-card-text>
                        <v-container fluid>
                            <v-row>
                                <v-flex xs12>
                                    <v-textarea
                                        label="Reason For Disapprovement"
                                        solo
                                        v-model="payload.reason"
                                        filled
                                    ></v-textarea>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                        dense
                                        label="Send To"
                                        :value="payload.owner ? payload.owner.email : 'test@test.com'"
                                        outlined
                                        disabled
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                        dense
                                        disabled
                                        :value="payload.title"
                                        label="Item Name"
                                        outlined
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
                            @click.prevent="sendMail()"
                            @click="progress_circular = true"
                        >
                            {{$t('send')}}
                        </v-btn>
                        <v-btn
                            color="error"
                            small
                            width="70px"
                            @click="dialogreason=false"
                        >
                            {{$t('cancel')}}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            </v-container>
        </div>
<!-- here -->
            <!-- <dialog-reason
                v-if="reasondialog"
                :dialog="reasondialog"
                @close="reasondialog=false"
            >
            </dialog-reason> -->
    </div>
</template>
<script>
import { GetToApprovedItems, ApprovedItem, ApproveMail, DisapproveMail, RemoveDisapproveItem } from "@api/item.api";
import disapprovedDialog from './includes/disapproved_dialog.vue'

export default {
     components : {
       disapprovedDialog,
      
    },
    data: () => ({
        dialog:false,
        dialogreason:false,
        selected_item: {},
        dialogActivate: false,
        dialogDeActivate: false,
        dialogItem:false,
        categories:[],
        categories_item:[],
        data_loaded : true ,
        form:{
            search:'',
        },
        loading: false,
        categor:{},
        tab:'tab-1',

        selectedItem: 1,
        categories_with:[],
        categories_witho:[],
        id_chan:'tab-1',
        selected_category:'',
        test:[],
        isgrey: 1,
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
            status:'',
            reason: '',
            email: '',
        }

    }),
    

   

    methods: {
        sendMail() {
            // alert(this.payload);
            // console.log(this.payload)
        
            // DisapproveMail (this.payload).then((response) => {
            //    console.log(response.data)
                RemoveDisapproveItem(this.payload.id).then((response) => {
                    console.log(response.data)
                    this.get_items(this.categories[0].id)
                    this.sendMail2();
                   
                })
            // }).catch((errors) => {
            //     console.log(errors)
            // });
        },

        sendMail2(){
            DisapproveMail (this.payload).then((res) => {
                console.log(res.data)
                 this.dialogreason = false;
                  alert('Message Sent Successful');
            })
        },

        open_reason(items){
            this.dialogreason = true
            this.selected_item = items

        },
        search_item(key){
                this.loading=true
                if(this.timer){
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.timer = setTimeout(()=> {
                    if(key===this.selected_category){
                        if(key!='')
                        {
                        this.get_items(this.selected_category)
                        this.selected_category=''
                        this.loading=false
                        }else{
                            this.get_categories()
                        }
                    }
                    else{

                        if(this.timer){
                            clearTimeout(this.timer);
                            this.timer = null;
                        }
                        this.timer = setTimeout(()=> {
                            let payload = {
                                searchkey:key,
                                subcat_category: this.selected_category
                            }
                            // if(key===null){
                            //         this.get_categories()
                            // }else{
                                axios.post('/api/searchchan2', payload, {}).then((data) => {
                                this.categor = data.data
                                this.categories_item = this.categor.data
                                // console.log(this.categories)

                                this.loading=false
                                this.selected_category=''
                                }).catch((errors)=>{
                                    console.log(errors)
                                });
                            // }
                        });
                    }
                });
        },

        get_categories() {
            axios.get('/api/categories')

            .then(response => {
                this.categories = response.data;
                let payload = {
                    id: 0,
                    name: 'All',
                    subcategories: 0
                }
                this.categories.unshift(payload)
                // this.search_item(key)
                this.get_items(this.categories[0].id)
            }).catch((errors)=>{
                console.log(errors)
            });
        },

        get_items(id) {
            if(id===0) {
                this.loading=true
                this.data_loaded=false
                axios.get('/api/get_all_items_unapproved').then(response =>{
                    this.categories_item = response.data.data
                    console.log(this.categories_item, "hey hey")
                    this.highlight(id)
                    this.data_loaded=true
                    this.loading=false
                })
            }
            else{
                this.data_loaded=false;
                axios.post('api/get_category/' + id, {})
                .then(response => {
                    this.categories_item = response.data.data ;
                    this.data_loaded=true ;
                })
            }
        },

        highlight(id){
            return id === this.isgrey
        },

        destroy(id, index ) {
            this.$root.$confirm('Are you sure you want to delete ?').then((result) => {
                if(result) {

                    // console.log(id, index)
                    axios.delete('/item/'+id, {})
                    .then(response => {
                        this.categories_item.splice(index,1)
                        alert('Item Removed')
                    });
                }
            });
            // console.log(items.owner.mobile, items.id,  "test yey")
        },

        approve(items, index) {
            this.$root.$confirm('Confirm Approve ?').then((result) => {
               
                        if(result) {
                            
                                    ApprovedItem(items.id).then( response => {
                                    this.categories_item.splice(index,1)
                                        alert('Approved and Approved Notification Sent')
                                        this.approved_sms(items)
                                    }).catch((error)=>{
                                        console.log(error)
                                    })
                    //         axios.put('items/approve_item/'+id, {})
                    //     .then(response => {
                    //         this.categories_item.splice(index,1)
                    //         alert('Approved and Approved Notification Sent')
                    //     }).catch((error)=>{
                    // console.log(error)
                    // });
                        }
                            });
                      
        },
        approved_sms(items){
             let payload = {
                number: items.owner.mobile,
                id: items.id
            }
            axios.post('api/sms_sender/', payload).then((response)=>{
                console.log(response.data , 'chan')
            })
        },
        // disapproved(items.id){
        //     this.selected_item = items.id
        //     this.$nextTick(() => {
        //         this.dialog = true
        //     })
        // },

        activate(){
            // axios.put('/subcategories/'+id, this.subcat )
            // return
            axios.put('activate',this.payload).then(res=> {
                console.log(res, 'activate')
                  this.get_categories()
                  this.dialogActivate = false
            })
        },
        deactivate(){
              console.log(this.payload, 'test')
            // return
            axios.put('deactivate',this.payload).then(res=> {
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
        },

        updatechecked(){
            // console.log(this.test)
            axios.post('bulkapprove', this.test).then(res=>{
                // this.search_item(key)
                this.get_items(this.categories[0].id)
                 alert('Items Approved')
                this.test=[];
                console.log(res)
           
              
            })
        },
         disapproved_close() {
            this.dialog = false
             this.get_items(this.categories[0].id)
        },

        deletechecked(){
            // console.log(this.test)
            axios.post('bulkdelete', this.test).then(res=>{
                // this.search_item(key)
                this.get_items(this.categories[0].id)
                this.test=[];
                alert('Items Removed')
                console.log(res)
           
              
            })
        },

        disapproved(items){
            this.payload = JSON.parse(JSON.stringify(items))
            this.dialogreason = true
        },
        disapproved(items){
            this.selected_item = items
            this.$nextTick(() => {
                this.dialog = true
            })
        },

    

    },
    created() {
             this.get_categories()
	},
    watch:{
        "form.search":{
            handler(val){
                this.search_item(val)
            },
            deep: true,
        },
        selected_category: function(val){
            if(val){
                this.search_item(val)
            }
        },
       
    },
    computed:{
        prefill(){
                return this.form.search = this.$route.query.item;
        }
    }
}
</script>

<style scoped>
    /* .row {
        margin-left: 5px ;
        margin-right: 5px ;
    } */
    /* .sm2 {
        margin: 10px;
    } */

    .custom >>> .v-input__slot:before{
        border-style:none !important;
    }
    .custom >>> .v-input__slot:after{
        border-style:none !important;
    }
    /* .chan_con{
        color: green;
    } */
    .chan_grey{
        /* background-color: rgb(104, 166, 236); */
        /* background-color: white; */

        /* color: rgb(171, 193, 224) !important; */
        color:black;
        width: auto;
    }
    .hide{
        display: none;
    }

    .scroll {
        overflow-y: scroll;
        
        overflow-x: hidden;
    }
     .scroll2 {
        overflow-y: scroll hidden thin;
        
        overflow-x: hidden;
    }
    .location_font {
        font-size: 11px;
    }
    .column {
        float: left;
        width: 50%;
        padding: 10px;
        }
    .column2 {
         width: 60%;
    } 
    .column3 {
         width: 40%;
         
    }

    /* Clear floats after the columns */
    .row:after {
    content: "";
    display: table;
    clear: both;
    }

   
</style>