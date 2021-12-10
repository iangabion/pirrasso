<template>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
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
</template>
<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
      dialog: false,
      drawer: null,
      items: [
        { icon: 'mdi-view-dashboard', text: 'Dashboard' ,url:'/dashboard' },
        { icon: 'mdi-history', text: 'Items' ,url:'/items' },
        { icon: 'mdi-account-group', text: 'Sellers' ,url:'/sellers' },
        {
          icon: 'mdi-settings',
          'icon-alt': 'mdi-settings',
          text: 'Settings',
          model: false,
          children: [
            { icon: 'mdi-tab', text: 'Items Categories' , url:'/categories' },
            { icon: 'mdi-new-box', text: 'Items Status' , url:'/statuses' },
            { icon: 'mdi-image', text: 'Apps Images' , url:'/apps_images' },
            { icon: 'mdi-email-newsletter', text: 'Email SMTP Settings' , url:'/smtp' },
            { icon: 'mdi-message-processing', text: 'SMS Sender Settings' , url:'/sms' },
          ],
        },
      ],
    }),
  }
</script>