<template>
    <v-app id="inspire">
        <app-side></app-side>
        <app-head></app-head>
        <app-confirm ref="app_confirm"></app-confirm>
        <app-alert ref="app_alert"></app-alert>
        <!-- <transition name="fade" mode="out-in">
            <v-alert color="primary" dark icon="mdi-bell" border="left" prominent v-model="snackbar_stat" id="notification" transition="slide-x-transition" dismissible>
                {{$store.getters.snackbar_message}}
            </v-alert>
        </transition> -->
        
        <v-content >
            <v-container fill-height>
                <v-layout  class="white">
                    <v-flex xs12>
                        <transition name="fade" mode="out-in">
                            <router-view></router-view>
                        </transition>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
  </v-app>
</template>

<script>
    import head from './layout/head.vue';
    import side from './layout/sidebar.vue';
    export default {
        mounted(){
        this.$root.$confirm = this.$refs.app_confirm.open
        },
        components :{
            'app-head' : head ,
            'app-side' : side
        }
    }
</script>
