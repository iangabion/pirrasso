<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">{{$t('settings.status.item_status')}}</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-container grid-list-xs>
            <v-layout row wrap>
                <v-flex xs12 sm6 >
                    <v-form ref="form">
                        <v-container  grid-list-md>
                            <v-layout row wrap>
                                <v-flex xs12 >
                                    <v-card class="pa-5" >
                                        <v-layout row wrap mb-3 class="text-capitalize">
                                            <v-flex xs12>
                                                <p class="subheading pa-0 font-weight-bold">{{$t('settings.status.status_information')}}</p>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-text-field
                                                    type="text"
                                                    v-model="statuses.name"
                                                    v-validate="'required'"
                                                    :error-messages="errors.collect('Status Name')"
                                                    data-vv-name="Status Name"
                                                    label="Status Name" required>
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap mb-3 justify-end>
                                            <v-flex xs12 class="text-right">
                                                <v-btn color="success" tile @click="submit"  >
                                                    <v-icon left>mdi-content-save-edit-outline</v-icon>
                                                    {{$t('settings.status.save_status')}}
                                                </v-btn>
                                                <v-btn color="primary" tile @click="clear"  >
                                                    <v-icon left>mdi-lock-reset</v-icon>
                                                     {{$t('settings.status.reload_form')}}
                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-form>
                </v-flex>
                <v-flex xs6 sm6 class="pa-4">
                    <v-data-table
                        :headers="headers"
                        fixed-header
                        :items="status"
                        height="430"
                        hide-default-footer
                        disable-pagination
                        class="elevation-1"
                    >
                        <template v-slot:item.action="{ item }">
                             <v-menu bottom origin="right center" transition="scale-transition">
                                <template v-slot:activator="{ on }">
                                    <v-btn icon color="primary" dark v-on="on" @click.stop>
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>
                                <v-list class="pa-0">
                                    <v-list-item @click="get_status_edit(item.id)" dense>
                                        <v-list-item-icon class="mr-0">
                                            <v-icon size="20" color="primary">mdi-pencil</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>
                                            {{$t('settings.status.edit')}}
                                         </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item @click="destroy(item.id)" dense>
                                        <v-list-item-icon class="mr-0">
                                            <v-icon size="20" color="error">mdi-delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>
                                            {{$t('settings.status.delete')}}
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </template>
                    </v-data-table>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>
<script>
    export default {
        $_veeValidate: {
            validator: 'new'
        },
        data: () => ({
            default_footer:true,
            status: [],
            max_height: '100px',
            statuses : {
                name: '',
                id :''
            },
            // headers: [
            //     { text: 'Status Name', align: 'left', sortable: false, value: 'name' },
            //     { text: 'Items Count',  value: 'count' },
            //     { text: 'actions', value: 'action' },
            // ],
        }),

        computed: {
            headers(){
                return [
                     { text: this.$t('settings.status.status_name'), align: 'left', sortable: false, value: 'name' },
                     { text: this.$t('settings.status.item_count'),  value: 'count' },
                     { text: 'actions', value: 'action' },
                ]
            }
        },
        methods: {
            submit(){
                let self = this;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.$root.$confirm(this.$t('settings.status.are_you_sure_you_want_to_save')).then((result) => {
                            if(result) {
                                let dis = this ;
                                let id = this.statuses.id ;
                                if(id != '' ) {
                                    axios.put('/status/'+id, this.statuses )
                                    .then(function (response) {
                                        console.log(response.data ,'updated')
                                        dis.get_status()
                                        dis.clear()
                                         alert('updated')

                                    })
                                } else {
                                axios.post('/status', this.statuses )
                                .then(function (response) {
                                    dis.get_status()
                                    console.log(response.data , ' saved')
                                    dis.clear()
                                     alert('saved')
                                })
                                }
                            }
                        })
                    }
                });
            },
            destroy(id){
                this.$root.$confirm(this.$t('settings.status.are_you_sure_you_want_to_delete')).then((result) => {
                    if(result) {
                        axios.delete('/status/'+id, {})
                        .then(response => {
                            console.log(response.data)
                            this.get_status()
                            this.clear()
                            alert('delete')
                        });
                    }
                });
            },
            get_status_edit(id) {
                axios.get('/status/'+id+'/edit', {})
			    .then(response => {
                    console.log(response.data)
                    this.statuses.name = response.data.name ;
                    this.statuses.id = response.data.id ;
			    });
            },
            clear () {
                this.$validator.reset()
                this.$refs.form.reset()
                this.statuses.id = ''
            },
            get_status() {
                axios.get('/status', {})
			    .then(response => {
                    this.status = response.data;
                    console.log(response.data)
                    // // this.data_loaded = true;
			    });
            }
        },
        created() {
            this.get_status()
	    },
    }
</script>
