<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Categories</v-toolbar-title>
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
                                                <p class="subheading pa-0 font-weight-bold">Category Information</p>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-text-field 
                                                    type="text"
                                                    v-model="category.name"
                                                    v-validate="'required'" 
                                                    :error-messages="errors.collect('Category Name')" 
                                                    data-vv-name="Category Name" 
                                                    label="Category Name" required>
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap mb-3 justify-end>
                                            <v-flex xs12 class="text-right">
                                                <v-btn color="success" tile @click="submit"  >
                                                    <v-icon left>mdi-content-save-edit-outline</v-icon>
                                                    save seller
                                                </v-btn>
                                                <v-btn color="primary" tile @click="clear"  >
                                                    <v-icon left>mdi-lock-reset</v-icon>
                                                    reload form
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
                        :items="categories"
                        height="430"
                        hide-default-footer
                        class="elevation-1"
                    >
                        <template v-slot:item.action="{ item }">
                             <v-menu bottom origin="right center" transition="scale-transition">
                                <template v-slot:activator="{ on }">
                                    <v-btn text color="primary" dark v-on="on" @click.stop>
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>
                                <v-list class="pa-0">
                                    <v-list-item @click="get_category_edit(item.id)" >
                                        <v-list-item-icon class="mr-0">
                                            <v-icon size="20" color="primary">mdi-pencil</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>
                                            Edit
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item @click="destroy(item.id)" >
                                        <v-list-item-icon class="mr-0">
                                            <v-icon size="20" color="error">mdi-delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>
                                            Delete
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
            no_items:true,
            categories: [],
            max_height: '100px',
            category : {
                name: '',
                id :''
            },
            headers: [
          {
            text: 'Category Name',
            align: 'left',
            sortable: false,
            value: 'name',
          },
          ,
          { text: 'items count', value: 'count' },
          { text: 'actions', value: 'action' },
        ],
        }),
        methods: {
            submit(){
                let self = this;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.$root.$confirm('Are you sure you want to save ?').then((result) => {
                            if(result) {
                                let dis = this ;
                                let id = this.category.id ;
                                if(id != '' ) {
                                    axios.put('/category/'+id, this.category )
                                    .then(function (response) {
                                        console.log(response.data)
                                        dis.get_categories()
                                        dis.clear()
                                        id = ''
                                        alert('updated')
                                    })
                                } else {
                                axios.post('/category/', this.category )
                                .then(function (response) {
                                    dis.get_categories()
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
                axios.delete('/category/'+id, {})
			    .then(response => {
                    let self = this;
                    console.log(response.data)
                    self.get_categories()
                    alert('delete')
			    });
            },
            get_category_edit(id) {
                axios.get('/category/'+id+'/edit', {})
			    .then(response => {
                    console.log(response.data)
                    this.category.name = response.data.name ;
                    this.category.id = response.data.id ;
			    });
            },
            clear () {
                this.$validator.reset()
                this.$refs.form.reset()
            },
            get_categories() {
                axios.get('/category', {})
			    .then(response => {
                    this.categories = response.data;
                    console.log(this.categories)
                    this.data_loaded = true;
			    });
            }
        },
        created() {
            this.get_categories()
	    },
    }
</script>
<style scoped>
    .my_table {
        max-height: 100px !important ;
    }
</style>