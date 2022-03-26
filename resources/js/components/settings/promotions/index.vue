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
                                            <v-toolbar-title>{{$t('settings.promotions.pending_promotions')}}</v-toolbar-title>
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
                                            {{$t('settings.promotions.approved_promotions')}}
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
                                            <v-toolbar-title>{{$t('settings.promotions.approved_promotions')}}</v-toolbar-title>
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
                                            {{$t('settings.promotions.pending_promotions')}}
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
            transition="dialog-top-transition"
            max-width="600"
            >
            <v-card
            width="600"
            >
            <v-toolbar
              color="#FF5722"
              dark
            >Promotion Approval</v-toolbar>
             <v-card-text>
                <h2 style="text-align: center;">{{$t('settings.promotions.confirm_approve')}}?</h2>             
              <br>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                    @click="approveConfirm"
                    text
                    plain
                    >
                        {{$t('settings.promotions.approve')}}
                    </v-btn> 
                    <v-btn
                    @click="dialog=false"
                     color="error"
                    plain
                    text
                    >
                        {{$t('settings.promotions.cancel')}}
                    </v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            
             
                <p style="display:none;">{{this.editedItem.id}}</p>
             </v-card-text>
            </v-card>
   
            </v-dialog>
            <v-dialog
            v-model="dialogremove"
            transition="dialog-top-transition"
            max-width="600"
            >
            <v-card
            width="600"
            >
            <v-toolbar
              color="#FF5722"
              dark
            >Promotion Remove</v-toolbar>
            <v-card-text>
                <h2 style="text-align: center">{{$t('settings.promotions.confirm_remove')}}?</h2>     
                <br>
                <v-card-actions>
                    <v-spacer></v-spacer>
                        <v-btn
                        plain
                        text
                        @click="removeConfirm"
                        
                        >
                            {{$t('settings.promotions.remove')}}
                        </v-btn> 
                        <v-btn
                        color="error"
                        plain
                        text
                        @click="dialogremove=false"
                        >
                            {{$t('settings.promotions.cancel')}}
                        </v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
                
                
                    <p style="display:none;">{{this.editedItem.id}}</p>
            </v-card-text>
            </v-card>
   
            </v-dialog>
        </div>
  
</template>
<script>
// import { getPromotion } from "../../../repositories/promotion.api";
export default {
    data(){
        return {
            e1: 1,
            // headers:[
            //          { text: '', align: 'start', value: 'image', width: '10%'},
            //         { text: 'Title', align: 'start', value: 'title', width: '10%'},
            //         { text: 'Link', align: 'start', value: 'link', width: '15%'},
            //         { text: 'Action', align: 'start', value: 'actions', sortable: false,   width: '10%'},
            // ],
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

    computed: {
        headers(){
            return [
                { text: '', align: 'start', value: 'image', width: '10%'},
                { text: this.$t('settings.promotions.title'), align: 'start', value: 'title', width: '10%'},
                { text: this.$t('settings.promotions.link'), align: 'start', value: '10%', width: '15%'},
                { text: 'Action', align: 'start', value: 'actions', sortable: false,   width: '10%'},
            ]
        },
        headersApproved(){
            return [
                { text: '', align: 'start', value: 'image', width: '10%'},
                { text: this.$t('settings.promotion.title'), align: 'start', value: 'title', width: '10%'},
                { text: this.$t('settings.promotions.link'), align: 'start', value: '10%', width: '15%'},
                { text: 'Action', align: 'start', value: 'actions', sortable: false,   width: '10%'},
            ]
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
                this.dialog = false
                this.getPendingPromotion();
                this.getPromotions();
                 
            })
        },
        removeConfirm(){
            axios.delete('remove/'+ this.editedItem.id, this.editedItem).then((res)=> {
                console.log(res)
                this.getPromotions()
                this.dialogremove = false
               this.getPendingPromotion();
                this.getPromotions();
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