<template>
    <v-dialog v-model="dialog" width="600" persistent>
        <v-card>
            <v-card-title class="text-h5 grey lighten-2">
                {{$t('approved_items.disapproved_dialog.disapprovement_notice')}}
            </v-card-title>
            <v-card-text>
                <v-container fluid>
                    <v-row>
                        <v-flex xs12>
                            <v-textarea
                                label="Reason For Disapprovement"
                                solo
                                v-model="payload.reason"
                                filled
                            ></v-textarea>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                dense
                                label="Send To"
                                :value="item.client ? item.client.email : 'test@test.com'"
                                outlined
                                disabled
                            ></v-text-field>
                        </v-flex>
                         <v-flex xs12>
                            <v-text-field
                                dense
                                disabled
                                :value="item.title"
                                label="Item Name"
                                outlined
                            ></v-text-field>
                        </v-flex>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="primary"
                    small
                    width="70px"
                    @click.prevent="sendMail()"
                     @click="progress_circular = true"
                >
                    {{$t('send')}}
                </v-btn>
                <v-btn
                    color="error"
                    small
                    width="70px"
                    @click="$emit('close')"
                >
                    {{$t('cancel')}}
                </v-btn>
            </v-card-actions>
        </v-card>
        <v-dialog       
            v-model="progress_circular"
            max-width="100"
            persistent
        >
            <v-card>
                <v-card-text class="text-xs-center pt-1">
                    <v-progress-circular :size="50" indeterminate class="primary--text"/>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-dialog>
</template>
<script>
import { DisapproveMail, RemoveDisapproveItem } from "@api/item.api";
export default {
    data(){
        return {
            payload: {
                reason: ''
            },
            interval: {},
            value: 0,
            progress_circular : false,
        }
    },
    props: {
        'dialog':{
            default: false,
            type: Boolean
        },
        'item':{
            required:true,
            type: Object
        },
    },

    methods: {
        closedisapproved() {
            this.$emit('closedisapproved');
        },
        sendMail() {
            alert('Proceed');
            this.progress_circular = true;
            DisapproveMail (this.payload).then((response) => {
                this.progress_circular = false;
                RemoveDisapproveItem(this.payload.id).then((response) => {
                    console.log(response.data)
                    this.loading = false
                    this.$emit('closedisapproved');
                    alert('Message Sent Successfull');
                })
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    watch : {
        'item'() {
            this.payload = this.item
        },
        progress_circular (val) {
            if (!val) return setTimeout(() => (this.progress_circular = false), 3000)
        },
    }
}
</script>
