import Vue from "vue";

export function showError(e) {
  console.log(e);
  if (e && e.response && e.response.data.error) {
    Vue.toasted.global.defaultError({ msg: e.response.data.error });
  } else if (typeof e === "string") {
    Vue.toasted.global.defaultError({ msg: e });
  } else {
    Vue.toasted.global.defaultError(e);
  }
}

export default showError;
