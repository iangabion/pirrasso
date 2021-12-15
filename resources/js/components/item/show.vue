<template>
    <div>
        <v-toolbar>
            <v-toolbar-title class="px-4">Items</v-toolbar-title>
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
            <v-btn @click="dialog2 = true" class="d-none">
                <v-icon class="mr-2">
                mdi-cart
                </v-icon>
                Add Setting
            </v-btn>
        </v-toolbar>
        <div>
            <v-container grid-list-xs>
                <v-card min-height="80vh">
                    <v-layout row wrap>
                        <v-flex xs2>
                            <v-list
                                color="primary"
                                dark
                                min-height="80vh"
                                class="my-2 ml-2"
                            >
                                <v-list-item
                                    dense
                                    v-for="(item) in 5" :key="item.id+'test'"
                                    style="cursor:pointer;"
                                    class="my-1"
                                >
                                    <v-list-item-icon>
                                        <v-icon>mdi-home</v-icon>
                                    </v-list-item-icon>

                                    <v-list-item-title>Home</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-flex>
                        <v-flex xs10>
                            <v-card min-height="80vh" class="ma-2">
                                asdasd
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-container>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            search:''
        }
    }
}
</script>
