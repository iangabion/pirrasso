<template>
            <select v-model="lang" class="ss" @change="handleChange($event)">
                <option value="en" class="ss">English</option>
                <option value="fr" class="ss">France</option>
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
.ss {
   color: rgb(133, 133, 131);
    
}


</style>