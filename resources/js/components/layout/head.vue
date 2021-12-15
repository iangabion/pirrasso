<template>
 <!-- <v-app-bar app
 color="blue darken-3"
 >
      <v-app-bar-nav-icon @click="toggle"></v-app-bar-nav-icon>
      <v-icon>mid-heart</v-icon>
      <v-toolbar-title><span class="hidden-sm-and-down">Buy and Sell</span></v-toolbar-title>
 </v-app-bar> -->
    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark
    >
      <v-app-bar-nav-icon @click="toggle()" />
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span class="hidden-sm-and-down">Bon Plan</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down"
      />
        
      <v-spacer />

     
     
    <v-spacer></v-spacer>
    <app-header></app-header>

    

      <v-menu offset-y>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      icon
                      v-bind="attrs"
                      v-on="on"
                    >
                      <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                  </template>
                  <v-list>
                    <v-list-item class="dd">
                      <v-btn
                      text
                      >
                       <span>Edit Profile</span>
                      </v-btn>
                        
                       <v-btn
                       text 
                       style="width: 120px"
                       >
                       <span @click="logout">Logout</span>
                      </v-btn>
           
                      
                    </v-list-item>
                  </v-list>
                </v-menu>
      <!-- <v-btn icon @click="logout">
        <v-icon>mdi-logout</v-icon>
      </v-btn> -->
    </v-app-bar>
</template>
<script>
import Translation from './translation.vue'
export default {
    
     components:{
        'app-header' : Translation
     },
  methods : {
    langChanged(lang){
             localStorage.Lang=lang;
             this.$vuetify.lang.current = lang
             this.locale = lang;
        },
    toggle() {
        this.$store.commit('toggleSideBar')
        console.log(this.$store.state.sidebar, 'sidebar')

      },
    logout() {
       let self = this;
     axios.get('/logout', {})
      .then(response => {
          console.log(response.data)
          self.$router.push('/login');
          location.reload();
      });
    }
  }
}
</script>

<style scoped>
.dd{
    display:flex;
    flex-direction:column;
    align-items:left;
    height: 120px;
    width: 120px;
   
  }
</style>
