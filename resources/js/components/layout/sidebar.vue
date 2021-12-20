<template>
    <v-navigation-drawer
    
      v-model="$store.state.sidebar"
      class="padding"
      app
    >
    <v-img contain
            src="/images/logo-c.png"
            size="1"
            max-height="90"
            max-width="180"
            class="mx-auto"
            />
      <v-list dense>
        <template v-for="item in items">
          <v-row
            v-if="item.heading"
            :key="item.heading"
            align="center"
          >
          </v-row>
          <v-list-group
            v-else-if="item.children"
            :key="item.text"
            v-model="item.model"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
          >
            <template v-slot:activator>
              <v-list-item
                >
                <v-list-item-content>
                  <v-list-item-title >
                    {{ item.text }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            <v-list-item
              v-for="(child, i) in item.children"
              :key="i"
              link :to="child.url"
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item
            v-else
            :key="item.text"
            link :to="item.url"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
      
    </v-navigation-drawer>
    <!-- <h1>dawd</h1> -->
</template>
<script>
// import logo from '/public/images/logo-c.png'
  export default {
    props: {
      source: String,
    },
    data: () => ({
      dialog: false,
      drawer: null,
    
      // items: [
      //   { icon: 'mdi-view-dashboard', text: 'Dashboard' ,url:'/dashboard' },
      //   { icon: 'mdi-history', text: 'Items' ,url:'/items' },
      //   { icon: 'mdi-account-group', text: 'Sellers' ,url:'/sellers' },
      //   { icon: 'mdi-check', text: 'Approved Items' ,url:'/approved_items' },
      //   {
      //     icon: 'mdi-settings',
      //     'icon-alt': 'mdi-settings',
      //     text: 'Settings',
      //     model: false,
      //     children: [
      //       { icon: 'mdi-tab', text: 'Items Categories' , url:'/categories' },
      //       { icon: 'mdi-new-box', text: 'Items Status' , url:'/statuses' },
      //       { icon: 'mdi-image', text: 'Apps Images' , url:'/apps_images' },
      //       { icon: 'mdi-email-newsletter', text: 'Email SMTP Settings' , url:'/smtps' },
      //       { icon: 'mdi-message-processing', text: 'SMS Sender Settings' , url:'/sms' },
      //     ],
      //   },
      // ],
    }),

    computed: {
       items(){
         return [
           { icon: 'mdi-view-dashboard', text: this.$t('sidebar.dashboard') ,url:'/dashboard' },
            { icon: 'mdi-history', text: this.$t('sidebar.items') ,url:'/items' },
            { icon: 'mdi-account-group', text: this.$t('sidebar.sellers') ,url:'/sellers' },
            { icon: 'mdi-check', text: this.$t('sidebar.approved_items'), url:'/approved_items' },
            {
              icon: 'mdi-settings',
              'icon-alt': 'mdi-settings',
              text: 'Settings',
              model: false,
              children: [
                { icon: 'mdi-tab', text: this.$t('sidebar.item_categories') , url:'/categories' },
                { icon: 'mdi-new-box', text: this.$t('sidebar.item_status') , url:'/statuses' },
                { icon: 'mdi-image', text: this.$t('sidebar.apps_images') , url:'/apps_images' },
                { icon: 'mdi-email-newsletter', text: this.$t('sidebar.email_smtp_settings'), url:'/smtps' },
                { icon: 'mdi-message-processing', text: this.$t('sidebar.sms_sender_settings') , url:'/sms' },
          ],
        },
         ]
       }
    }
  }
</script>
<style scoped>
.padding {
  padding-top: 2em;
}
</style>
