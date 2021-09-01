<template>
  <div class="main">
    <Header />
    <div class="content container">
      <router-view />
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from "@/template/Header";
import Footer from "@/template/Footer";

export default {
  name: "Content",
  components: { Header, Footer },
};
</script>

<style>
.main {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  height: 100vh;
  display: grid;
  grid-template-rows: 60px 1fr 40px;
  grid-template-columns: 1fr;
  grid-template-areas:
    "header"
    "content"
    "footer";
  background: #f0f0ff;
}

.content {
  grid-area: content;
  padding: 20px;
}

.content .card-body {
  padding: 20px;
}
</style>
