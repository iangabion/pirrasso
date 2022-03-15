<template>
    <div>
        <v-toolbar>

            <v-toolbar-title class="ml-3">{{$t('seller.show.seller_info')}}</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn
                color="primary"
                @click="$router.go(-1)"
                class="mr-2"
            >
                <v-icon
                    left
                >
                    mdi-backspace
                </v-icon>
                {{$t('seller.show.back')}}
            </v-btn>
        </v-toolbar>
        <div>
            <v-container>
                <v-row>
                    <v-col cols="3">
                        <sellerInfo
                            :client="client"
                        />
                    </v-col>
                     <v-col cols="9">
                        <sellerItems
                            v-if="client.items ? client.items.length : ''"
                            :items="client.items ? client.items : []"
                            @reload="getClientInfo()"
                        />
                        <!-- <sellerFavs
                            v-if="client.items_fav ? client.items_fav.length : ''"
                            :items="client.items_fav ? client.items_fav : []"
                            @reload="getClientInfo()"
                        /> -->
                       
                        <v-card
                            height="680px"
                            style="overflow-y:scroll;"
                            v-else
                        >
                            <emptyItem/>
                        </v-card>
                    </v-col>
                    
                </v-row>
            </v-container>
        </div>
    </div>
</template>
<script>
import { GetClient } from "@api/client.api";
import sellerInfo from "./sellerInfo";
import emptyItem from "@/components/error/emptyItems"
import sellerItems from "./sellerItems";
import sellerFavs from "./sellerItems";

export default {
    components: {
        sellerInfo,
        sellerItems,
        emptyItem,
        sellerFavs
    },
    data(){
        return {
            client:{}
        }
    },
    computed : {
    },
    methods: {
        getClientInfo(){
            GetClient(this.$route.params.id).then(({data}) =>{
                console.log(data , 'sad')
                this.client = data
            })
        }
    },
    created(){
        this.getClientInfo()
    }

}
</script>
