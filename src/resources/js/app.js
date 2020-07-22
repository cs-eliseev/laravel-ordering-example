'use strict';

import Vue from 'vue';
import http from './http';
import Select2 from 'v-select2-component';
import Order from "./vue/Order";
import datePicker from 'vue-bootstrap-datetimepicker';

Vue.component("datePicker", datePicker);

Vue.component("Select2", Select2);
Vue.prototype.$http = http;

new Vue({
    el: '#app',
    components: {
        Order
    },
});
