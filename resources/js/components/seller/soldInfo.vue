<template>
   <v-sheet>
        <v-navigation-drawer
            :value="drawer3"
            absolute
            @input="test"
            temporary
            right
            :width="325"
        >

        <v-list-item>
                <v-list-item-avatar>
                <!-- <v-img
                    src="https://images.unsplash.com/photo-1528148343865-51218c4a13e6?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                >
                </v-img> -->
                </v-list-item-avatar>

                <v-list-item-content>
                <v-list-item-title>{{item.item.title}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>
            <!-- {{item.photos}} -->
            <v-list dense>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-archive-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.quantity }}</v-list-item-title>
                         <v-list-item-subtitle>Quantity</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-information-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.status_id }}</v-list-item-title>
                         <v-list-item-subtitle>Status</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-cart-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.buyers.full_name }}</v-list-item-title>
                         <v-list-item-subtitle>Buyer's Name</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-tab</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.item.category ? item.item.category.name : '' }}</v-list-item-title>
                         <v-list-item-subtitle>{{$t('seller.productinfo.category')}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-calendar-clock</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.created_at }}</v-list-item-title>
                         <v-list-item-subtitle>{{$t('seller.productinfo.date_published')}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <div class="pa-4">
                <v-carousel
                    height="200"
                    interval="5000"
                    cycle
                    hide-delimiters
                    show-arrows-on-hover
                >
                    <v-carousel-item
                        v-for="(item,i) in item.item.photos"
                        :key="i"
                        :src="item.filename"
                        reverse-transition="fade-transition"
                        transition="fade-transition"
                    ></v-carousel-item>
                </v-carousel>
                <div
                    style="text-align: center;font-weight: bold;padding-top: 10px;"
                    class="text-capitalize"
                >{{$t('seller.productinfo.sample_photo')}}</div>
               
            </div>
        </v-navigation-drawer>
   </v-sheet>
</template>
<script>
export default {
    data() {
        return {
            items: [
                { title: 'Home', icon: 'mdi-view-dashboard' },
                { title: 'About', icon: 'mdi-forum' },
            ],
            images: [
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
                },
                {

                    src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
                },
            ],
        }
    },
     props: {
        'drawer': {
            type: Boolean,
            required: true
        },
        'item': {
            type: Object,
            required: true
        },
    },
    computed: {
        drawer3(){
            return this.drawer
        }
    },
    methods: {
        test(payload) {
            console.log('sad', payload)
            !payload ? this.$emit('collapse-drawer', payload) : ''
        },
        
    },
}
</script>