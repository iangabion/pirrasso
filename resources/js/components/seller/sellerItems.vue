<template>
    <div>

        <productInfo
            v-if="drawer"
            :drawer="drawer"
            :item="selected_item"
            @collapse-drawer="drawer = !drawer"
            @close="close()"
        />

         <soldInfo
            v-if="drawer2"
            :drawer="drawer2"
            :item="selected_item"
            @collapse-drawer="drawer2 = !drawer2"
            @close="close2()"
        />
         <!-- <soldInfo
            v-if="drawer"
            :drawer="drawer"
            :item="selected_item"
            @collapse-drawer="drawer = !drawer"
            @close="close()"
        /> -->
        <v-card
            height="680px"
            style="overflow-y:scroll;"
        >

            <v-toolbar dense flat
                style="position:sticky; top:0; z-index:1;"
            >
                <v-toolbar-title>
                    {{$t('seller.selleritems.item_details')}}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                    @click="change_active('items')"
                    :outlined="!check_active('items')"
                    :color="check_active('items') ? 'error' : 'primary'"
                    small
                    class=" my-2 ml-2"
                   
                >
                    <v-icon
                        left
                        class="mr-3"
                        
                    > mdi-cart</v-icon>
                    {{$t('seller.selleritems.items')}}
                </v-btn>
                <!-- <v-btn
                    @click="change_active('sold')"
                    :outlined="!check_active('sold')"
                    :color="check_active('sold') ? 'error' : 'primary'"
                    small
                    class=" my-2 ml-2"
                >
                    <v-icon
                        left
                        class="mr-3"
                    > mdi-heart</v-icon>
                    {{$t('seller.selleritems.sold')}}
                </v-btn> -->
                <!-- <v-btn
                    @click="e1 = 1"
                    :outlined="!check_active('items')"
                    :color="check_active('items') ? 'error' : 'primary'"
                    small
                    class=" my-2 ml-2"
                   
                >
                    <v-icon
                        left
                        class="mr-3"
                        
                    > mdi-cart</v-icon>
                    {{$t('seller.selleritems.items')}}
                </v-btn> -->
                <!-- <v-btn
                    @click="e1 = 2"
                    :outlined="!check_active('items_fav')"
                    :color="check_active('items_fav') ? 'error' : 'primary'"
                    small
                    class=" my-2 ml-2"
                >
                    <v-icon
                        left
                        class="mr-3"
                    > mdi-heart</v-icon>
                    {{$t('seller.selleritems.cart')}}
                </v-btn> -->

                 <v-btn
                    @click="change_active('solds')"
                    :outlined="!check_active('solds')"
                    :color="check_active('solds') ? 'error' : 'primary'"
                    small
                    class=" my-2 ml-2"
                >
                    <v-icon
                        left
                        class="mr-3"
                    > mdi-coin</v-icon>
                    <!-- {{$t('seller.selleritems.cart')}} -->
                    solds
                </v-btn>
                <v-btn
                    @click="change_active('items_fav')"
                    :outlined="!check_active('items_fav')"
                    :color="check_active('items_fav') ? 'error' : 'primary'"
                    small
                    class=" my-2 ml-2"
                >
                    <v-icon
                        left
                        class="mr-3"
                    > mdi-heart</v-icon>
                    {{$t('seller.selleritems.cart')}}
                </v-btn>
            </v-toolbar>
            <v-divider></v-divider>
            <div v-if="category_selected === 'items'">
            <!-- <v-stepper v-model="e1"> -->
                <!-- <v-stepper-items> -->
                    <!-- <v-stepper-content step="1"> -->
                        <v-container>
                            <v-row>
                                <v-col
                                    v-for="item in items" :key="item.id"
                        image          cols="2"
                                >
                                    <v-hover v-slot="{ hover }">
                                        <v-card>
                                            <v-img
                                                :src="item.photos.length ? item.photos[0].filename :  'https://images.unsplash.com/photo-1528148343865-51218c4a13e6?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'"
                                                class="white--text align-end"
                                                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                                height="100px"
                                            >
                                                <v-expand-transition>
                                                    <div
                                                        v-if="hover"
                                                        class="d-flex transition-fast-in-fast-out white darken-2 v-card--reveal black--text"
                                                        style="height: 100px; opacity:0.8;"
                                                    >
                                                        <v-btn
                                                            class="view-btn"
                                                            rounded color="primary"
                                                            @click="open_info(item)"
                                                        >
                                                            <v-icon color="white">
                                                                mdi-eye
                                                            </v-icon>
                                                        </v-btn>
                                                    </div>
                                                </v-expand-transition>
                                            </v-img>
                                            <div
                                                class="item-style"
                                            >
                                                {{item.title}}

                                                
                                            </div>
                                        </v-card>
                                    </v-hover>
                                </v-col>
                            </v-row>
                        </v-container>
                    <!-- </v-stepper-content> -->
                </div>
                <div v-else-if="category_selected === 'solds'"> 
                    <!-- <v-stepper-content step="2"> -->
                        <v-container>
                            <v-row>
                                <v-col
                                    v-for="item in solds" :key="item.id"
                        image          cols="2"
                                >
                                    <v-hover v-slot="{ hover }">
                                        <v-card>
                                            <v-img
                                                :src="item.item.photos.length ? item.item.photos[0].filename :  'https://images.unsplash.com/photo-1528148343865-51218c4a13e6?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'"
                                                class="white--text align-end"
                                                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                                height="100px"
                                            >
                                                <v-expand-transition>
                                                    <div
                                                        v-if="hover"
                                                        class="d-flex transition-fast-in-fast-out white darken-2 v-card--reveal black--text"
                                                        style="height: 100px; opacity:0.8;"
                                                    >
                                                        <v-btn
                                                            class="view-btn"
                                                            rounded color="primary"
                                                            @click="open_info2(item)"
                                                        >
                                                            <v-icon color="white">
                                                                mdi-eye
                                                            </v-icon>
                                                        </v-btn>
                                                    </div>
                                                </v-expand-transition>
                                            </v-img>
                                            <!-- {{item.seller_id}}
                                            {{item.status_id}}
                                            {{item.buyer_id}}
                                            {{item.quantity}} -->
                                            <div
                                                class="item-style"
                                            >
                                           {{item.item.title}}
                                            </div>
                                        
                                           
                                        </v-card>
                                    </v-hover>
                                </v-col>
                            </v-row>
                        </v-container>
                    <!-- </v-stepper-content> -->
               </div>
                        <div v-else>
                        <v-container>
                            <v-row>
                                <v-col
                                    v-for="item in items_fav" :key="item.id"
                        image          cols="2"
                                >
                                    <v-hover v-slot="{ hover }">
                                        <v-card>
                                            <v-img
                                                :src="item.photos.length ? item.photos[0].filename :  'https://images.unsplash.com/photo-1528148343865-51218c4a13e6?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'"
                                                class="white--text align-end"
                                                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                                height="100px"
                                            >
                                                <v-expand-transition>
                                                    <div
                                                        v-if="hover"
                                                        class="d-flex transition-fast-in-fast-out white darken-2 v-card--reveal black--text"
                                                        style="height: 100px; opacity:0.8;"
                                                    >
                                                        <v-btn
                                                            class="view-btn"
                                                            rounded color="primary"
                                                            @click="open_info(item)"
                                                        >
                                                            <v-icon color="white">
                                                                mdi-eye
                                                            </v-icon>
                                                        </v-btn>
                                                    </div>
                                                </v-expand-transition>
                                            </v-img>
                                            <div
                                                class="item-style"
                                            >
                                                {{item.title}}
                                            </div>
                                        </v-card>
                                    </v-hover>
                                </v-col>
                            </v-row>
                        </v-container>
                        </div>
                <!-- </v-stepper-items> -->
            <!-- </v-stepper> -->

             
        </v-card>
    </div>
</template>
<script>
import productInfo from "./productInfo"
import soldInfo from "./soldInfo"
// import soldInfo from "./soldInfo"
import sellerInfo from "./sellerInfo";

export default {
    components : {
        productInfo,
        soldInfo
    },
    props : {
        'items' : {
            type : Array,
            required : true,
        },

        'items_fav' : {
            type : Array,
            required : false,
        },

        'solds' : {
            type : Array,
            required : false,
        },

        

    },
    data(){
        return {
            drawer: false,
            drawer2: false,
            selected_item: {},
            category_selected:'items',
             e1: 1,
        }
    },
    methods: {
        close(){
            this.drawer = false
            // this.open_info(item);
            this.$emit('reload');
        },
        close2(){
            this.drawer2 = false
            // this.open_info(item);
            this.$emit('reload');
        },
        open_info(item){
            this.drawer = true
            this.selected_item = item
            console.log(item , 'sad')
        },
        open_info2(item){
            this.drawer2 = true
            this.selected_item = item
            console.log(item , 'sad')
        },
        change_active(name){
            this.category_selected = name
        },
        check_active(name){
            return this.category_selected == name
        }
    },
    created(){
        console.log(this.items , 'sadsdasdas')
    }
}
</script>
<style scoped>
 .item-style {
    font-weight: bold;
    padding: 10px;
    font-size: 15px;
    white-space: nowrap;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
 }
 .view-btn {
    margin: auto;
    padding: 10px;
 }
</style>
