<template>
  <div class="login-form shadow-lg p-5 bg-white rounded-lg">
    <div class="row">
      <div class="col-12 py-4">
        <div class="title mb-3">
          <h2 class="text-center mb-4"><strong>LOGIN</strong></h2>
          <div class="text-center text-secondary">
            Ainda não tem conta?
            <b-button to="/register" variant="link" class="px-0"> Registre-se agora! </b-button>
          </div>
        </div>
        <div class="form mt-4">
          <b-form @submit.prevent="login">
            <b-form-group label="Email" label-for="email">
              <b-form-input
                id="email"
                v-model="user.email"
                type="email"
                placeholder="Digite o seu email..."
                class="rounded-0"
                required
              ></b-form-input>
            </b-form-group>
            <b-form-group label="Senha" label-for="password">
              <b-form-input
                id="password"
                v-model="user.password"
                type="password"
                placeholder="Digite a sua senha..."
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
              {{ loading ? 'Carregando...' : 'ENTRAR' }}
            </b-button>
          </b-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import showError from '@/config/showError'

export default {
  data() {
    return {
      user: {
        email: '',
        password: '',
      },
      loading: false,
    }
  },

  methods: {
    async login() {
      this.loading = true
      await this.$store
        .dispatch('login', this.user)
        .then(() => {
          this.$toasted.success('Login efetuado com sucesso.', {
            icon: 'check',
          })
          this.$router.push('/')
        })
        .catch(showError)
      this.loading = false
    },
  },
}
</script>

<style>
.login-form {
  background-color: #efefef;
  width: 450px;
  height: v100;
  border-bottom: 1px;
}

.login-form hr {
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
