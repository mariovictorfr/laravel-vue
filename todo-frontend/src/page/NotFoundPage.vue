<template>
  <div class="not-found-bg">
    <div class="not-found d-flex justify-content-center align-items-center">
      <div class="row shadow-lg p-5 bg-white not-found-content rounded-lg">
        <div class="col-12 py-4">
          <h1 class="text-center mb-4 display-1">404</h1>
          <div class="text-center text-secondary mb-4">A página que você procura não existe.</div>
          <div class="text-center">
            <b-button to="/" variant="outline-primary">Voltar ao Início</b-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style>
* {
  font-family: 'Lato', sans-serif;
}

.not-found-bg {
  margin: 0;
  background: url('https://source.unsplash.com/collection/77928748/1600x900') no-repeat;
  background-size: cover;
  backdrop-filter: blur(3px);
}

.not-found {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  background: rgba(20, 136, 204, 0.5);
  background: -webkit-linear-gradient(to right, rgba(20, 136, 204, 0.85), rgba(0, 114, 255, 0.5));
  background: linear-gradient(to right, rgba(20, 136, 204, 0.85), rgba(0, 114, 255, 0.5));
  height: 100vh;
}

.not-found-content {
  background-color: #efefef;
  height: v100;
  border-bottom: 1px;
}
</style>
