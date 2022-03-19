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
                      @click="dialog=true"
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
      <v-dialog
        v-model="dialog"
        persistent
        width="25%"
        max-height="100%"
      >
      <v-card height="100%">
        <v-card-title>
          Edit Admin Profile
        </v-card-title>
        <v-form
          ref="form"
          v-model="valid"
          lazy-validation
          class="padding"
        >
          <v-flex xs12>
            <v-subheader class="px0">Name</v-subheader>
            <v-text-field
              dense
              filled
              solo
              v-model="user.name"
              :rules="nameRules"
              required
            >

            </v-text-field>
          </v-flex>
          <v-flex
          xs12
          >
            <v-subheader class="px-0">Email</v-subheader>
            <v-text-field 
            dense
            filled
            solo
            v-model="user.email"
            :rules="emailRules"
            required>
            </v-text-field>
          </v-flex>
          <v-flex xs12>
                <v-subheader>Password</v-subheader>
                <v-text-field
                    dense
                    filled
                    solo
                    v-model="user.password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    :rules="passRules"
                    label="Password"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                  ></v-text-field>
                 
          </v-flex>
           <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
          color="primary"
          dense
          elevation="3"
          @click="edit_profile()"
          >
            Submit
          </v-btn>
           <v-btn
          color="error"
          dense
          elevation="3"
          @click="dialog=false"
          >
            Cancel
          </v-btn>
           <v-spacer></v-spacer>
        </v-card-actions>
          

        </v-form>

       
      </v-card>



      </v-dialog>
    </v-app-bar>
</template>
<script>
import Translation from './translation.vue'
import { validationMixin } from "vuelidate";
import { required, minLength, email, sameAs } from "vuelidate/lib/validators";
export default {
    mixins: [validationMixin],
    validations: {
    password: { required, minLength: minLength(6) },
    confirmPassword: { sameAsPassword: sameAs("formData.password") }
  },
  components:{
    'app-header' : Translation,
  },
  data: () => ({

    valid: true,
     nameRules: [
        v => !!v || "Name is Required",
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
      emailRules: [
        v => !!v ||"E-mail is Required",
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
      passRules: [
        v => !!v || "Password is Required",
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
    dialog: false,
    user:[],
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
    formData: {
      name: '',
      email:'',
      password:'',
      confirmPassword: ''
    },
    showPassword: false
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
                this.global_client = response.data
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
      axios.post('api/global_search', payload).then((response)=>{
        console.log(response.data, 'redirect result')
        if(response.data==''){
          this.$router.push({path:`/sellers`, query:{ item: select }})
        }else{
          this.$router.push({path:`/items`, query:{ item: select }})
        }
      })
    },
    get_adminProfile(){
      axios.get('user_profile').then(res=>{
        this.user = res.data
        console.log(res)
      })
    },
    edit_profile(){
      axios.post('edit_admin/' + this.user.id, this.user).then(res=>{
        this.user = res.data
        console.log(res)
        this.dialog = false
      })
    }
  },
  mounted(){
    this.get_adminProfile()
  },
  computed:{
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.minLength &&
        errors.push("Password must be at least 6 characters long");
      !this.$v.password.required && errors.push("Password is required");
      return errors;
    },
  
  },
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
    height: 65px;
    width: 120px;
   
  }
  /* .hidden-sm-and-down{
       color: rgb(133, 133, 131);
  } */

  .v-subheader{
    height: 20px !important;
    margin-bottom: 1px;
    margin-top: 7px;
    font-weight: bold;
    letter-spacing: 2px;
}
.padding {
    padding-left: 1em;
    padding-right: 1em;
}

</style>
