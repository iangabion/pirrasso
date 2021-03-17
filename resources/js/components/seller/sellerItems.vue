<template>
    <div>

        <productInfo
            :drawer="drawer"
            :item="selected_item"
            @collapse-drawer="drawer = !drawer"
        />
        <v-card
            height="680px"
            style="overflow-y:scroll;"
        >

            <v-toolbar dense flat
                style="position:sticky; top:0; z-index:1;"
            >
                <v-toolbar-title>
                    Items Details
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
                    > mdi-heart</v-icon>
                    Items
                </v-btn>
                <v-btn
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
                    Sold
                </v-btn>
                <v-btn
                    @click="change_active('cart')"
                    :outlined="!check_active('cart')"
                    :color="check_active('cart') ? 'error' : 'primary'"
                    small
                    class=" my-2 ml-2"
                >
                    <v-icon
                        left
                        class="mr-3"
                    > mdi-heart</v-icon>
                    Cart
                </v-btn>
            </v-toolbar>
            <v-divider></v-divider>
            <div v-if="category_selected === 'items'">
                <v-container>
                    <v-row>
                        <v-col
                            v-for="item in items" :key="item.id"
                  image          cols="2"
                        >
                            <v-hover v-slot="{ hover }">
                                <v-card>
                                    <v-img
                                        :src="item.photos[0] ? item.photos[0].link :  'https://images.unsplash.com/photo-1528148343865-51218c4a13e6?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'"
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
        </v-card>
    </div>
</template>
<script>
import productInfo from "./productInfo"
import sellerInfo from "./sellerInfo";

export default {
    components : {
        productInfo
    },
    props : {
        'items' : {
            type : Array,
            required : true,
        }
    },
    data(){
        return {
            drawer: false,
            selected_item: {},
            category_selected:'items'
        }
    },
    methods: {
        open_info(item){
            this.drawer = true
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
