<template>
    <v-container >
        <v-layout row wrap>
            <div style="width:100%; display:flex; justify-content: space-between">
                <v-flex xs3>
                    <v-card
                        class="mx-auto purple "
                        max-width="380"
                        outlined color="primary"
                        dark
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div class="overline mb-4">sellers</div>
                                <v-list-item-title class="headline mb-1">{{clients.length}}</v-list-item-title>
                                <v-list-item-subtitle>Sellers</v-list-item-subtitle>
                            </v-list-item-content>
                            <!-- <v-list-item-avatar
                                tile
                                size="80"
                                color="white"
                            > -->
                            <v-icon size="60" color="white">mdi-account-group</v-icon>
                            <!-- </v-list-item-avatar> -->
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
                        max-width="380"
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
                            <!-- <v-list-item-avatar
                                tile
                                size="80"
                                color="white"
                            > -->
                            <v-icon size="60" color="white">mdi-shopping </v-icon>
                            <!-- </v-list-item-avatar> -->
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
                        max-width="380"
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
                            <!-- <v-list-item-avatar
                                tile
                                size="80"
                                color="white"
                            > -->
                            <v-icon size="60" color="white">mdi-poll</v-icon>
                            <!-- </v-list-item-avatar> -->
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
                        max-width="380"
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
                            <!-- <v-list-item-avatar
                                tile
                                size="80"
                                color="white"
                            > -->
                            <v-icon size="60" color="white">mdi-cart</v-icon>
                            <!-- </v-list-item-avatar> -->
                        </v-list-item>
                        <v-card-actions >
                            <v-btn text style="visibility: hidden;">view</v-btn>
                            <v-btn text style="visibility: hidden;">button</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </div>
            <v-container style="width: 100%; display: flex;" >
                <v-col style="width: 45%; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <v-toolbar dense outlined flat fixed-toolbar>
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
                    </v-toolbar>
                    <vue-chart type="bar" :data="chartItem" v-if="is_loaded"></vue-chart>
                </v-col>
                <v-col style="width: 45%; border-style: solid; border-color: #FF5722; margin:auto" >
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
import { getStock, getMonthlyItemReport } from "@api/item.api";
export default {
    name:'home',
    data: () => ({
        clients: [],
        items: [],
        stock: 0,
        is_loaded: false,
        yearItem: new Date().getFullYear(),
        yearSold: new Date().getFullYear(),
        sold:[],
        chartItem: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: '15-days Purchases',
                    data: [0,0,0,0,12,0,0,0,0,0,0,0],
                    backgroundColor: '#FFB8A2',
                },
                {
                    label: '15-days Sales',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0],
                    backgroundColor: '#FF7E55',
                },
                {
                    label: '15-days Profit',
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
        console.log("sadsss")
        await this.stock_count();
        await this.getMonthlyItemYear()
    },
    created() {
        console.log('created')
        this.is_loaded = false;
        let payload = {
            date: this.yearItem
        }
        console.log("payload", payload)
        this.get_monthlyitem(payload)
    },
    methods: {
        incrementItem() {
            this.yearItem++;
            this.getMonthlyItemYear()
        },
        decrementItem() {
            if (this.yearItem === 1) {
                alert("Negative year not allowed");
            } else {
                this.yearItem--;
                this.getMonthlyItemYear()
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
                // console.log(this.clients)
            });
        },
        get_items(){
            axios.get('/item', {})
            .then(response => {
                this.items = response.data;
                // console.log(this.items,"item")
            });
        },
        get_sold(){
            axios.get('/sold_count', {})
            .then(response => {
                this.sold = response.data;
                // console.log(this.sold , 'sold')
            });
        },
        stock_count() {
            getStock().then(({data}) => {
                this.stock = data
                // console.log('sad',this.stock)
            })
        },
        get_monthlyitem(payload) {
            getMonthlyItemReport(payload).then(({data}) => {
                // console.log("month", data)
                this.chartItem.datasets[0].data[0] = data[0][0]
                this.chartItem.datasets[0].data[1] = data[1][0]
                this.chartItem.datasets[0].data[2] = data[2][0]
                this.chartItem.datasets[0].data[3] = data[3][0]
                this.chartItem.datasets[0].data[4] = data[4][0]
                this.chartItem.datasets[0].data[5] = data[5][0]
                this.chartItem.datasets[0].data[6] = data[6][0]
                this.chartItem.datasets[0].data[7] = data[7][0]
                this.chartItem.datasets[0].data[8] = data[8][0]
                this.chartItem.datasets[0].data[9] = data[9][0]
                this.chartItem.datasets[0].data[10] = data[10][0]
                this.chartItem.datasets[0].data[11] = data[11][0]
                
                this.chartItem.datasets[1].data[0] = data[0][1]
                this.chartItem.datasets[1].data[1] = data[1][1]
                this.chartItem.datasets[1].data[2] = data[2][1]
                this.chartItem.datasets[1].data[3] = data[3][1]
                this.chartItem.datasets[1].data[4] = data[4][1]
                this.chartItem.datasets[1].data[5] = data[5][1]
                this.chartItem.datasets[1].data[6] = data[6][1]
                this.chartItem.datasets[1].data[7] = data[7][1]
                this.chartItem.datasets[1].data[8] = data[8][1]
                this.chartItem.datasets[1].data[9] = data[9][1]
                this.chartItem.datasets[1].data[10] = data[10][1]
                this.chartItem.datasets[1].data[11] = data[11][1]
                
                this.chartItem.datasets[2].data[0] = data[0][2]
                this.chartItem.datasets[2].data[1] = data[1][2]
                this.chartItem.datasets[2].data[2] = data[2][2]
                this.chartItem.datasets[2].data[3] = data[3][2]
                this.chartItem.datasets[2].data[4] = data[4][2]
                this.chartItem.datasets[2].data[5] = data[5][2]
                this.chartItem.datasets[2].data[6] = data[6][2]
                this.chartItem.datasets[2].data[7] = data[7][2]
                this.chartItem.datasets[2].data[8] = data[8][2]
                this.chartItem.datasets[2].data[9] = data[9][2]
                this.chartItem.datasets[2].data[10] = data[10][2]
                this.chartItem.datasets[2].data[11] = data[11][2]
                this.is_loaded = true
            })
        },
        async getMonthlyItemYear() {
            this.is_loaded = false
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => { 
                let payload = {
                    date: this.yearItem,
                }
                console.log(payload,"request")
                this.get_monthlyitem(payload)
            }, 800);
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