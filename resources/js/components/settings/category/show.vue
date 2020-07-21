<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Item Categories</v-toolbar-title>
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
                                            <v-flex xs6>
                                                <div class="preview" >
                                                    <v-img
                                                        max-height="200"
                                                        class="mx-auto"
                                                        max-width="200"
                                                        contain=""
                                                        :src="category.icon || 'https://thumbs.dreamstime.com/b/no-image-available-icon-photo-camera-flat-vector-illustration-132483141.jpg' "
                                                    >
                                                    </v-img>
                                                </div>
                                            </v-flex>
                                            <v-flex xs6>
                                                <v-file-input small-chips
                                                    accept="image/*"
                                                    label="Icon"
                                                    @change="onFileChange"
                                                    v-validate="'image'"
                                                    :error-messages="errors.collect('Icon')"
                                                    data-vv-name="Icon">
                                                </v-file-input>
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
                                                    save category
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
                        disable-pagination
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
                                    <v-list-item @click="show_category(item.id)" >
                                        <v-list-item-icon class="mr-0">
                                            <v-icon size="20" color="primary">mdi-eye</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>
                                            View
                                        </v-list-item-title>
                                    </v-list-item>
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
                 <v-dialog
                    v-model="subcat_dialog"
                    max-width="1000"
                    >
                    <v-card>
                        <v-card-title class="headline">{{categories_subcategories.name}} list of sub categories</v-card-title>
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex xs12 sm6>
                                    <v-form ref="form">
                                        <v-container  grid-list-md>
                                            <v-layout row wrap>
                                                <v-flex xs12 >
                                                    <v-card class="pa-5" >
                                                        <v-layout row wrap mb-3 class="text-capitalize">
                                                            <v-flex xs12>
                                                                <p class="subheading pa-0 font-weight-bold">add subcategory</p>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-text-field
                                                                    type="text"
                                                                    v-model="subcat.name"
                                                                    v-validate="'required'"
                                                                    :error-messages="errors.collect('Category Name')"
                                                                    data-vv-name="Category Name"
                                                                    label=" Name" required>
                                                                </v-text-field>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap mb-3 justify-end>
                                                            <v-flex xs12 class="text-right">
                                                                <v-btn color="success" small tile @click="subcategory_save"  >
                                                                    <v-icon left>mdi-content-save-edit-outline</v-icon>
                                                                    save
                                                                </v-btn>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-card>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                    </v-form>
                                </v-flex>
                                <v-flex xs12 sm6>
                                    <v-simple-table class="elevation-1">
                                        <template v-slot:default>
                                        <thead>
                                            <tr>
                                            <th class="text-left">Name</th>
                                            <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item ,index) in categories_subcategories.subcategories" :key="index">
                                            <td>{{item.name}}</td>
                                            <td><v-icon color="info" small>mdi-pencil</v-icon> <v-icon color="error" small @click="delete_sub(item , index)">mdi-delete</v-icon></td>
                                            </tr>
                                        </tbody>
                                        </template>
                                    </v-simple-table>
                                </v-flex>
                            </v-layout>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text  @click="subcat_dialog = false" > OKAY </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
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
            subcat_dialog:false,
            no_items:true,
            subcat: {
                'name' : '',
                'category_id' :''
            },
            categories: [],
            categories_subcategories:[],
            max_height: '100px',
            category : {
                name: '',
                id :'',
                icon:''
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
          { text: 'Subcat count', value: 'subcat' },
          { text: 'actions', value: 'action' },
        ],
        }),
        methods: {
            onFileChange(files) {
                // var files = e.target.files || e.dataTransfer.files;

                if (files == "") {
                    return
                }

                this.createImage(files);
            },
            createImage(file) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.category.icon = e.target.result ;
                };
                reader.readAsDataURL(file);
            },
            delete_sub(item,index){
                let self = this ;
                 axios.delete('/subcategories/'+item.id, {})
                    .then(response => {
                        console.log(response.data)
                        self.categories_subcategories.subcategories.splice(index,1)

                    });
            },
            subcategory_save(){
                let self = this ;
                 axios.post('/subcategories', this.subcat )
                    .then(function (response) {
                        console.log(response.data , 'subcat')
                        alert('save')
                        self.categories_subcategories.subcategories.unshift(response.data)
                        self.subcat.name = '';
                        self.clear()
                    })
            },
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
                                        dis.category.id= ''
                                         alert('updated')

                                    })
                                } else {
                                axios.post('/category', this.category )
                                .then(function (response) {
                                    dis.get_categories()
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
                this.$root.$confirm('Are you sure you want to delete ?').then((result) => {
                    if(result) {
                        axios.delete('/category/'+id, {})
			            .then(response => {
                            console.log(response.data)
                            this.get_categories()
                            this.clear()
                            alert('delete')
			            });
                    }
                })

            },
            show_category(id) {
                axios.get('/category/'+id+'/edit', {})
			    .then(response => {
                    this.categories_subcategories = response.data ;
                });
                this.subcat_dialog = true ;
                this.subcat.category_id = id ;
            },
            get_category_edit(id) {
                axios.get('/category/'+id+'/edit', {})
			    .then(response => {
                    this.category = response.data
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
