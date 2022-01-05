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
                        <v-btn text href="/sellers">view</v-btn>
                        <!-- <v-btn text>button</v-btn> -->
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs3>
                <v-card
                    class="mx-auto purple "
                    max-width="344"
                    outlined 
                    color="primary"
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
                        <v-icon size="60" color="primary">mdi-shopping </v-icon>
                        </v-list-item-avatar>
                    </v-list-item>
                    <v-card-actions >
                        <v-btn text href="/items">view</v-btn>
                        <!-- <v-btn text>button</v-btn> -->
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs3>
                <v-card
                    class="mx-auto purple "
                    max-width="344"
                    outlined 
                    color="primary"
                    dark
                >
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">Stock</div>
                            <v-list-item-title class="headline mb-1">{{this.stock}}</v-list-item-title>
                            <v-list-item-subtitle>Stock Items</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-avatar
                            tile
                            size="80"
                            color="white"
                        >
                        <v-icon size="60" color="primary">mdi-poll</v-icon>
                        </v-list-item-avatar>
                    </v-list-item>
                    <v-card-actions >
                        <v-btn text style="visibility: hidden;">view</v-btn>
                        <v-btn text style="visibility: hidden;">button</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs3>
                <v-card
                    class="mx-auto purple "
                    max-width="344"
                    outlined 
                    color="primary"
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
                        <v-icon size="60" color="primary">mdi-cart</v-icon>
                        </v-list-item-avatar>
                    </v-list-item>
                    <v-card-actions >
                        <v-btn text style="visibility: hidden;">view</v-btn>
                        <v-btn text style="visibility: hidden;">button</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-container style="width: 100%; display: flex;">
                <v-col style="width: 50%; border-style: solid;border-color: #FF5722">
                    <v-toolbar-items>
                        <v-btn
                            icon
                            @click="decrementItem()" 
                        >
                            <v-icon 
                                color="green"
                            >mdi-minus</v-icon>
                        </v-btn>
                        <span class="year" readonly min="0.00">{{yearItem}}</span>
                        <v-btn
                            icon
                            @click="incrementItem()"
                        >
                            <v-icon 
                                color="green"
                            >mdi-plus</v-icon>
                        </v-btn>
                    </v-toolbar-items>
                    <vue-chart type="bar" :data="chartItem"></vue-chart>
                </v-col>
                <v-col style="width: 50%; border-style: solid; border-color: #FF5722">
                    <v-toolbar-items>
                        <v-btn
                            icon
                            @click="decrementSold()" 
                        >
                            <v-icon 
                                color="green"
                            >mdi-minus</v-icon>
                        </v-btn>
                        <span class="year" readonly min="0.00">{{yearSold}}</span>
                        <v-btn
                            icon
                            @click="incrementSold()"
                        >
                            <v-icon 
                                color="green"
                            >mdi-plus</v-icon>
                        </v-btn>
                    </v-toolbar-items>
                    <vue-chart type="bar" :data="chartSold"></vue-chart>
                </v-col>
            </v-container>
        </v-layout>
    </v-container>
</template>
<script>
import { getStock } from "@api/item.api";
export default {
    name:'home',
    data: () => ({
        clients: [],
        items: [],
        stock: 0,
        yearItem: new Date().getFullYear(),
        yearSold: new Date().getFullYear(),
        sold:[],
        chartItem: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'Item',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0],
                    backgroundColor: '#FF5722',
                },
            ],
        },
        chartSold: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'Sold',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0],
                    backgroundColor: '#FF5722',
                },
            ],
        },
    }),
    async mounted() {
        await this.stock_count();
    },
    methods: {
        incrementItem() {
            this.yearItem++;
            // this.getMonthlySalesReport()
        },
        decrementItem() {
            if (this.yearItem === 1) {
                alert("Negative year not allowed");
            } else {
                this.yearItem--;
                // this.getMonthlySalesReport()
            }
        },
        incrementSold() {
            this.yearSold++;
            // this.getMonthlySalesReport()
        },
        decrementSold() {
            if (this.yearSold === 1) {
                alert("Negative year not allowed");
            } else {
                this.yearSold--;
                // this.getMonthlySalesReport()
            }
        },
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
        },
        stock_count() {
            getStock().then(({data}) => {
                this.stock = data
                console.log('sad',this.stock)
            })
        },
    },
    created: function () {
        this.get_clients()
        this.get_items()
        this.get_sold()
    },
}
</script>

<style scoped>
.v-application .primary {
    background-color: #FF5722 !important;
    border-color: #FF5722!important;
}
</style>