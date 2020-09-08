import Vue from 'vue';

Vue.filter('reverse',function (param) {
      return  param.split("").reverse().join("");
});
