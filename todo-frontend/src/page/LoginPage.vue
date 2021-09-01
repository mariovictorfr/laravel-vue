<template>
  <div class="login-bg">
    <div class="login d-flex justify-content-center align-items-center">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
* {
  font-family: "Lato", sans-serif;
}

.login-bg {
  margin: 0;
  background: url("https://source.unsplash.com/collection/4510513/1600x900")
    no-repeat;
  background-size: cover;
  backdrop-filter: blur(3px);
}

.login {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  background: rgba(20, 136, 204, 0.85);
  background: -webkit-linear-gradient(
    to right,
    rgba(20, 136, 204, 0.85),
    rgba(0, 114, 255, 0.85)
  );
  background: linear-gradient(
    to right,
    rgba(20, 136, 204, 0.85),
    rgba(0, 114, 255, 0.85)
  );
  height: 100vh;
}
</style>
