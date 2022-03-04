<template>
    <div>
       <v-toolbar>
            <v-toolbar-title class="px-4">Promotions</v-toolbar-title>
            <v-spacer></v-spacer>
            <div class="search1">
                <v-text-field
                hide-details
                placeholder="Search"
               
                filled
                rounded
                dense
                single-line
                append-icon="mdi-magnify" class=" mx-4"
                />
            </div>
            
        </v-toolbar>
        <div>
            <v-data-table
                :headers="headers"
                :items="promotions"
              
                hide-default-footer
                class="elevation-1"
            >
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
            </v-data-table>
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
            headers:[
             
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
            dialogremove:false
        }
    },

    mounted(){
        this.getPromotions();
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
            })
        },
        removeConfirm(){
            axios.delete('remove/'+ this.editedItem.id, this.editedItem).then((res)=> {
                console.log(res)
                this.getPromotions()
                this.dialogremove = false
            })
        },
        remove(item){
            this.editedIndex = this.promotions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogremove = true
        },


    }
}
</script>