<template>
    <v-dialog v-model="dialog" width="600" persistent>
        <v-card>
            <v-card-title class="text-h5 grey lighten-2">
                Disapprovement Notice
            </v-card-title>

            <v-card-text>
                <v-container fluid>
                    <v-row>
                        <v-flex xs12>
                            <v-textarea
                                label="Reason For Disapprovement"
                                solo
                                v-model="reason"
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
                >
                    Send
                </v-btn>
                <v-btn
                    color="error"
                    small
                    width="70px"
                    @click="$emit('close')"
                >
                    Cancel
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    data(){
        return {
            reason: ''
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
    }
}
</script>
