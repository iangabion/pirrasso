<template>
    <div>
        <v-card
            max-width="375"
            class="mx-auto"
        >
            <!-- src="https://cdn.vuetifyjs.com/images/lists/ali.png" -->
            <v-img
            :src="client.image"
            height="372px"
            dark
            >
            </v-img>

            <v-list two-line>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon color="indigo">
                        mdi-account
                    </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                <v-list-item-title
                    class="text-capitalize"
                >{{client.first_name}} {{client.last_name}}</v-list-item-title>
                <v-list-item-subtitle>{{ $t('seller.sellerinfo.name')}}</v-list-item-subtitle>
                </v-list-item-content>

            </v-list-item>

            <v-divider inset></v-divider>
            <v-list-item>
                <v-list-item-icon>
                <v-icon color="indigo">
                    mdi-phone
                </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                <v-list-item-title>{{client.mobile}}</v-list-item-title>
                <v-list-item-subtitle>{{ $t('seller.sellerinfo.mobile')}}</v-list-item-subtitle>
                </v-list-item-content>

            </v-list-item>

            <v-divider inset></v-divider>
            <v-list-item>
                <v-list-item-icon>
                <v-icon color="indigo">
                   mdi-account-box
                </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                <v-list-item-title>{{client.username}}</v-list-item-title>
                <v-list-item-subtitle>{{ $t('seller.sellerinfo.user_name')}}</v-list-item-subtitle>
                </v-list-item-content>

            </v-list-item>

            <v-divider inset></v-divider>

            <v-list-item>
                <v-list-item-icon>
                <v-icon color="indigo">
                    mdi-email
                </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                <v-list-item-title>{{client.email}}</v-list-item-title>
                <v-list-item-subtitle>{{ $t('seller.sellerinfo.email')}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>


          

           
            </v-list>
        </v-card>
    </div>
</template>
<script>
export default {
    props: {
        'client': {
            type: Object,
            required: true
        }
    },
    created(){
        console.log(this.client , 'cliemnt')
    }
}
</script>
