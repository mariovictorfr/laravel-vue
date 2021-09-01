<template>
  <header class="header shadow">
    <b-navbar toggleable="lg" type="dark" class="navbar">
      <b-navbar-brand to="/">Todo App</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item to="/users">Usuários</b-nav-item>
          <b-nav-item to="/tasks">Tarefas</b-nav-item>
        </b-navbar-nav>
        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template #button-content>
              {{ $store.getters.user.name }}
            </template>
            <b-dropdown-item @click.prevent="logout">Sair</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </header>
</template>

<script>
import showError from '@/config/showError'

export default {
  methods: {
    logout() {
      this.$store
        .dispatch('logout')
        .then(() => {
          this.$router.push('/login')
        })
        .catch(showError)
    },
  },
}
</script>

<style>
.header {
  grid-area: header;
  background: rgba(20, 136, 204, 0.85);
  background: -webkit-linear-gradient(to right, rgba(20, 136, 204, 0.85), rgba(0, 114, 255, 0.85));
  background: linear-gradient(to right, rgba(20, 136, 204, 0.85), rgba(0, 114, 255, 0.85));
  display: flex;
  justify-content: center;
  align-items: center;
}

.navbar {
  width: 100%;
}
</style>
