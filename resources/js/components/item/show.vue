<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Items</v-toolbar-title>
            <v-spacer></v-spacer>
            <div class="search1">
                <v-text-field
                    hide-details
                    placeholder="Search"
                    v-model="search"
                    filled
                    rounded
                    dense
                    single-line
                    append-icon="mdi-magnify" class=" mx-4"
                />
            </div>
            <v-btn @click="dialog2 = true" class="d-none">
                <v-icon class="mr-2">
                    mdi-cart
                </v-icon>
                    Add Setting
            </v-btn>
        </v-toolbar>
        <v-row>
            <v-card width=25% max-height=auto elevation="0">
                <v-list dense>
                    <template v-for="item in categories" >
                        <v-row v-if="item.heading" :key="item.heading" align="center" >
                        </v-row>
                        <v-list-group
                            v-else-if="item.subcategories!=0" :key="item.name" v-model="item.model"

                        >
                            <template v-slot:activator>
                                <v-list-item>
                                    <v-list-item-content
                                    >
                                        <v-list-item-title  >
                                            {{ item.name }}
                                        </v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </template>
                            <v-list-item v-for="(subcat, i) in item.subcategories"
                                :key="i" @click="selected_category = subcat.id"
                                v-bind:class="{'chan_grey' : highlight(subcat.id) }"
                                v-on:click="isgrey = subcat.id"
                            >
                                <v-list-item-content >
                                    <v-list-item-title v-bind:class="{'chan_grey' : highlight(subcat.id) }">
                                        {{ subcat.name }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>
                        <v-list-item v-else :key="item.id" @click.prevent="get_items(item.id)"
                            v-bind:class="{'chan_grey' : highlight(item.id) }" v-on:click="isgrey = item.id"
                        >
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title v-bind:class="{'chan_grey' : highlight(item.id) }">
                                        {{ item.name }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item>

                    </template>

                </v-list>
            </v-card>
            <v-card width=70% elevation="0">
                <v-container class="">
                        <v-layout row wrap>
                            <v-card>
                                <v-flex xs12 v-if="!data_loaded">
                                    <v-skeleton-loader
                                        type="table-tbody"
                                    ></v-skeleton-loader>
                                </v-flex>
                                <v-flex xs12 v-else >
                                    <v-layout row wrap v-if="categories_item.length">
                                        <v-flex  xs12 sm2  v-for="(items,index) in categories_item" :key="items.id" >
                                            <v-card>
                                                <v-list-item>
                                                <v-list-item-avatar color="grey">
                                                    <v-img class="pa-2"
                                                        :src="items.owner.profile_pic"
                                                    ></v-img>
                                                </v-list-item-avatar>
                                                <v-list-item-content>
                                                    <v-list-item-title >{{items.owner.username}}</v-list-item-title>
                                                    <!-- <v-list-item-subtitle>10 minutes ago</v-list-item-subtitle> -->
                                                </v-list-item-content>
                                                </v-list-item>
                                                <v-img class="pa-2"
                                                aspect-ratio="1.5"
                                                contain
                                                :src="items.images.length ? items.images[0].image : 'https://shyamsunderfoods.com/wp-content/uploads/2019/02/no-photo-6.jpg' "
                                                ></v-img>
                                                <v-list-item>
                                                <v-list-item-content class="text-capitalize">
                                                    <v-list-item-title class="py-1 font-weight-bold" >  {{items.title}}</v-list-item-title>
                                                    <v-list-item-subtitle > <v-icon>mdi-coin</v-icon> PHP {{items.price}}</v-list-item-subtitle>
                                                    <v-list-item-subtitle class="py-1"> <v-icon>mdi-comment</v-icon> {{items.description}}</v-list-item-subtitle>
                                                    <v-list-item-subtitle ><v-icon>mdi-star-box</v-icon> {{items.status}}</v-list-item-subtitle>
                                                    <v-list-item-subtitle >
                                                    <span v-if="(items.is_urgent)==1">
                                                        <v-icon>mdi-alert-octagon</v-icon>
                                                        {{$t('item.show.urgent')}}
                                                    </span>
                                                    </v-list-item-subtitle>
                                                    <v-list-item-subtitle>
                                                        <span v-if="(items.is_active)==1">
                                                            <v-icon>mdi-alert-octagon</v-icon>
                                                            {{$t('item.show.active')}}
                                                        </span>
                                                        <span v-if="(items.is_active)==0">
                                                            <v-icon>mdi-alert-octagon</v-icon>
                                                            {{$t('item.show.unactive')}}
                                                        </span>
                                                    </v-list-item-subtitle>
                                                <!-- <v-list-item-subtitle>

                                                            <span v-if="(items.is_active)==1">
                                                            <v-icon>mdi-check</v-icon>
                                                            </span>

                                                            <span v-if="(items.is_active)==0">
                                                            <v-icon>mdi-close</v-icon>
                                                            </span>

                                                            <span v-if="(items.is_active)==0">
                                                            <v-icon>mdi-close</v-icon>
                                                            </span>

                                                </v-list-item-subtitle> -->
                                                </v-list-item-content>
                                                </v-list-item>
                                                <v-divider></v-divider>
                                                <v-card-actions >

                                                <v-btn icon>
                                                    <v-icon @click="show(items , index)" color="primary">mdi-eye</v-icon>
                                                </v-btn>
                                                <v-btn icon @click="destroy(items.id , index)">
                                                    <v-icon color="yellow">mdi mdi-coin</v-icon>
                                                </v-btn>
                                                <v-btn icon @click="destroy(items.id , index)">
                                                    <v-icon color="error">mdi-delete</v-icon>
                                                </v-btn>
                                                <span v-if="(items.is_active)==0">
                                                    <v-btn icon>
                                                        <v-icon icon @click="show_activate(items , index)">mdi-check</v-icon>
                                                    </v-btn>
                                                </span>
                                                <span v-if="(items.is_active)==1">
                                                    <v-btn icon  @click="show_deactivate(items , index)">
                                                        <v-icon>mdi-close</v-icon>
                                                    </v-btn>
                                                </span>


                                                </v-card-actions>

                                            </v-card>
                                            <v-dialog
                                            v-model="dialogActivate"
                                            width="300px"
                                            >
                                            <v-list>
                                                <v-list-item
                                                    dense
                                                    v-for="(item) in 5" :key="item.id+'test'"
                                                    style="cursor:pointer;"
                                                    class="my-1"
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>mdi-home</v-icon>
                                                    </v-list-item-icon>

                                                    <v-list-item-title>Home</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                            </v-dialog>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout row wrap v-else>
                                        <v-flex >
                                            <v-alert
                                                border="right"
                                                colored-border
                                                type="error"
                                                elevation="2"
                                                >
                                                {{$t('item.show.no_items_for_this_category')}}
                                            </v-alert>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-card>
                        </v-layout>
                </v-container>
                
            </v-card>
        </v-row>
    </div>
</template>
<script>
export default {
    data(){
        return {
            search:''
        }
    }
}
</script>
