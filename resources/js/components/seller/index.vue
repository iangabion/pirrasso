<template>
    <!-- <v-container>
        <v-toolbar>
            <v-toolbar-title class="ml-3">Seller</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-row>
                <v-col cols="6">

                </v-col>
                <v-col cols="6">
                    <v-text-field
                        placeholder="Search"
                        dense
                        rounded
                        v-model="search"
                        filled
                        append-icon="mdi-magnify"
                        hide-details
                    >

                    </v-text-field>
                </v-col>
            </v-row>

        </v-toolbar>

        <v-data-table
            :headers="headers"
            :items="clients"

        >
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
        </v-data-table>

    </v-container> -->
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Seller List</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-container grid-list-xs>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card>
                        <v-data-table
                            :headers="headers"
                            :items="clients"

                        >
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
                        </v-data-table>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>
<script>
import { GetAllClients, DeleteClient } from "@api/client.api";
export default {
    data() {
        return {
            itemsPerPage: null,
            current_page: 1,
            pageCount: 0,
            page: 1,
            url: '',
            pageCount: 0,
            itemsPerPage: 10,
            total_client: 0,
            clients: [],
            search: '',
             headers: [
                    { text: 'Full Name',width:'20%', value: 'fullname' },
                    { text: 'Mobile', value: 'mobile', width:'20%' },
                    { text: 'Total Items', value: 'total_items', width:'10%' },
                    { text: 'Username',align: 'start',sortable: false,value: 'username', width:'20%'},
                    { text: 'Email', value: 'email', width:'20%' },
                    { text: 'Actions', value: 'actions', sortable: false, width:'10%' },

                ],
        }
    },
    computed : {
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
    },
    methods:  {
        fetchClientsData(page) {
            this.current_page = page.page
            this.indexSeller()
        },
        // set_data_fromServer(data) {
        //     this.clients = data.data
        //     this.total_client = data.total
        //     this.itemsPerPage = data.per_page
        //     this.pageCount = data.last_page
        // },

        indexSeller() {
        this.url = 'client/pagination?page='+this.current_page+ '&keyword=' +this.search

        if (this.timer) {
          clearTimeout(this.timer);
          this.timer = null;
        }
        this.timer = setTimeout(() => {
          GetAllClients(this.url).then(({data}) => {
            this.clients = data.data
            // this.total_client = data.total
            // this.itemsPerPage = data.per_page
            // this.pageCount = data.last_page

            })
            }, 800);
        },

        showClient(item) {
           this.$router.push({name: 'view_client', params: { id: item.id },})
        },
        indexSeller() {
            GetAllClients().then(({data}) => {
                this.clients = data
                console.log(data, 'test')
            })
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
        }
    },
    created() {
        this.indexSeller()
    },
    watch: {
         "search": {
            handler(val) {
            this.page = 1
            this.indexSeller(val)
        },
        deep: true,
      },
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
</style>
