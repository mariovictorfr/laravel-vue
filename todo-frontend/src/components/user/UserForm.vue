<template>
  <div class="user-create">
    <b-card class="border-0 shadow-sm" title="Usuários" sub-title="Cadastrar Usuários">
      <hr class="by-4" />
      <b-card-text>
        <b-row>
          <b-col cols="12" sm="8" offset-sm="2" md="6" offset-md="3">
            <b-form @submit.prevent="register">
              <b-form-group label="Nome" label-for="name">
                <b-form-input
                  id="name"
                  v-model="user.name"
                  type="text"
                  placeholder="Digite o seu nome..."
                  class="rounded-0"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group label="Email" label-for="email">
                <b-form-input
                  id="email"
                  v-model="user.email"
                  type="email"
                  placeholder="Digite o seu email..."
                  class="rounded-0"
                  required
                  :state="emailState"
                ></b-form-input>
                <b-form-invalid-feedback v-if="errors.email" :state="emailState">
                  <span v-for="error in errors.email" :key="error">
                    {{ error }}
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
              <b-form-group label="Senha" label-for="password">
                <b-form-input
                  id="password"
                  v-model="user.password"
                  type="password"
                  placeholder="Digite a sua senha..."
                  class="rounded-0"
                  :state="passwordState"
                ></b-form-input>
                <b-form-text id="password-help-block">
                  Sua senha deve ter pelo menos 6 caracteres.
                </b-form-text>
                <b-form-invalid-feedback v-if="errors.password" :state="passwordState">
                  <span v-for="error in errors.password" :key="error">
                    {{ error }}
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
              <b-form-group label="Confirmação de Senha" label-for="passwordConfirm">
                <b-form-input
                  id="passwordConfirm"
                  v-model="user.password_confirmation"
                  type="password"
                  placeholder="Confirme a sua senha..."
                  class="rounded-0"
                ></b-form-input>
              </b-form-group>
              <b-button type="submit" class="btn mr-4" :disabled="loading" variant="primary">
                <b-spinner small v-if="loading"></b-spinner>
                {{ loading ? 'Carregando...' : method === 'post' ? 'Cadastrar' : 'Atualizar' }}
              </b-button>
              <b-button
                type="submit"
                class="btn"
                :disabled="loading"
                variant="outline-secondary"
                to="/users"
              >
                Cancelar
              </b-button>
            </b-form>
          </b-col>
        </b-row>
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      user: {},
      loading: false,
      errors: [],
      method: 'post',
    }
  },

  methods: {
    async register() {
      this.loading = true
      this.errors = []

      let url = `${process.env.VUE_APP_API_URL}/users`
      if (this.method === 'put') {
        url = `${url}/${this.user.id}`
      }

      await axios[this.method](url, { ...this.user })
        .then((res) => {
          this.$toasted.success('Cadastro editado com sucesso.', {
            icon: 'check',
          })
          this.$router.push(`/users/update/${res.data.id}`)
          this.loading = false
        })
        .catch((err) => {
          this.errors = err.response.data.error
        })
      this.loading = false
    },

    loadUser() {
      this.loading = true
      axios(`${process.env.VUE_APP_API_URL}/users/${this.user.id}`).then((res) => {
        this.user.name = res.data.name
        this.user.email = res.data.email
        this.loading = false
      })
    },
  },

  computed: {
    emailState() {
      if (this.errors && this.errors.email) {
        return this.errors.email.length > 0 ? false : null
      }

      return null
    },
    passwordState() {
      if (this.user.password && this.user.password.length < 6) {
        return false
      }

      if (this.user.password && this.user.password_confirmation < 6) {
        return false
      }

      if (this.errors && this.errors.password) {
        return this.errors.password.length > 0 ? false : null
      }

      return null
    },
  },

  created() {
    this.user = {}
    if (this.$route.params.id) {
      this.user.id = this.$route.params.id
      this.method = 'put'
      this.loadUser()
    }
  },
}
</script>

<style>
</style>