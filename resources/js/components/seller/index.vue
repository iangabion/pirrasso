<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">{{$t('seller.index.seller_list')}}</v-toolbar-title>
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
                />
            </div>
            <!-- <v-btn
                @click="addSeller()"
            >
                <v-icon>
                    mdi-database-plus
                </v-icon>
                Add
            </v-btn> -->
        </v-toolbar>
        <AddSeller
            :dialog="dialog"
             @close="dialog=false"
        ></AddSeller>
        <v-container grid-list-xs>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card>
                        <v-data-table
                            :headers="headers"
                            :items="clients"
                        >
                            <template v-slot:item.fullname="{ item }">
                                {{item.full_name}}
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="showClient(item)"
                                >
                                    mdi-account-cog
                                </v-icon>
                                <v-icon
                                    small
                                    @click="deleteSeller(item)"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                           <template v-slot:no-data>
                            {{$t('settings.smtp.no_data_found')}}
                            </template>
                        </v-data-table>
                    </v-card>
                </v-flex>
            </v-layout>
            <AddSeller
                :dialog="dialog2"
            ></AddSeller>
        </v-container>
    </div>
</template>
<script>
import AddSeller from './add_seller.vue'
import { GetAllClients, DeleteClient, FetchAllClient } from "@api/client.api";
export default {
    components :{
        AddSeller
    },
    data() {
        return {
            dialog:false,
             dialog2:false,
            itemsPerPage: null,
            current_page: 1,
            pageCount: 0,
            page: 1,
            url: '',
            pageCount: 0,
            itemsPerPage: 10,
            total_client: 0,
            clients: [],
            form: {
                search: ''
            },
            searchQuery: null,
            // headers: [
            //         { text: 'Full Name',width:'20%', value: 'full_name' },
            //         { text: 'Mobile', value: 'mobile', width:'20%' },
            //         { text: 'Total Items', value: 'total_items', width:'10%' },
            //         { text: 'Username',align: 'start',sortable: false,value: 'username', width:'20%'},
            //         { text: 'Email', value: 'email', width:'20%' },
            //         { text: 'Actions', value: 'actions', sortable: false, width:'10%' },

            //     ],
        }
    },
    computed : {
         prefill(){
            return this.form.search = this.$route.query.item;
        },
        // filteredClient(){
        //     if(this.search){
        //         return this.clients.filter(client => {
        //             console.log(client.social_id,"search")
        //             if(client.username&&client.email){
        //                 return client.username.toLowerCase().includes(this.search.toLowerCase()) ||
        //                     client.email.toLowerCase().includes(this.search.toLowerCase())
        //             }
        //                 return client.social_id.includes(this.search.toLowerCase())

        //         })
        //     }
        //     return this.clients
        // }
        headers(){
            return [
                { text: this.$t('seller.index.full_name'), width: '20%', value: 'full_name'},
                { text: this.$t('seller.index.mobile'), width:'20%', value: 'mobile'},
                { text: this.$t('seller.index.total_items'), value: 'total_items', width: '10%'},
                { text: this.$t('seller.index.user_name'), value: 'user_name', value: 'username', width:'20%'},
                {text: this.$t('seller.index.email'), value: 'email', width: '20%'},
                { text: 'Actions', value: 'actions', sortable: false, width:'10%' },
            ]
        }
    },
    mounted() {
        this.search();
    },
    methods:  {
        // fetchClientsData(page) {
        //     this.current_page = page.page
        //     this.indexSeller()
        // },
        // set_data_fromServer(data) {
        //     this.clients = data.data
        //     this.total_client = data.total
        //     this.itemsPerPage = data.per_page
        //     this.pageCount = data.last_page
        // },

        // indexSeller() {
        // this.url = 'client/pagination?page='+this.current_page+ '&keyword=' +this.search

        // if (this.timer) {
        //   clearTimeout(this.timer);
        //   this.timer = null;
        // }
        // this.timer = setTimeout(() => {
        //   GetAllClients(this.url).then(({data}) => {
        //     this.clients = data.data
        //     this.total_client = data.total
        //     this.itemsPerPage = data.per_page
        //     this.pageCount = data.last_page

        //     })
        //     }, 800);
        // },

        showClient(item) {
           this.$router.push({name: 'view_client', params: { id: item.id },})
        },
        // indexSeller() {
        //     GetAllClients().then(({data}) => {
        //         this.clients = data
        //         console.log(data, 'test')
        //     })
        // },

        search(key) {
            this.loading = true
            let payload = {
                searchkey:key
            }
            console.log(payload)
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                FetchAllClient(payload).then((response) => {
                    console.log(response.data,"seller")
                    this.clients = response.data
                    this.loading = false
                }).catch((errors) => {
                    console.log(errors)
                });
            },800);
        },
        deleteSeller(item) {
            this.$root.$confirm('Are you sure you want to delete ?')
            .then((result) => {
                if(result) {
                    DeleteClient(item.id).then(({data}) => {
                       this.$arraysplicer(item,this.clients)
                    })
                }
            })
        },
        addSeller(){
            this.$nextTick(() => {
                this.dialog = true
            })
        },
    },
    // created() {
    //     this.indexSeller()
    // },
    watch: {
        "form.search": {
            handler(val) {
                this.search(val)
            },
        deep: true,
    },
    //      "search": {
    //         handler(val) {
    //         this.page = 1
    //         this.indexSeller(val)
    //     },
    //     deep: true,
    //   },
    }
}
</script>
<style scoped>
.truncate {
    width: 97%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}


tbody tr:nth-of-type(odd) {
   background-color: rgba(0, 0, 0, .05);
 }



</style>
