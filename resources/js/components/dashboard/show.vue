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
                        <v-list-item two-line>
                            <v-list-item-content>
                                <div class="overline mb-4">{{$t('dashboard.sellers')}}</div>
                                <v-list-item-title class="headline mb-1">{{clients.length}}</v-list-item-title>
                                <v-list-item-subtitle>{{$t('dashboard.sellers')}}</v-list-item-subtitle>
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
                            <v-btn text href="/sellers" >{{$t('dashboard.view')}}</v-btn>
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
                                <div class="overline mb-4">{{$t('dashboard.items')}}</div>
                                <v-list-item-title class="headline mb-1">{{items.length}}</v-list-item-title>
                                <v-list-item-subtitle>{{$t('dashboard.items_on_sell')}}</v-list-item-subtitle>
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
                            <v-btn text href="/items_show">{{$t('dashboard.view')}}</v-btn>
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
                                <div class="overline mb-4">{{$t('dashboard.stock')}}</div>
                                <v-list-item-title class="headline mb-1">{{this.stock}}</v-list-item-title>
                                <v-list-item-subtitle>{{$t('dashboard.stock_items')}}</v-list-item-subtitle>
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
                                <div class="overline mb-4">{{$t('dashboard.sold')}}</div>
                                <v-list-item-title class="headline mb-1">{{sold.length}}</v-list-item-title>
                                <v-list-item-subtitle>{{$t('dashboard.sold_items')}}</v-list-item-subtitle>
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
                    <vue-chart type="bar" :data="chartItem" v-if="is_loaded"></vue-chart>
                </v-col>
                <v-col style="width: 45%; border-style: solid; border-color: #EF7922; margin:auto" >
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
    data: (vm) => ({
        clients: [],
        items: [],
        
        stock: 0,
        is_loaded: false,
        yearItem: new Date().getFullYear(),
        yearSold: new Date().getFullYear(),
        sold:[],
        chartItem: {
            labels: [vm.$t('dashboard.january'), vm.$t('dashboard.february'), vm.$t('dashboard.march'), vm.$t('dashboard.april'), vm.$t('dashboard.may'), vm.$t('dashboard.june'), vm.$t('dashboard.july'), vm.$t('dashboard.august'), vm.$t('dashboard.september'), vm.$t('dashboard.october'), vm.$t('dashboard.november'), vm.$t('dashboard.december')],
            datasets: [
                {
                    label: vm.$t('dashboard.days_purchases'),
                    data: [0,0,0,0,12,0,0,0,0,0,0,0],
                    backgroundColor: '#FFB8A2',
                },
                {
                    label: vm.$t('dashboard.days_sales'),
                    data: [0,0,0,0,0,0,0,0,0,0,0,0],
                    backgroundColor: '#FF7E55',
                },
                {
                    label: vm.$t('dashboard.days_profit'),
                    data: [0,0,0,0,0,0,0,0,0,0,0,0],
                    backgroundColor: '#EF7922',
                },
            ],
        },
        chartSold: {
            labels: [vm.$t('dashboard.january'), vm.$t('dashboard.february'), vm.$t('dashboard.march'), vm.$t('dashboard.april'), vm.$t('dashboard.may'), vm.$t('dashboard.june'), vm.$t('dashboard.july'), vm.$t('dashboard.august'), vm.$t('dashboard.september'), vm.$t('dashboard.october'), vm.$t('dashboard.november'), vm.$t('dashboard.december')],

            datasets: [
                {
                    label: vm.$t('dashboard.sold'),
                    data: [0,0,0,0,0,0,0,0,0,0,0,0],
                    backgroundColor: '#EF7922',
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
            });
        },
        get_sold(){
            axios.get('/sold_count', {})
            .then(response => {
                this.sold = response.data;
            });
        },

        // get_added_item(){
        //     axios
        // },
        stock_count() {
            getStock().then(({data}) => {
                this.stock = data
            })
        },
        get_monthlyitem(payload) {
            getMonthlyItemReport(payload).then(({data}) => {
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
    background-color: #EF7922 !important;
    border-color: #EF7922!important;
}
</style>