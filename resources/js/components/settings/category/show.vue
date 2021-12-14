<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">{{$t('settings.category.item_categories')}}</v-toolbar-title>
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
                                                <p class="subheading pa-0 font-weight-bold">{{$t('settings.category.category_information')}}</p>
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
                                                    @change="onFileChange('cat', $event)"
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
                                                    {{$t('settings.category.save_category')}}
                                                </v-btn>
                                                <v-btn color="primary" tile @click="clear"  >
                                                    <v-icon left>mdi-lock-reset</v-icon>
                                                    {{$t('settings.category.reload_form')}}
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
                            height="auto"
                            hide-default-footer
                            class="elevation-1"
                            v-sortable-data-table
                            @sorted="saveOrder"
                            :page.sync="page"
                            @page-count="pageCount = $event"
                        >
                                            <template v-slot:item.name="{ item }">
                                                            <div class="cat-name">
                                                                <v-icon class='mr-2, '>mdi-drag</v-icon>
                                                                <span >{{ item.name }}</span>
                                                            </div>
                                            </template>

                                    <template v-slot:item.action="{ item }">
                                        <v-menu bottom origin="right center" transition="scale-transition">
                                            <template v-slot:activator="{ on }">
                                                <v-btn text color="primary" dark v-on="on" @click.stop>
                                                    <v-icon>mdi-dots-vertical</v-icon>
                                                </v-btn>
                                            </template>
                                            <v-list class="pa-0">
                                                <v-list-item @click.prevent="showcategory(item.id)" dense >
                                                    <v-list-item-icon class="mr-0">
                                                        <v-icon size="20" color="primary">mdi-eye</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title>
                                                        {{$t('settings.category.subcategories')}}
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item @click="get_category_edit(item.id)" dense>
                                                    <v-list-item-icon class="mr-0">
                                                        <v-icon size="20" color="primary">mdi-pencil</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title>
                                                        {{$t('settings.category.edit')}}
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item @click="destroy(item.id)" dense>
                                                    <v-list-item-icon class="mr-0">
                                                        <v-icon size="20" color="error">mdi-delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title>
                                                        {{$t('settings.category.delete')}}
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                        </v-data-table>
                        <v-pagination
                            v-model="page"
                            color="orange"
                            :total-visible="50"
                            :length="pageCount"
                            circle
                        ></v-pagination>
                </v-flex>
                 <v-dialog
                    v-model="subcat_dialog"
                    max-width="1000"
                    >
                    <v-card>
                        <v-card-title class="headline">{{categories_subcategories.name}}  {{$t('settings.category.list_of_subcategories')}}</v-card-title>
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
                                                                <p class="subheading pa-0 font-weight-bold">{{$t('settings.category.add_subcategory')}}</p>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <div class="preview mx-auto" >
                                                                    <v-img
                                                                        max-height="200"
                                                                        class="mx-auto"
                                                                        max-width="200"
                                                                        contain=""
                                                                        :src="subcat.icon || 'https://thumbs.dreamstime.com/b/no-image-available-icon-photo-camera-flat-vector-illustration-132483141.jpg' "
                                                                    >
                                                                    </v-img>
                                                                </div>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-file-input small-chips
                                                                    accept="image/*"
                                                                    label="Icon"
                                                                    @change="onFileChange('subcat',$event)"
                                                                    v-validate="'image'"
                                                                    :error-messages="errors.collect('Icon')"
                                                                    data-vv-name="Icon">
                                                                </v-file-input>
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
                                                                    {{$t('settings.category.save')}}
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
                                    <v-data-table
                                        :headers="headers2"
                                        height="auto" fixed-header
                                        :items="categories_subcategories.subcategories"
                                        hide-default-footer
                                        v-sortable-data-table
                                        @sorted="saveOrder2"
                                        class="elevation-1"
                                        :page.sync="page2"
                                        @page-count="pageCount2 = $event"
                                    >
                                        <template v-slot:item.name="{item}">
                                            <div class="cat-name">
                                                <v-icon class='mr-2, '>mdi-drag</v-icon>
                                                <span >{{ item.name }}</span>
                                            </div>
                                        </template>
                                        <template v-slot:item.actions="{item}">
                                            <v-btn
                                                color="info"
                                                text
                                                icon
                                            >
                                                <v-icon color="info" small @click="get_sub(item.id)">mdi-pencil</v-icon>
                                            </v-btn>
                                            <v-btn
                                                color="error"
                                                text
                                            >
                                               <v-icon color="error" small @click="delete_sub(item , index)">mdi-delete</v-icon>
                                            </v-btn>
                                        </template>

                                        <template v-slot:item.icon="{item}">
                                            <v-img
                                                max-height="50"
                                                class="mx-auto"
                                                max-width="60"
                                                contain=""
                                                :src="item.icon"
                                                >
                                            </v-img>
                                        </template>
                                    </v-data-table>
                                    <v-pagination
                                        v-model="page2"
                                        color="orange"
                                        :total-visible="5"
                                        :length="pageCount2"
                                        circle
                                    ></v-pagination>

                                </v-flex>
                            </v-layout>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text  @click="subcat_dialog = false" >{{$t('settings.category.okay')}}</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
            </v-layout>
        </v-container>
    </div>
</template>
<script>

import Sortable from "sortablejs";

export default {
        $_veeValidate: {
            validator: 'new'
        },
        data: () => ({
            page:1,
            page2: 1,
            pageCount: 0,
            pageCount2: 0,
            category_idChan:{},
            isDragging: true,
            items:'',
            item:'',
            index:'',
            subCategories: [],
            getAll:'',

            default_footer:true,
            subcat_dialog:false,
            no_items:true,
            subcat: {
                name : '',
                category_id :'',
                icon:'',
                id: ''
            },
            categories: [],
            sub_count:'',
            items_count:'',
            categories_subcategories:[],
            max_height: '100px',
            category : {
                name: '',
                id :'',
                icon:''
            },
        //     headers: [
        //   {
        //     text: 'Category Name',
        //     align: 'left',
        //     sortable: false,
        //     value: 'name',
        //   },
        //   ,
        //   { text: 'items count', value: 'count' },
        //   { text: 'Subcat count', value: 'subcat' },
        //   { text: 'actions', value: 'action' },
        // ],
            // headers2:[
            //     {text:'Icons', align:'start', value:'icon', width:'25%'},
            //     {text:'Name', align:'start', value:'name', width:'30%'},
            //     {text:'Actions', value:'actions', align:'left'},
            // ]
        }),

        mounted: {
            headers(){
                return [
                     {text:this.$t('settings.category.category_name'), value: 'name', width: '20%'},
                     {text:this.$t('settings.category.item_count'), value: 'count', width: '20%'},
                     {text:this.$t('settings.category.subcategory_count'), value: 'subcat', width: '20%'},
                     {text:this.$t('settings.category.action'), value: 'action', width: '20%'},
                ];

            },
            headers2(){
                return [
                     {text:this.$t('settings.category.icons'), value: 'icon', width: '20%'},
                      {text:this.$t('settings.category.name'), value: 'name', width: '20%'},
                      {text:this.$t('settings.category.action'), value: 'action', width: '20%'},
                ]

            }
        },
        methods: {
            onFileChange(hint,files) {
                // var files = e.target.files || e.dataTransfer.files;

                if (files == "") {
                    return
                }

                var reader = new FileReader();
                reader.onload = (e) => {
                    hint === 'cat' ?  this.category.icon = e.target.result : this.subcat.icon = e.target.result ;
                };
                reader.readAsDataURL(files);
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
                const id = this.subcat.id
                if(id != ''){
                    axios.put('/subcategories/'+id, this.subcat )
                    .then(function (response) {
                        console.log(response.data , 'subcat')
                        alert('save')
                        self.subcatclear()
                        self.showcategory(response.data.category_id)
                    })
                }
                else {
                    axios.post('/subcategories', this.subcat )
                    .then(function (response) {
                        console.log(response.data , 'subcat')
                        alert('else save')
                        self.get_categories()
                        self.categories_subcategories.subcategories.unshift(response.data)
                        self.subcatclear()
                    })
                }
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
            showcategory(id) {
                console.log(id, 'id category')
                axios.get('/category/'+ id +'/edit', {})
			    .then(data => {
                    console.log(data.data, "chan here subcategory")
                    this.categories_subcategories = data.data

                    console.log(this.categories_subcategories, "chan here subcategory final")
                });
                this.subcat_dialog = true ;
                this.subcat.category_id = id ;
            },
            get_sub(id) {
                axios.get('/subcategories/'+id+'/edit', {})
			    .then(response => {
                    this.subcat = response.data
			    });
            },
            get_category_edit(id) {
                axios.get('/category/'+id+'/edit', {})
			    .then(response => {
                    this.category = response.data
			    });
            },
            subcatclear() {
               this.$validator.reset()
                this.$refs.form.reset()
                for (var key in this.subcat ) {
                    this.subcat[key] = '';
                }
            },
            clear () {
                this.$validator.reset()
                this.$refs.form.reset()
                for (var key in this.category ) {
                    this.category[key] = '';
                }
            },
            get_categories() {

                axios.get('api/getAll')
                .then(response =>{
                console.log(response.data, 'chandun get all')
                    this.getAll = response.data
                });

                axios.get('category', {})
			    .then(response => {
                    // let category = response.data.filter(chan_filter=>
                    //     chan_filter.id != 2
                    // )
                    this.categories = response.data;
                    console.log(response.data, 'chan here category data here');
                    this.data_loaded = true;
			    });
            },
            updatePosition(){
                console.log(this.categories, 'chan nakapasok')

                this.categories.forEach((chan_categor, key)=> {
                    console.log('Key' + key + '' + chan_categor.name)
                });

                let postCat = {};

                postCat.categories = this.categories.map(chan_categor => {
                    return {
                        position: chan_categor.id,
                        name: chan_categor.name,
                        id:chan_categor.id,
                    }
                });
                console.log(postCat, 'chan category update postcat')

                axios.post('/api/update_catPos', postCat).then(response=>{
                    console.log(response.data, 'chan category update')
                }).catch(error=>{
                    console.log(error)
                })
            },
            updatePosition2(){
                console.log(this.categories_subcategories.subcategories, "subcategory chan")

                 this.categories_subcategories.subcategories.forEach((chan_categor2, key)=> {
                    console.log('Key' + key + '' + chan_categor2.name)
                });

                this.subCategories = this.categories_subcategories.subcategories

                let postSubCat = {};

                postSubCat.subCategories =
                this.subCategories.map(chan_categor2 => {
                    return {
                        sub_position: chan_categor2.id,
                        name: chan_categor2.name,
                        id:chan_categor2.id
                    }
                });
                console.log(postSubCat, 'chan category update postcat2')
                axios.post('/api/update_subCatPos', postSubCat).then(response=>{
                    console.log(response.data, 'chan subCategory update 2')
                }).catch(error=>{
                    console.log(error)
                })

            },
            saveOrder (event) {
                const movedItem = this.categories.splice(event.oldIndex, 1)[0];
                this.categories.splice(event.newIndex, 0, movedItem);

                this.updatePosition()
            },
             saveOrder2 (event) {
                const movedItem = this.categories_subcategories.subcategories.splice(event.oldIndex, 1)[0];
                this.categories_subcategories.subcategories.splice(event.newIndex, 0, movedItem);
                this.updatePosition2()
            },
        },

        created() {
            this.get_categories()
	    },
        directives: {
            sortableDataTable: {
                bind (el, binding, vnode) {
                    const options = {
                        animation: 150,
                        onUpdate: function (event) {
                            vnode.child.$emit('sorted', event)
                        }
                    }
                    Sortable.create(el.getElementsByTagName('tbody')[0], options)
                }
            }
        },
}
</script>
<style scoped>
    .my_table {
        max-height: 100px !important ;
    }
    .cat-name{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 138px;
        cursor:all-scroll;
    }
</style>
