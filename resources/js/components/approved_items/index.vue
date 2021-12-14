<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4 text-capitalize">{{$t('approved_items.to_be_approved_items')}}</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <disapprovedDialog
            :dialog="dialog"
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
                                    <span>{{$t('approved_items.disapprove')}}</span>
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
                { text: this.$t('approved_items.item_name'),width:'20%', value: 'title' },
                { text: this.$t('approved_items.category'), value: 'category.name', width:'20%' },
                { text: this.$t('approved_items.price'), value: 'price', width:'10%' },
                { text: this.$t('approved_items.seller_username'),align: 'start',sortable: false,value: 'client.username', width:'20%'},
                { text: this.$t('approved_items.added_on'), value: 'created_at', width:'20%' },
                { text: 'Actions', value: 'actions', sortable: false, width:'10%' ,align: 'center'},
            ]
        }
    },
    methods:{
        build(){
            GetToApprovedItems().then(({data}) => {
                console.log(data, 'test')
                this.items = data
            })
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
        }
    },
    created(){
        this.build();
    }
}
</script>
