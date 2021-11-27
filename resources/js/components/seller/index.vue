<template>
    <div>
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
        <div class="text-center pt-2">
        <!-- <v-pagination
          v-model="page"
          color="primary"
          :total-visible="7"
          :length="pageCount"
        ></v-pagination> -->
      </div>
         

        <!-- <v-container>
            <v-row>
                <v-col
                    v-for="(item) in filteredClient"
                    :key="item.id"
                    cols="3"
                >
                    <v-card
                        color="dark"
                        dark
                    >
                        <div class="d-flex flex-no-wrap justify-space-between">
                        <div class="truncate">
                            <v-card-title
                                class="headline text-capitalize "
                            >
                                {{item.username || item.social_id}}
                            </v-card-title>

                            <v-card-subtitle > {{item.email}}</v-card-subtitle>

                            <v-card-actions>
                                <v-btn
                                    class="ml-2 mt-3"
                                    fab
                                    color="primary"
                                    height="40px"
                                    right
                                    @click="showClient(item)"
                                    width="40px"
                                >
                                    <v-icon small>mdi-account-cog</v-icon>
                                </v-btn>
                                <v-btn
                                    class="ml-2 mt-3"
                                    fab
                                    color="green"
                                    height="40px"
                                    right
                                    @click="showClient(item)"
                                    width="40px"
                                >
                                    <v-icon small>mdi-check-circle</v-icon>
                                </v-btn>
                                 <v-btn
                                    class="ml-2 mt-3"
                                    color="error"
                                    fab
                                    height="40px"
                                    right
                                    @click="deleteSeller(item)"
                                    width="40px"
                                >
                                    <v-icon small>mdi-delete</v-icon>
                                </v-btn>
                                

                            </v-card-actions>
                        </div>

                        <v-avatar
                            class="ma-3"
                            size="125"
                            tile
                        >
                            <v-img :src="item.profile_pic"></v-img>
                        </v-avatar>
                        </div>
                    </v-card>
                </v-col>
            </v-row>
        </v-container> -->

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
                    { text: 'Username',align: 'start',sortable: false,value: 'username',},
                    { text: 'Social ID', value: 'social_id' },
                    { text: 'Email', value: 'email' },
                    { text: 'Actions', value: 'actions', sortable: false },
                   
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
