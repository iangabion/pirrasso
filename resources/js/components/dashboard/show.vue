<template>
    <v-container >
        <v-layout row wrap>
            <v-flex xs3>
                <v-card
                    class="mx-auto purple "
                    max-width="344"
                    outlined color="primary"
                    dark
                >
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">sellers</div>
                            <v-list-item-title class="headline mb-1">{{clients.length}}</v-list-item-title>
                            <v-list-item-subtitle>Sellers</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-avatar
                            tile
                            size="80"
                                color="white"
                        >
                        <v-icon size="60" color="primary">mdi-account-group</v-icon>
                        </v-list-item-avatar>
                    </v-list-item>
                    <v-card-actions >
                        <v-btn text>view</v-btn>
                        <v-btn text>button</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs3>
                <v-card
                    class="mx-auto purple "
                    max-width="344"
                    outlined 
                    color="info"
                    dark
                >
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">items</div>
                            <v-list-item-title class="headline mb-1">{{items.length}}</v-list-item-title>
                            <v-list-item-subtitle>Items on sell</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-avatar
                            tile
                            size="80"
                                color="white"
                        >
                        <v-icon size="60" color="primary">mdi-history</v-icon>
                        </v-list-item-avatar>
                    </v-list-item>
                    <v-card-actions >
                        <v-btn text>view</v-btn>
                        <v-btn text>button</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs3>
                <v-card
                    class="mx-auto purple "
                    max-width="344"
                    outlined 
                    color="info"
                    dark
                >
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">sold</div>
                            <v-list-item-title class="headline mb-1">{{sold.length}}</v-list-item-title>
                            <v-list-item-subtitle>Sold Items</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-avatar
                            tile
                            size="80"
                                color="white"
                        >
                        <v-icon size="60" color="primary">mdi-history</v-icon>
                        </v-list-item-avatar>
                    </v-list-item>
                    <v-card-actions >
                        <v-btn text>view</v-btn>
                        <v-btn text>button</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
export default {
    data: () => ({
        clients: [],
        items: [],
        sold:[],
    }),
    methods: {
        get_clients(){
            axios.get('/client', {})
            .then(response => {
                this.clients = response.data;
                console.log(this.clients)
            });
        },
        get_items(){
            axios.get('/item', {})
            .then(response => {
                this.items = response.data;
                console.log(this.items,"item")
            });
        },
        get_sold(){
            axios.get('/sold_count', {})
            .then(response => {
                this.sold = response.data;
                console.log(this.sold , 'sold')
            });
        }
    },
    created: function () {
        this.get_clients()
        this.get_items()
        this.get_sold()
    },
}
</script>