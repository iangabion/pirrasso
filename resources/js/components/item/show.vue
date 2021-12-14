<template>

    <div>
        <v-toolbar elevation="0">
            <v-col cols="12" sm="6" lg="8">
                <v-text-field
                    flat
                    filled
                    dense
                    single-line
                    rounded
                    hide-details
                    prepend-inner-icon="mdi-magnify"
                    label="Search Product Name"
                    v-model="form.search"
                    :items='categories_item'
                    clearable
                />
            </v-col>
        </v-toolbar>

<v-row>
    <v-card width=25% max-height=auto elevation="0">
        <v-list dense>
            <template v-for="item in categories" >
                <v-row v-if="item.heading" :key="item.heading" align="center" >
                </v-row>
                <v-list-group
                    v-else-if="item.subcategories!=0" :key="item.name" v-model="item.model"

                >
                    <template v-slot:activator>
                        <v-list-item>
                            <v-list-item-content
                            >
                                <v-list-item-title  >
                                    {{ item.name }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </template>

                    <v-list-item v-for="(subcat, i) in item.subcategories"
                        :key="i" @click="selected_category = subcat.id"
                        v-bind:class="{'chan_grey' : highlight(subcat.id) }"
                        v-on:click="isgrey = subcat.id"
                    >
                        <v-list-item-content >
                            <v-list-item-title v-bind:class="{'chan_grey' : highlight(subcat.id) }">
                                {{ subcat.name }}
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
                                {{ item.name }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item>

            </template>

        </v-list>
    </v-card>
    <v-card width=70% elevation="0">
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
                                        <v-icon icon @click="show_activate(items , index)">mdi-check</v-icon>
                                    </v-btn>
                                </span>
                                 <span v-if="(items.is_active)==1">
                                    <v-btn icon  @click="show_deactivate(items , index)">
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
                            {{$t('item.show.no_items_for_this_category')}}
                            </v-alert>
                        </v-flex>
                    </v-layout>

                </v-flex>
            </v-layout>
        </v-container>
    </v-card>
</v-row>

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
            status:''
        }

    }),
    methods: {
        search_item(key){
            this.loading=true
            if(this.timer){
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(()=> {
                if(key===this.selected_category){
                    this.get_items(this.selected_category)
                    this.selected_category=''
                    this.loading=false
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
                        if(key===null){
                                this.get_categories()
                        }else{
                            axios.post('/api/searchchan', payload, {}).then((data) => {
                            this.categor = data.data
                            this.categories_item = this.categor.data

                            // app.$data.isgray=true
                            // ({})
                            // this.tab = 'tab-2'
                            this.loading=false
                            this.selected_category=''
                            }).catch((errors)=>{
                                console.log(errors)
                            });
                        }
                    });
                }
            });

        },

        get_categories() {
            axios.get('/api/categories', {})

            .then(response => {
                this.categories = response.data;
                let payload = {
                    id: 0,
                    name: 'All',
                    subcategories: 0
                }
                this.categories.unshift(payload)
                // this.categories_with = response.data.filter(chan_filter=>
                //     chan_filter.id==2
                // );
                this.categories_witho = response.data.filter(chan_filter=>
                    chan_filter.id !=2
                )
                this.get_items(this.categories_with[0].id)
            }).catch((errors)=>{
                console.log(errors)
            });
        },

        get_items(id) {
            if(id===0) {
                this.loading=true
                this.data_loaded=false
                axios.get('/api/get_all_items').then(response =>{
                    this.categories_item = response.data.data
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

        destroy(id , index) {
            this.$root.$confirm('Are you sure you want to delete ?').then((result) => {
                if(result) {
                    axios.delete('/item/'+id, {})
                    .then(response => {
                        this.categories_item.splice(index,1)
                        alert('delete')
                    });
                }
            });
        },

        activate(){
            // axios.put('/subcategories/'+id, this.subcat )
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
     mounted() {
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

.custom >>> .v-input__slot:before{
    border-style:none !important;
}
.custom >>> .v-input__slot:after{
    border-style:none !important;
}
.chan_con{
    color: green;
}
.chan_grey{
    background-color: rgb(131, 127, 127);
    border-radius: 10px;
    color: white !important;
}
 .hide{
     display: none;
 }
</style>
