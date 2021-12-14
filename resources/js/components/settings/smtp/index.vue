<template>
  <div>
    <v-toolbar>
      <v-toolbar-title class="px-4">SMTP Setting</v-toolbar-title>
      <v-spacer></v-spacer>
      <div class="search1">
        <v-text-field
          hide-details 
          placeholder="Search" 
          v-model="form.search"
          filled 
          rounded 
          dense 
          single-line          
          append-icon="mdi-magnify" class=" mx-4"
        />
      </div>
      <v-btn @click="dialog2 = true">
        <v-icon class="add_smtp">
          mdi-database-plus
        </v-icon>
        Add Setting
      </v-btn>
    </v-toolbar>
    <div>
      <v-container grid-list-xs>
        <v-layout row wrap>
          <v-flex xs12>
            <v-card>
              <v-data-table 
                class=' elevation-1'
                loader-height="2"
                :headers="headers"
                :items="smtp"
              >
                <template v-slot:item.actions="{ item }">
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
                    <v-list class="action_list">
                      <v-list-item class="action_list">
                        <v-btn
                          icon
                        >
                          <v-icon 
                            small 
                            color="green"
                          >mdi-check</v-icon>
                        </v-btn>
                        <v-btn
                          icon
                          @click="edit(item.id)"
                          @click.prevent="dialog2 = true"
                        >
                          <v-icon 
                            small 
                            color="blue"
                          >mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn
                          icon
                          @click="destroy(item.id)" 
                        >
                          <v-icon
                            small
                            color="red"
                          >mdi-delete</v-icon>
                        </v-btn>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </template>
                <template v-slot:no-data>
                  No Data Found
                </template>
              </v-data-table>
            </v-card>
          </v-flex>
        </v-layout>
        <v-dialog v-model="dialog2" persistent>
          <v-card class="card_main">
            <div class="container card_container">
              <form>
                <v-text-field
                  v-model="formData.mail_mailer"
                  name= "MAIL_MAILER"
                  ref="MAIL_MAILER"
                  label="MAIL_MAILER"
                  v-validate="'required'"
                  :error-messages="errors.collect('MAIL_MAILER')"
                  data-vv-name="MAIL_MAILER" 
                ></v-text-field>
                <v-text-field
                  v-model="formData.mail_host"
                  name="MAIL_HOST"   
                  ref="MAIL_HOST"
                  label="MAIL_HOST"
                  v-validate="'required'"
                  :error-messages="errors.collect('MAIL_HOST')"
                  data-vv-name="MAIL_HOST"
                ></v-text-field>
                <v-text-field
                  type="number"
                  v-model="formData.mail_port"
                  ref="MAIL_PORT"
                  label="MAIL_PORT"
                  v-validate="'required'"
                  :error-messages="errors.collect('MAIL_PORT')"
                  data-vv-name="MAIL_PORT"
                ></v-text-field>
                <v-text-field
                  v-model="formData.mail_username"    
                  label="MAIL_USERNAME"
                  ref="MAIL_USERNAME"
                  v-validate="'required'"
                  :error-messages="errors.collect('MAIL_USERNAME')"
                  data-vv-name="MAIL_USERNAME"
                ></v-text-field>
                <v-text-field
                  v-model="formData.mail_password"   
                  label="MAIL_PASSWORD"
                  ref="MAIL_PASSWORD"
                  v-validate="'required'"
                  :error-messages="errors.collect('MAIL_PASSWORD')"
                  data-vv-name="MAIL_PASSWORD"
                ></v-text-field>
                <v-text-field
                  v-model="formData.mail_encryption"   
                  label="MAIL_ENCRYPTION"
                  ref="MAIL_ENCRYPTION"
                  v-validate="'required'" 
                  :error-messages="errors.collect('MAIL_ENCRYPTION')"
                  data-vv-name="MAIL_ENCRYPTION"
                ></v-text-field>
                <v-btn
                  class="mr-4"
                  @click="create"
                >Submit</v-btn>
                <v-btn
                  class="mr-4"
                  @click="dialog2 = false"
                  @click.prevent= 'clearformData()'
                >Close</v-btn>
              </form>
            </div>
          </v-card>
        </v-dialog>
      </v-container>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dialog2: false,
      formData: {
        mail_mailer: '',
        mail_host: '',
        mail_port: '',
        mail_username: '',
        mail_password: '',
        mail_encryption: '',
        id: '',
      },
      form: {
        search: '',
      },
      smtp: [],
      loading: false,
      on_menu: true,
      headers: [
        { text: 'MAIL_MAILER', align: 'center', value: 'mail_mailer', width: '10%',},
        { text: 'MAIL_HOST', align: 'center', value: 'mail_host', width: '15%'},
        { text: 'MAIL_PORT', align: 'center', value: 'mail_port', width: '10%'},
        { text: 'MAIL_USERNAME', align: 'center', value: 'mail_username', width: '20%'},
        { text: 'MAIL_PASSWORD', align: 'center', value: 'mail_password', width: '20%'},
        { text: 'MAIL_ENCRYPTION', align: 'center', value: 'mail_encryption', width: '10%'},
        { text: 'Status', align: 'center', value: 'status_on', width: '10%'},
        { text: 'Action', align: 'center', value: 'actions', sortable: false,   width: '5%'},
      ],
    } 
  },
  mounted() {
    this.search();
  },
  methods: {
    toggleOnCreate() {
      console.log("click")
      this.on_menu = false
    },
    toggleOffCreate() {
      this.on_menu = true
    },
    search(key) {
      this.loading = true
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(() => {
        axios.post('smtp/search', {searchkey:key}).then((response) => {
          this.smtp = response.data 
          this.loading = false
        }).catch((errors) => {
          console.log(errors)
        });
      },800);
    },
    destroy(id) {
      this.loading = true
      var conf = confirm('Are you sure want to delete this record?');
      if(conf)
      axios.delete('smtp/delete/'+ id).then((response)=> {
        console.log(response.data)
        this.search();
        this.loading = false
      })
    },
    edit(id) {
      axios.get('smtp/show/'+ id, {}).then(response => {
          this.formData.id = response.data.id;
          this.formData.mail_mailer = response.data.mail_mailer;
          this.formData.mail_host= response.data.mail_host;
          this.formData.mail_port= response.data.mail_port;
          this.formData.mail_username= response.data.mail_username;
          this.formData.mail_password= response.data.mail_password;
          this.formData.mail_encryption= response.data.mail_encryption;
      });
    },
    clearformData() {
      this.formData.mail_mailer ='',
      this.formData.mail_host= '',
      this.formData.mail_port= '',
      this.formData.mail_username= '',
      this.formData.mail_password= '',
      this.formData.mail_encryption= '',
      this.formData.id= ''
      this.$validator.reset();
    },
    create() {
      this.loading = true
      this.$validator.validateAll().then(result => {
        if (result){
          this.$root.$confirm('Are you sure you want to save ?').then((result) => {
            if(result) {
              let dis = this ;
              let id = this.formData.id;
              if(id != '') {
                axios.put('smtp/update/'+id, this.formData ).then(function (response) {
                  dis.clearformData()
                  dis.dialog2=false;
                  dis.search();
                  dis.loading = false
                  alert('Successfully Updated');
              })
              }else{
                axios.post('smtp/create', this.formData).then((data)=> {
                  console.log(data)
                  this.clearformData()
                  this.dialog2=false;
                  this.loading = false
                  this.search();
                  alert('Successfully Created');
                }).catch((error)=> {
                  console.log(error)
                });
              }
            }
          })
        }
      })
    },
  },
  watch: {
    "form.search": {
      handler(val) {
        this.search(val)
      },
      deep: true,
    },
  }
}
</script>

<style scoped>
.add_smtp {
  padding-right: 10px;
}

.action_list {
  padding: 0;
}

.card_main {
  width: 100;
  justify-content: center;
  margin: auto;
}

.card_container {
  width: 500px;
}
</style>