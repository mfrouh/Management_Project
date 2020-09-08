require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue';
import { BootstrapVue } from 'bootstrap-vue';
import { BPagination } from 'bootstrap-vue';
Vue.component('b-pagination', BPagination);

// Install BootstrapVue
Vue.use(BootstrapVue);

Vue.component('notes',require('./components/note.vue').default);
Vue.component('tasks',require('./components/task.vue').default);
Vue.component('project',require('./components/project.vue').default);
Vue.component('projects',require('./components/projects.vue').default);



var note = new Vue({
    el: '#note',
    data: {

    }
  });
