import { createApp } from 'vue';

import HighchartsVue from 'highcharts-vue'
import Highcharts from 'highcharts'
import stockInit from 'highcharts/modules/stock'
import mapInit from 'highcharts/modules/map'
// import addWorldMap from './js/worldmap'

// stockInit(Highcharts)
// mapInit(Highcharts)
// addWorldMap(Highcharts)



const app = createApp({});
app.use(HighchartsVue)

// Import all the components automatically
Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

app.mount("#app");

//bootstrap
import './bootstrap.js';
