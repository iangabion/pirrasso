<template>
 <!-- <v-app-bar app
 color="blue darken-3"
 >
      <v-app-bar-nav-icon @click="toggle"></v-app-bar-nav-icon>
      <v-icon>mid-heart</v-icon>
      <v-toolbar-title><span class="hidden-sm-and-down">Buy and Sell</span></v-toolbar-title>
 </v-app-bar> -->
    <v-app-bar
    
      app
      color="white"
      elevation="0"
     
    
    >
      <v-app-bar-nav-icon @click="toggle()" />
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span class="hidden-sm-and-down">Bon Plan</span>
      </v-toolbar-title>
      <!-- <v-text-field
        v-model="form.search"
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down"
      /> -->
      <v-autocomplete v-model="select" prepend-inner-icon="mdi-magnify" :items="this.merge" flat hide-details label="Search" solo-inverted
        :search-input.sync="form.search" item-text="title" append-icon="" @change="redirect">
      </v-autocomplete>

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
    'app-header' : Translation,
  },
  data: () => ({
    select:'',
    form:{
      search:'',
    },
    item:'',
    global_item:[],
    global_client:[],
    merge:[],
    result:'',
    loading: false,
  }),
  methods : {
    global_search(key){
      // if(key.length >= 3){
        this.loading= true
        if(this.timer){
          clearTimeout(this.timer);
          this.timer = null;
        }
        this.timer = setTimeout(()=>{
          axios.post('api/global_search_item', {searchkey:key}).then((response)=>{
            console.log(response.data, "global item")
            this.global_item = response.data
              axios.post('api/global_search_client', {searchkey:key}).then((response)=>{
                console.log(response.data, "global client")
                // this.global_client = response.data
                response.data.forEach(v => {
                  let title = v.full_name
                  let wan = {
                    ...v,
                    title,
                    items: v.items,
                  }
                  this.global_client.push(wan)
                });
                this.merge = this.global_item.concat(this.global_client)

                console.log(this.merge,"merge chan")
              })
          })
        }, 1000)
      // }
    },
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
    },
    redirect(select){
        // this.prefill = 42
        // alert(select, "hey hey")
      let payload = { key:select}
      axios.post('api/global_search/', payload).then((response)=>{
        console.log(response.data, 'redirect result')
        if(response.data==''){
          this.$router.push({path:`/sellers`, query:{ item: select }})
        }else{
          this.$router.push({path:`/items`, query:{ item: select }})
        }
      })
    }
  },
  // mounted(){
  //   this.global_search()
  // }
  watch:{
    "form.search":{
      handler(val){
       val && val !== this.select && this.global_search(val)
        // this.global_search(val)
      }
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
  /* .hidden-sm-and-down{
       color: rgb(133, 133, 131);
  } */

</style>
