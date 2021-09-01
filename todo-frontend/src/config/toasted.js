import Vue from "vue";
import Toasted from "vue-toasted";

Vue.use(Toasted, {
  iconPack: "fontawesome",
  duration: 5000,
  position: "bottom-center",
});

Vue.toasted.register(
  "defaultSuccess",
  (payload) => (!payload.msg ? "Operação realizada com sucesso." : payload.msg),
  { type: "success", icon: "check" }
);

Vue.toasted.register(
  "defaultError",
  (payload) => (!payload.msg ? "Erro inesperado." : payload.msg),
  { type: "error", icon: "times" }
);
