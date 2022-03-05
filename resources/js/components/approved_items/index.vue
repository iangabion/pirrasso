<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4 text-capitalize">{{$t('approved_items.to_be_approved_items')}}</v-toolbar-title>
            <v-spacer></v-spacer>

        


            
        </v-toolbar>
        <disapprovedDialog
            :dialog="dialog"
            @closedisapproved="disapproved_close"
            :item="selected_item"
            @close="dialog=false"
        ></disapprovedDialog>
        <productInfo
            :drawer="drawer"
            :item="selected_data"
            @collapse-drawer="drawer = !drawer"
        />
        <v-container grid-list-xs>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card>
                        <v-data-table
                            :headers="headers"
                            :items="items"
                          
                        >
                              <template v-slot:item.checkbox="{ item }">
                                <span>
                                    <v-tooltip>
                                    <template v-slot:activator="{ on }">
                                        <v-checkbox  
                                            type="checkbox"
                                            v-on="on"
                                            v-model="test"                                             
                                            :value="item.id"                                           
                                        ></v-checkbox>
                                    </template>
                                </v-tooltip>
                                </span>
                            </template>

                            <template v-slot:item.created_at="{ item }">
                                <span>
                                    {{$defaultDate(item.created_at) }}
                                </span>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn
                                            class="mr-2"
                                            fab
                                            dark
                                            v-on="on"
                                            small
                                            color="green"
                                            @click="open_info(item)"
                                        >
                                            <v-icon dark small>
                                                mdi-eye
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span>view</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn
                                            class="mr-2"
                                            fab
                                            dark
                                            v-on="on"
                                            small
                                            @click="approved(item)"
                                            color="primary"
                                        >
                                            <v-icon dark small>
                                                mdi-check
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{$t('approved_items.approve')}}</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn
                                            class="mr-2"
                                            fab
                                            dark
                                            v-on="on"
                                            small
                                            color="error"
                                            @click="disapproved(item)"
                                        >
                                            <v-icon dark small>
                                                mdi-close
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{$t('approved_items.disapproved')}}</span>
                                </v-tooltip>
                                <!-- <v-tooltip>
                                    <template v-slot:activator="{ on }">
                                        <v-checkbox  
                                            type="checkbox"
                                            v-on="on"
                                            v-model="test"                                             
                                            :value="item.id"                                           
                                        ></v-checkbox>
                                    </template>
                                </v-tooltip> -->
                            </template>
                             <template v-slot:no-data>
                            {{$t('settings.smtp.no_data_found')}}
                            </template>
                        </v-data-table>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                                <v-btn
                                    @click="updatechecked()"
                                   style="background-color: green!important;color:white!important;"
                                   elevation="3"
                                     
                                >
                                 approve marked
                                </v-btn>
                        </v-card-actions>
                     
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
        
        <v-dialog       
            v-model="progress_circular"
            max-width="100"
            persistent
        >
            <v-card>
                <v-card-text class="text-xs-center pt-1">
                    <v-progress-circular :size="50" indeterminate class="primary--text"/>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import disapprovedDialog from './includes/disapproved_dialog.vue'
import { GetToApprovedItems, ApprovedItem, ApproveMail } from "@api/item.api";
import productInfo from './includes/productInfo.vue'
export default {
    components : {
        disapprovedDialog,
        productInfo
    },
    data(){
        return{
           
            test:[],
           
            checkbox1: true,
            items:[],
            dialog:false,
            selected_item:[],
         
            selected_data:{},
            progress_circular : false,
            drawer: false,
            // headers: [
            //     { text: 'Item Name',width:'20%', value: 'title' },
            //     { text: 'Category', value: 'category.name', width:'20%' },
            //     { text: 'Price', value: 'price', width:'10%' },
            //     { text: 'Seller Username',align: 'start',sortable: false,value: 'client.username', width:'20%'},
            //     { text: 'Added On', value: 'created_at', width:'20%' },
            //     { text: 'Actions', value: 'actions', sortable: false, width:'10%' ,align: 'center'},

            // ],
        }
    },

    computed: {
        headers(){
            return [
                { text: ' ', value: 'checkbox', sortable: false, width:'5%',align: 'center'},
                { text: this.$t('approved_items.item_name'),width:'20%', value: 'title' },
                { text: this.$t('approved_items.category'), value: 'category.name', width:'20%' },
                { text: this.$t('approved_items.price'), value: 'price', width:'10%' },
                { text: this.$t('approved_items.seller_username'),align: 'start',sortable: false,value: 'client.username', width:'20%'},
                { text: this.$t('approved_items.added_on'), value: 'created_at', width:'10%' },
                { text: 'Actions', value: 'actions', sortable: false, width:'80%',align: 'center'},
            
            ]
        }
    },
    //  watch: {
    //     "item.pending": function () {
    //         if (this.item.pending==false) {
    //             this.selected_item.push(item);
    //         }
    //     }
    // },
    methods:{
     
        //  flush() {
        //      this.selected_item.splice(0);
        // },
       
        build(){
            GetToApprovedItems().then(({data}) => {
                console.log(data, 'test')
                this.items = data
            })
        },
        disapproved_close() {
            this.dialog = false
            this.build();
        },
        disapproved(item){
            this.selected_item = item
            this.$nextTick(() => {
                this.dialog = true
            })
        },

        // checked(item){
        //     this.selected_item.push(item.id);
        //     console.log(this.selected_item.id)
        // },


        approved(item){
            this.progress_circular = true;
            let payload = this.item;
            ApproveMail(item).then((response) => {
                    console.log(response)

                this.progress_circular = false;
                ApprovedItem(item.id).then( response => {
                    this.build()
                    alert('Message Sent Successful');
                    this.approved_sms(item)
                }).catch((error)=>{
                    console.log(error)
                })
            });
        },
        approved_sms(item){
             let payload = {
                number: item.client.mobile,
                id: item.id
            }
            axios.post('api/sms_sender/', payload).then((response)=>{
                console.log(response.data , 'chan')
            })
        },
        open_info(item){
            this.drawer = true
            this.selected_data = item
            console.log(item , 'sad')
        },

        updatechecked(){
            // console.log(this.test)
            axios.post('bulkapprove', this.test).then(res=>{
                console.log(res)
                 this.build();
              
            })
        }
    },
    created(){
        this.build();
    },
    
}
</script>
<style scoped>

</style>


