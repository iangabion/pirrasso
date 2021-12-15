<template>
    <div>
        this is test

        <v-btn @click="items()">
            items_get
        </v-btn>
    </div>
</template>
<script>

export default {
     data(){
        return {
            items2: []
        }
    },
    methods:{
        items(){
            axios.get('items').then(res=>{
                this.items2 = res.data

                console.log(this.items2)
            })
        }
    }
}
</script>