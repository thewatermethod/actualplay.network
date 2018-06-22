<template>
    <h1>{{stats}}</h1>
</template>
 
<script>
 
export default {
    
    components: {
    
    },
 
    data() {    
        return {
            stats: 0,   
        }
    },
 
    methods: {
        fetchStats: function(){

            const apiKey = 'sc_XyIm1Abxy_s2xP4bFPIRvQ';
            const headers = new Headers();
            headers.append( 'X-API-KEY', apiKey ); 

            // 
            //https://api.simplecast.com/v1/podcasts/{PODCAST_ID}/statistics.json

        }

    },
   
    mounted() {
        this.fetchStats();
    },
 
    props: [ 'podcast' ],
  
}
 
</script>
<style scoped>    
  
</style>