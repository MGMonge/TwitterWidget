require('./jquery-widget')

import Vue from 'vue'

window.Vue = Vue

Vue.component('twitter-widget', require('./components/TwitterWidget').default)

new Vue({
    el: '.page'
})
