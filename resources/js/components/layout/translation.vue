<template>
            <select v-model="lang" class="custom-select" @change="handleChange($event)">
                <option value="en">English</option>
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