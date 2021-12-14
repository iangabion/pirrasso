<template>
  <div>
    <v-toolbar>
      <v-toolbar-title class="px-4">SMTP {{$t('settings.smtp.setting')}}</v-toolbar-title>
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
      <v-btn @click="dialog2 = true" >
        <v-icon class="add_smtp">
          mdi-database-plus
        </v-icon>
        {{$t('settings.smtp.add_setting')}}
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
                <template v-slot:item.status_on="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-switch
                                dense
                                v-on="on"
                                v-model="item.is_default"
                                @change="changeStatus(item.id)"
                                inset
                            ></v-switch>
                        </template>
                        <span>
                            {{item.is_default ? this.$t('settings.smtp.remove_default') : this.$t('settings.smtp.set_as_default')}}
                        </span>
                    </v-tooltip>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-menu bottom origin="right center" transition="scale-transition">
                        <template v-slot:activator="{ on }">
                            <v-btn icon color="primary" dark v-on="on" @click.stop>
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                        <v-list class="pa-0">
                            <v-list-item @click="edit(item.id)" dense>
                                <v-list-item-icon class="mr-0">
                                    <v-icon size="20" color="primary">mdi-pencil</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>
                                    {{$t('settings.smtp.edit')}}
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="destroy(item.id)" dense>
                                <v-list-item-icon class="mr-0">
                                    <v-icon size="20" color="error">mdi-delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>
                                     {{$t('settings.smtp.delete')}}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </template>
                <template v-slot:no-data>
                  {{$t('settings.smtp.no_data_found')}}
                </template>
              </v-data-table>
            </v-card>
          </v-flex>
        </v-layout>
        <addDialog
            :dialog="dialog2"
            @close="dialog2 = false; selected_item_id=0"
            @search="search"
            :id="selected_item_id"
        ></addDialog>
      </v-container>
    </div>
  </div>
</template>
<script>
import addDialog from './includes/dialog.vue'
import { SetDefault } from "@api/smtp.api";
export default {
    components : {
        addDialog
    },
  data() {
    return {
      dialog2: false,
      form: {
        search: '',
      },
      selected_item_id:0,
      smtp: [],
      loading: false,
      on_menu: true,
      // headers: [
      //   { text: 'MAIL_MAILER', align: 'start', value: 'mail_mailer', width: '10%',},
      //   { text: 'MAIL_HOST', align: 'start', value: 'mail_host', width: '15%'},
      //   { text: 'MAIL_PORT', align: 'start', value: 'mail_port', width: '10%'},
      //   { text: 'MAIL_USERNAME', align: 'start', value: 'mail_username', width: '15%'},
      //   { text: 'MAIL_PASSWORD', align: 'start', value: 'mail_password', width: '25%'},
      //   { text: 'MAIL_ENCRYPTION', align: 'start', value: 'mail_encryption', width: '15%'},
      //   { text: 'Default', align: 'start', value: 'status_on', width: '10%'},
      //   { text: 'Action', align: 'start', value: 'actions', sortable: false,   width: '10%'},
      // ],
    }
  },
  computed: {
    headers(){
      return [
        { text: this.$t('settings.smtp.mail_mailer'), align: 'start', value: 'mail_mailer', width: '10%',},
        { text: this.$t('settings.smtp.mail_host'), align: 'start', value: 'mail_host', width: '15%'},
        { text: this.$t('settings.smtp.mail_port'), align: 'start', value: 'mail_port', width: '10%'},
        { text: this.$t('settings.smtp.mail_username'), align: 'start', value: 'mail_username', width: '15%'},
        { text: this.$t('settings.smtp.mail_password'), align: 'start', value: 'mail_password', width: '25%'},
        { text: this.$t('settings.smtp.mail_encryption'), align: 'start', value: 'mail_encryption', width: '15%'},
        { text: this.$t('settings.smtp.default'), align: 'start', value: 'status_on', width: '10%'},
        { text: 'Action', align: 'start', value: 'actions', sortable: false,   width: '10%'},
      ]
    }
  },
  mounted() {
    this.search();
  },
  methods: {
    changeStatus(id){
       SetDefault(id).then(response => {
           console.log(response, 'response')
           this.search();
       })
    },
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
      var conf = confirm(this.$t('settings.smtp.are_you_sure_want_to_delete_this_record'));
      if(conf)
      axios.delete('smtp/delete/'+ id).then((response)=> {
        console.log(response.data)
        this.search();
        this.loading = false
      })
    },
    edit(id) {
        this.selected_item_id = id
         this.$nextTick(() => {
            this.dialog2 = true
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


.v-dialog {
  box-shadow: none!important;
}

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
