<template>
    <div>
       <v-toolbar>
            <v-toolbar-title class="px-4">Promotions</v-toolbar-title>
            <v-spacer></v-spacer>
          
            
        </v-toolbar>
        <v-stepper v-model="e1"
           
            max-height="500"
        >
            <v-stepper-items>
                 <v-stepper-content step="1">
                    
                     

                        <v-container grid-list-xs >
                            <v-layout row wrap>
                                <v-flex xs12 >
                                    <v-card>
                                        <v-data-table
                                            :headers="headers"
                                            :items="pendingPromo"
                                            hide-default-footer
                                            class="elevation-1 scroll"
                                        
                                        >
                                        <template v-slot:top>
                                        <v-toolbar
                                            flat
                                        >
                                            <v-toolbar-title>Pending Promotions</v-toolbar-title>
                                            <v-divider
                                            class="mx-4"
                                            inset
                                            vertical
                                            ></v-divider>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                            color="primary"
                                            @click="e1 = 2"
                                            
                                            >
                                            Approved Promotions
                                            </v-btn>
                                        </v-toolbar>
                                        </template>
                                        <template v-slot:item.actions="{ item }">
                                            <v-icon
                                                small
                                                class="mr-2"
                                                @click="approve(item)"
                                            >
                                            mdi-check-bold
                                            </v-icon>
                                            <v-icon
                                                small
                                            @click="remove(item)"
                                            >
                                                mdi-delete
                                            </v-icon>
                                            </template>
                                            <template v-slot:item.image="{ item }">
                                                <v-avatar
                                                    tile
                                                    size="100px"
                                                    class="my-2"
                                                >
                                                    <v-img
                                                        :alt="item.image"
                                                        max-height="150"
                                                        max-width="250"
                                                        :src="item.image.length ? item.image : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg'"
                                                    ></v-img>
                                                </v-avatar>
                                            </template>
                                        </v-data-table>
                                        
                                        
                                    </v-card>
                                </v-flex>
                            </v-layout>
                           

                        </v-container>

                    
                       

                   
                 </v-stepper-content>
                <v-stepper-content step="2">
                    
                     <v-container grid-list-xs>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-card>
                                    <v-data-table
                                        :headers="headersApproved"
                                        :items="promotions"
                                       
                                        hide-default-footer
                                        class="elevation-1 scroll"
                                    >
                                       
                                     <template v-slot:top>
                                     <v-toolbar
                                            flat
                                        >
                                            <v-toolbar-title>Approved Promotions</v-toolbar-title>
                                            <v-divider
                                            class="mx-4"
                                            inset
                                            vertical
                                            ></v-divider>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                            color="primary"
                                            @click="e1 = 1"
                                            
                                            >
                                            Pending Promotions
                                            </v-btn>
                                        </v-toolbar>
                                        </template>
                                    <template v-slot:item.actions="{ item }">
                                        
                                        <v-icon
                                            small
                                        @click="remove(item)"
                                        >
                                            mdi-delete
                                        </v-icon>
                                        </template>
                                        <template v-slot:item.image="{ item }">
                                                <v-avatar
                                                    tile
                                                    size="100px"
                                                    class="my-2"
                                                >
                                                    <v-img
                                                        :alt="item.image"
                                                        max-height="150"
                                                        max-width="250"
                                                        :src="item.image.length ? item.image : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg'"
                                                    ></v-img>
                                                </v-avatar>
                                            </template>
                                    </v-data-table>
                                   
                                </v-card>
                            </v-flex>
                        </v-layout>
                       
                          
                            
                          
                    </v-container>
                     
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
            <v-dialog
            v-model="dialog"
              width="400"
            >
            <v-card
            width="400"
            >
                <h2 style="padding-left: 4.3em;">Confirm Approve?</h2>             
              
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                    @click="approveConfirm"
                    >
                        Approve
                    </v-btn> 
                    <v-btn
                    @click="dialog=false"
                    style="background-color: red; color: white;"
                    >
                        Cancel
                    </v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            
             
                <p style="display:none;">{{this.editedItem.id}}</p>
            </v-card>
   
            </v-dialog>
            <v-dialog
            v-model="dialogremove"
              width="400"
            >
            <v-card
            width="400"
            >
             <h2 style="padding-left: 4.3em;">Confirm Remove?</h2>     
            
             <v-card-actions>
                  <v-spacer></v-spacer>
                    <v-btn
                    @click="removeConfirm"
                    >
                        Remove
                    </v-btn> 
                    <v-btn
                    style="background-color: red; color: white;"
                    @click="dialogremove=false"
                    >
                        Cancel
                    </v-btn>
                 <v-spacer></v-spacer>
             </v-card-actions>
             
             
                 <p style="display:none;">{{this.editedItem.id}}</p>
            </v-card>
   
            </v-dialog>
        </div>
    </div>
</template>
<script>
// import { getPromotion } from "../../../repositories/promotion.api";
export default {
    data(){
        return {
            e1: 1,
            headers:[
                     { text: '', align: 'start', value: 'image', width: '10%'},
                    { text: 'Title', align: 'start', value: 'title', width: '10%'},
                    { text: 'Link', align: 'start', value: 'link', width: '15%'},
                    { text: 'Action', align: 'start', value: 'actions', sortable: false,   width: '10%'},
            ],
            headersApproved:[
             
                     { text: '', align: 'start', value: 'image', width: '10%'},
                    { text: 'Title', align: 'start', value: 'title', width: '10%'},
                    { text: 'Link', align: 'start', value: 'link', width: '15%'},
                    { text: 'Action', align: 'start', value: 'actions', sortable: false,   width: '10%'},
            ],
            promotions: [],

            editedIndex: -1,
            editedItem: {
                id: '',
            },
            dialog:false,
            dialogremove:false,
            pendingPromo: []
        }
    },

    mounted(){
        this.getPromotions();
        this.getPendingPromotion();
    },
    methods: {
        getPromotions(){
            axios.get('indexPromotion').then((res) => {
                this.promotions = res.data
                console.log(res)
            })
        },
        approve(item){
            this.editedIndex = this.promotions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        approveConfirm(){
            axios.put('approve/'+ this.editedItem.id, this.editedItem).then((res)=> {
                console.log(res)
                this.getPromotions();
                this.dialog = false
                this.getPromotions();
                this.getApprovedPromotion();
            })
        },
        removeConfirm(){
            axios.delete('remove/'+ this.editedItem.id, this.editedItem).then((res)=> {
                console.log(res)
                this.getPromotions()
                this.dialogremove = false
                this.getPromotions();
                this.getApprovedPromotion();
            })
        },
        remove(item){
            this.editedIndex = this.promotions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogremove = true
        },
        getPendingPromotion(){
            axios.get('pendingPromotion').then(res =>{
                this.pendingPromo = res.data 
                console.log(res)
              
            } )
        }


    }
}
</script>
<style scoped>
.scroll {
        overflow-y: scroll hidden;
        
    }
</style>