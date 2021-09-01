<template>
  <div class="user">
    <b-card class="border-0 shadow-sm" title="Usuários" sub-title="Gerenciamento de Usuários">
      <hr class="my-4" />
      <b-overlay :show="loading" rounded="sm">
        <b-card-text>
          <b-row>
            <b-col cols="12" sm="8" md="6">
              <div class="input-group mb-3">
                <input
                  v-model="search"
                  type="text"
                  id="search"
                  class="form-control"
                  placeholder="Busca..."
                  @keyup.enter="getUsers"
                />
                <div class="input-group-append">
                  <b-button class="btn btn-secondary" type="button" @click.prevent="getUsers">
                    <b-icon icon="search"></b-icon>
                  </b-button>
                </div>
              </div>
            </b-col>
            <b-col cols="12" sm="4" md="6" class="text-right">
              <b-button variant="outline-primary" to="/users/create">
                <b-icon icon="person-plus-fill" class="mr-2"></b-icon>
                Cadastrar Usuário
              </b-button>
            </b-col>
            <b-col cols="12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>
                      {{ user.id }}
                    </td>
                    <td>
                      {{ user.name }}
                    </td>
                    <td>
                      {{ user.email }}
                    </td>
                    <td class="action text-right">
                      <b-button
                        size="sm"
                        class="mr-4"
                        variant="light"
                        :to="`/users/update/${user.id}`"
                      >
                        <b-icon icon="pencil-fill"></b-icon>
                      </b-button>

                      <b-button
                        size="sm"
                        class="mr-3"
                        variant="light"
                        @click.prevent="deleteUser(user.id)"
                      >
                        <b-icon icon="trash-fill"></b-icon>
                      </b-button>
                    </td>
                  </tr>
                  <tr v-if="users.length === 0 && !loading">
                    <td colspan="4" class="text-center">Nenhum resultado encontrado.</td>
                  </tr>
                </tbody>
              </table>
            </b-col>
          </b-row>
        </b-card-text>
      </b-overlay>
    </b-card>
  </div>
</template>

<script>
import axios from 'axios'
import showError from '@/config/showError'

export default {
  data() {
    return {
      users: [],
      loading: false,
      search: '',
    }
  },

  methods: {
    async getUsers() {
      this.loading = true
      await axios
        .get(`${process.env.VUE_APP_API_URL}/users`, { params: { search: this.search } })
        .then((res) => {
          this.users = res.data
          this.loading = false
        })
        .catch(showError)
    },

    async deleteUser(id) {
      this.loading = true
      await axios
        .delete(`${process.env.VUE_APP_API_URL}/users/${id}`)
        .then((res) => {
          this.$toasted.success(res.data)
          this.loading = false
          this.getUsers()
        })
        .catch(showError)
    },
  },

  created() {
    this.getUsers()
  },
}
</script>

<style>
.action > .btn {
  padding: 0.2rem 0.5rem;
}
.action > .btn > .b-icon {
  width: 0.8rem;
  height: 0.8rem;
}

.action > .btn {
  opacity: 0.2 !important;
}

tr:hover .action > .btn {
  opacity: 1 !important;
}
</style>
