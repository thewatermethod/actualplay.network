import Vue from 'vue'
import Stats from './components/stats.vue'

const PodcastStatistics = new Vue({
    el: '#episodeStatistics',
    components: {
        Stats
    }
});

export default PodcastStatistics;