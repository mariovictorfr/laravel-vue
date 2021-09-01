<template>
  <aside class="menu py-3 shadow-sm">
    <b-nav vertical fill>
      <b-nav-item to="/" exact>
        <b-icon icon="house-fill" class="mr-3"></b-icon>
        Home
      </b-nav-item>
      <b-nav-item to="/user" exact>
        <b-icon icon="person-circle" class="mr-3"></b-icon>
        Usuários
      </b-nav-item>
      <b-nav-item to="/task" exact class="text-secondary">
        <b-icon icon="list-task" class="mr-3"></b-icon>
        Tarefas
      </b-nav-item>
    </b-nav>
  </aside>
</template>

<script>
export default {};
</script>

<style>
.menu {
  grid-area: menu;
  background: #fff;
}

.menu .nav-item {
  padding: 5px 0;
  font-weight: 700;
  font-size: 0.9rem;
}

.menu .nav-link {
  color: #777;
}

.menu .nav-link:hover {
  color: #333;
}

.menu .nav-item .router-link-active {
  padding: 0.5rem 0.7rem;
  border-left: 0.3rem solid rgb(20, 136, 204);
  color: rgb(20, 136, 204);
}
</style>
