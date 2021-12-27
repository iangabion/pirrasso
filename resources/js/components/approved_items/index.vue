<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4 text-capitalize">To be approved items</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <disapprovedDialog
            :dialog="dialog"
            @closedisapproved="disapproved_close"
            :item="selected_item"
            @close="dialog=false"
        ></disapprovedDialog>
        <v-container grid-list-xs>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card>
                        <v-data-table
                            :headers="headers"
                            :items="items"

                        >
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
                                            @click="approved(item)"
                                            color="primary"
                                        >
                                            <v-icon dark small>
                                                mdi-check
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span>approve</span>
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
                                    <span>disapprove</span>
                                </v-tooltip>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>
<script>
import disapprovedDialog from './includes/disapproved_dialog.vue'
import { GetToApprovedItems, ApprovedItem } from "@api/item.api";
export default {
    components : {
        disapprovedDialog
    },
    data(){
        return{
            items:[],
            dialog:false,
            selected_item:{},
            headers: [
                { text: 'Item Name',width:'20%', value: 'title' },
                { text: 'Category', value: 'category.name', width:'20%' },
                { text: 'Price', value: 'price', width:'10%' },
                { text: 'Seller Username',align: 'start',sortable: false,value: 'client.username', width:'20%'},
                { text: 'Added On', value: 'created_at', width:'20%' },
                { text: 'Actions', value: 'actions', sortable: false, width:'10%' ,align: 'center'},
            ],
        }
    },
    methods:{
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
        approved(item){
            ApprovedItem(item.id).then(() => {
                this.build()
                alert('item approved!')
            })
            let payload ={
                number: item.mobile
            }
            axios.post('api/sms_sender/', payload).then((response)=>{
                console.log(response)
            })
        }
    },
    created(){
        this.build();
    }
}
</script>
