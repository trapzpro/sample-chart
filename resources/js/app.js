import { createApp } from 'vue';


const app = createApp({});

// Import all the components automatically
Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

app.mount("#app");

//bootstrap
import './bootstrap.js';
