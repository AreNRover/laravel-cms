import Vue from "vue";
import VueRouter from "vue-router";
import router from "./router/router";
import moment from "moment";
import Swal from "sweetalert2";
import VueProgressBar from 'vue-progressbar'
import { Form, HasError, AlertError } from 'vform' ;
import Gate from "./Gate";
import VueResource from "vue-resource";
import { store } from "./store/store";


Vue.prototype.$gate = new Gate(window.user);

window.Form = Form ;
Vue.use(VueRouter);
Vue.use(VueResource);
require('./bootstrap');
window.Vue = require('vue');
window.Swal = Swal ;


Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('pagination', require('laravel-vue-pagination'));


const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'left',
    inverse: false
}

Vue.use(VueProgressBar , options);


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast ;




Vue.filter('upText' , function (text){
   return text.charAt(0).toUpperCase() + text.slice(1);
});
Vue.filter('myDate' , function (created){
    return moment(created).format('MMMM Do YYYY')
});


window.Fire = new Vue();


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);


const app = new Vue({
    el: '#app',
    router,
    store,
    data:{
        search : '',
    },
    methods: {
        searchIt: _.debounce(() => {
            Fire.$emit('searching');
        }, 2000)
    }


});
