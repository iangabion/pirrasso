<template>
    <v-sheet>
        <v-navigation-drawer
            :value="drawer2"
            absolute
            @input="test"
            temporary
            right
            :width="325"
        >
            <v-list-item>
                <v-list-item-avatar>
                    <v-img
                        src="https://images.unsplash.com/photo-1528148343865-51218c4a13e6?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                    >
                    </v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title>{{item.title}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
            <v-list dense>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-currency-usd</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.price }}</v-list-item-title>
                        <v-list-item-subtitle>Price</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-information-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.description }}</v-list-item-title>
                        <v-list-item-subtitle>Description</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-counter</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.is_sold }}</v-list-item-title>
                        <v-list-item-subtitle>Sold</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon
                            color="indigo"
                        >mdi-tab</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.category ? item.category.name : '' }}</v-list-item-title>
                        <v-list-item-subtitle>Category</v-list-item-subtitle>
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
                        <v-list-item-subtitle>Date Published</v-list-item-subtitle>
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
                        v-for="(item,i) in item.photos"
                        :key="i"
                        :src="item.link"
                        reverse-transition="fade-transition"
                        transition="fade-transition"
                    ></v-carousel-item>
                </v-carousel>
                <div
                    style="text-align: center;font-weight: bold;padding-top: 10px;"
                    class="text-capitalize"
                > sample photo's </div>
            </div>
        </v-navigation-drawer>
    </v-sheet>
</template>
<script>
export default {
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
        drawer2(){
            return this.drawer
        }
    },
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
    methods: {
        test(payload) {
            console.log('sad', payload)
            !payload ? this.$emit('collapse-drawer', payload) : ''
        },
        deleteItem(){
            console.log(this.item)
        }
    },
    created(){
        console.log(this.item , 'sad drawer')
    }
}
</script>
