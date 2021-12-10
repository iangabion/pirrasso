<template>
  <div>
    <v-toolbar>
        <v-toolbar-title class="px-4">SMTP Setting</v-toolbar-title>
        <v-spacer></v-spacer>
        <div class="search1">
          <v-text-field
            hide-details 
            placeholder="Search" 
            v-model="search"
            filled 
            rounded 
            dense 
            single-line          
            append-icon="mdi-magnify" class=" mx-4"
          />
        </div>
        <div>
          <v-btn @click="toggleOnCreate" v-if="on_menu==true">
            <v-icon style="padding-right: 10px">
              mdi-database-plus
            </v-icon>
            Add Setting
          </v-btn>
          <v-btn @click="toggleOffCreate" v-else>
            <v-icon style="padding-right: 10px">
               mdi-undo
            </v-icon>
            Back
          </v-btn>
        </div>
    </v-toolbar>
    <div v-if="on_menu">
      <v-container grid-list-xs>
          <v-layout row wrap>
              <v-flex xs12>
                  <v-card>
                    <v-data-table 
                      class=' elevation-1'
                      loader-height="2"
                      :headers="headers"
                      hide-default-footer
                      :items="meals"
                      :items-per-page="itemsPerPage"
                      :loading="loading"
                      :page.sync="page"
                      @page-count="pageCount = $event"
                      :server-items-length="total_meals"
                      @pagination="fetchData"
                    >
                      <template v-slot:no-data>
                        No Data Found
                      </template>
                    </v-data-table>
                    <div class="text-center pt-2">
                      <v-pagination
                        v-model="page"
                        color="orange"
                        :total-visible="7"
                        :length="pageCount"
                      ></v-pagination>
                    </div>
                  </v-card>
              </v-flex>
          </v-layout>
      </v-container>
    </div>
    <AddSetting
    v-if="!on_menu"
    />
  </div>
</template>

<script>
  import AddSetting from '../smtp/add.vue'
    export default {
    components: {
      AddSetting,
    },
    data() {
      return {
        current_page: 1,
        search: '',
        pageCount: 0,
        itemsPerPage: null,
        total_meals: 0,
        page: 1,
        url: '',
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
    methods: {
      toggleOnCreate() {
        console.log("click")
        this.on_menu = false
      },
      toggleOffCreate() {
        this.on_menu = true
      },
      fetchData(page) {
        this.current_page = page.page
        this.index()
      },
      set_data_fromServer(data) {
        this.meals = data.data
        this.total_meals = data.total
        this.itemsPerPage = data.per_page
        this.pageCount = data.last_page
      },
      index() {
        this.url = 'smtp/pagination?page='+this.current_page+ '&keyword=' +this.search
        this.loading = true
        if (this.timer) {
          clearTimeout(this.timer);
          this.timer = null;
        }
        this.timer = setTimeout(() => { 
          axios.get(this.url).then(({data}) => {
            this.set_data_fromServer(data)
            this.loading = false
          })
        }, 800);
      },

    },
  }
</script>