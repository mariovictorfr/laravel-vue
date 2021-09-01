<template>
  <footer class="footer">
    <a href="https://github.com/mariovictorfr" target="_blank">Desenvolvido por Mario Victor</a>
  </footer>
</template>

<script>
export default {}
</script>

<style>
.footer {
  grid-area: footer;
  background: #333;
  color: #aaa;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-right: 20px;
}

.footer a {
  text-decoration: none;
  color: #aaa;
}

.footer a:hover {
  text-decoration: none;
  color: #fff;
}
</style>
