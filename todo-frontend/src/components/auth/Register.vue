<template>
  <div class="register-form shadow-lg p-5 bg-white rounded-lg">
    <div class="row">
      <div class="col-12 py-4">
        <div class="title mb-3">
          <h2 class="text-center mb-4">
            <strong>REGISTRE-SE</strong>
          </h2>
          <div class="text-center text-secondary">
            Já tem conta?
            <b-button variant="link" class="px-0" to="/login"> Fazer login. </b-button>
          </div>
        </div>
        <div class="form mt-4">
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
                required
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
                required
              ></b-form-input>
            </b-form-group>
            <b-button
              type="submit"
              class="btn btn-primary btn-login btn-block rounded-0"
              :disabled="loading"
            >
              <b-spinner small v-if="loading"></b-spinner>
              {{ loading ? 'Carregando...' : 'REGISTRAR' }}
            </b-button>
          </b-form>
        </div>
      </div>
    </div>
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
    }
  },

  methods: {
    async register() {
      this.loading = true
      await axios
        .post(`${process.env.VUE_APP_API_URL}/auth/register`, { ...this.user })
        .then(() => {
          this.$toasted.success('Registro efetuado com sucesso.', {
            icon: 'check',
          })
          this.$router.push('/login')
        })
        .catch((err) => {
          this.errors = err.response.data.error
        })
      this.loading = false
    },
  },

  computed: {
    emailState() {
      if (this.errors.email) {
        return this.errors.email.length > 0 ? false : null
      }

      return null
    },
    passwordState() {
      if (this.user.password && this.user.password.length < 6) {
        return false
      }

      if (this.errors.password) {
        return this.errors.password.length > 0 ? false : null
      }

      return null
    },
  },
}
</script>

<style>
.register-form {
  background-color: #efefef;
  width: 450px;
  height: v100;
  border-bottom: 1px;
}

.register-form hr {
  border: 1px solid #ddd;
  width: 100%;
}

.btn-login {
  border: 0 !important;
  background: linear-gradient(to right, rgba(20, 136, 204, 0.9), rgba(0, 114, 255, 0.9));
  letter-spacing: 3px;
  font-weight: 500;
}
</style>
