<template>
    <div>
        <v-toolbar>

            <v-toolbar-title class="ml-3">Seller Info</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-heart</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
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
                            :items="client.items ? client.items : []"
                        />
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </div>
</template>
<script>
import { GetClient } from "@api/client.api";
import sellerInfo from "./sellerInfo";
import sellerItems from "./sellerItems";

export default {
    components: {
        sellerInfo,
        sellerItems
    },
    data(){
        return {
            client:{}
        }
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
