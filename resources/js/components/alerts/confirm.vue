<template>
	<v-dialog v-model="dialog" width="650" :max-width="options.width" :style="{ zIndex: options.zIndex }" @keydown.esc="cancel">
		<v-card>
		<!-- <v-toolbar dark dense flat class="headline grey lighten-2">
			<v-toolbar-title class="headline grey lighten-2">{{ title }}</v-toolbar-title>
		</v-toolbar> -->
		<v-card-title class="headline blue lighten-5" primary-title>{{title}}</v-card-title>
		<v-card-text class="pa-3" v-show="!!message" v-html="message"></v-card-text>
		<v-card-actions class="pt-0">
			<v-spacer></v-spacer>
             <v-btn class="ma-2 px-5" tile outlined color="success" @click.native="agree">
                <v-icon left>mdi-check</v-icon> OKAY   
            </v-btn>
            <v-btn class="ma-2 px-5" tile outlined color="success" @click.native="cancel">
                <v-icon left>mdi-cancel</v-icon> CANCEL
            </v-btn>
		</v-card-actions>
		</v-card>
	</v-dialog>
</template>

<script>
    export default {
        data: () => ({
            dialog: false,
            resolve: null,
            reject: null,
            message: null,
            title: null,
            options: {
				color: 'primary',
				width: 700,
				zIndex: 200
            }
        }),
        methods: {
            open( message , title = 'Confirm this action! ', options) {
              this.dialog = true
              this.title = title
              this.message = message
              this.options = Object.assign(this.options, options)
              return new Promise((resolve, reject) => {
                  this.resolve = resolve
                  this.reject = reject
              })
            },
            agree() {
                this.resolve(true)
                this.dialog = false
            },
            cancel() {
                this.resolve(false)
                this.dialog = false
            }
        }
    }
</script>
<style>
.v-dialog .v-card {
    border-radius:0px !important;
}

.v-dialog .v-card__text {
    font-size: 19px;
    padding: 25px!important;
}
</style>
