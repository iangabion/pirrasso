<template>
            <select v-model="lang" class="custom-select" @change="handleChange($event)">
                <option value="en"><h4 class="custom-select">English</h4></option>
                <option value="fr">France</option>
            </select>


</template>
<script>

export default {
    name: 'locale-changer',
    data: function(){
        const lang = localStorage.getItem('lang') || 'en';
        return {
             language: ['en', 'fr'],
            lang: lang
        }
    },
    methods: {
        handleChange(event){
            localStorage.setItem('lang', event.target.value);
            window.location.reload();
        }
    }
}
</script>
<style scoped>
.custom-select{
    background-color: #fff;
}
</style>