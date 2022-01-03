<template>
  <div>
    <v-toolbar>
      <v-toolbar-title class="px-4">SMTP {{$t('setting')}}</v-toolbar-title>
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
      <v-btn @click="dialog = true" >
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
                            {{item.is_default ? $t('settings.smtp.remove_default') : $t('settings.smtp.set_as_default')}}
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
         <v-dialog
            v-model="dialog"
            persistent
            max-width="600px"
          >
           
            <v-card>
              <form>
                <v-text-field
                  v-model="name"
                  :error-messages="nameErrors"
                  :counter="10"
                  label="Name"
                  required
                  @input="$v.name.$touch()"
                  @blur="$v.name.$touch()"
                ></v-text-field>
                <v-text-field
                  v-model="email"
                  :error-messages="emailErrors"
                  label="E-mail"
                  required
                  @input="$v.email.$touch()"
                  @blur="$v.email.$touch()"
                ></v-text-field>
                <v-select
                  v-model="select"
                  :items="items"
                  :error-messages="selectErrors"
                  label="Item"
                  required
                  @change="$v.select.$touch()"
                  @blur="$v.select.$touch()"
                ></v-select>
                <v-checkbox
                  v-model="checkbox"
                  :error-messages="checkboxErrors"
                  label="Do you agree?"
                  required
                  @change="$v.checkbox.$touch()"
                  @blur="$v.checkbox.$touch()"
                ></v-checkbox>

                <v-btn
                  class="mr-4"
                  @click="submit"
                >
                  submit
                </v-btn>
             
              </form>
            </v-card>
          </v-dialog>
        <!-- <addDialog
            :dialog="dialog2"
            @close="dialog2 = false; selected_item_id=0"
            @search="search"
            :id="selected_item_id"
        ></addDialog> -->
      </v-container>
    </div>
  </div>
</template>
<script>
import { validationMixin } from 'vuelidate'
  import { required, maxLength, email } from 'vuelidate/lib/validators'
import addDialog from './includes/dialog.vue'
import { SetDefault, DeleteSmtpData, GetAllSmtp } from "@api/smtp.api";
export default {
   mixins: [validationMixin],

    validations: {
      name: { required, maxLength: maxLength(10) },
      email: { required, email },
      select: { required },
      checkbox: {
        checked (val) {
          return val
        },
      },
    },
    
    components : {
        addDialog
    },
  data() {
    return {
      name: '',
      email: '',
      select: null,
      items: [
        'Item 1',
        'Item 2',
        'Item 3',
        'Item 4',
      ],
       checkbox: false,
      dialog: false,
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
    },
     checkboxErrors () {
        const errors = []
        if (!this.$v.checkbox.$dirty) return errors
        !this.$v.checkbox.checked && errors.push('You must agree to continue!')
        return errors
      },
      selectErrors () {
        const errors = []
        if (!this.$v.select.$dirty) return errors
        !this.$v.select.required && errors.push('Item is required')
        return errors
      },
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.maxLength && errors.push('Name must be at most 10 characters long')
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('E-mail is required')
        return errors
      },
  },
  mounted() {
    this.search();
  },
  methods: {

    submit () {
        this.$v.$touch()
      },
    changeStatus(id){
      SetDefault(id).then(response => {
        this.search();
      })
    },
    toggleOnCreate() {
      this.on_menu = false
    },
    toggleOffCreate() {
      this.on_menu = true
    },
    search(key) {
      this.loading = true
      let payload = {
        searchkey:key
      }
      console.log(payload)
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(() => {
        GetAllSmtp(payload).then((response) => {
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
      DeleteSmtpData(id).then((response)=> {
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
