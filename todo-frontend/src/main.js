import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from "axios";

import "./config/toasted";
import "./config/bootstrap";

Vue.config.productionTip = false;

const token = localStorage.getItem("__todo-token");
if (token) {
  axios.defaults.headers.common["Authorization"] = `bearer ${token}`;
}

console.log('aqui '+process.env.VUE_APP_API_URL)

new Vue({
  router,
  store,
  axios,
  render: (h) => h(App),
}).$mount("#app");
