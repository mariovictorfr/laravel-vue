import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: JSON.parse(localStorage.getItem('__todo-user') || {}),
    token: localStorage.getItem('__todo-token') || '',
    exp: localStorage.getItem('__todo-exp') || '',
  },

  mutations: {
    setToken(state, payload) {
      state.token = payload.token
      state.exp = payload.exp
    },

    deleteToken(state) {
      state.token = ''
      state.exp = ''
    },

    setUser(state, user) {
      state.user = user
    },

    deleteUser(state) {
      state.user = {}
    },
  },

  actions: {
    login({ commit }, user) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${process.env.VUE_APP_API_URL}/auth/login`, { ...user })
          .then((res) => {
            const token = res.data.token
            const exp = res.data.exp.date
            const user = {
              id: res.data.user.id,
              name: res.data.user.name,
              email: res.data.user.email,
            }

            axios.defaults.headers.common['Authorization'] = `bearer ${token}`

            localStorage.setItem('__todo-user', JSON.stringify(user))
            localStorage.setItem('__todo-token', token)
            localStorage.setItem('__todo-exp', exp)

            commit('setToken', { token, exp })
            commit('setUser', user)

            resolve(res)
          })
          .catch((err) => {
            localStorage.removeItem('__todo-user')
            localStorage.removeItem('__todo-token')
            localStorage.removeItem('__todo-exp')
            reject(err)
          })
      })
    },

    logout({ commit }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`${process.env.VUE_APP_API_URL}/auth/logout`)
          .then((res) => {
            localStorage.removeItem('__todo-user')
            localStorage.removeItem('__todo-token')
            localStorage.removeItem('__todo-exp')
            commit('deleteToken')
            delete axios.defaults.headers.common['Authorization']
            resolve(res)
          })
          .catch((err) => {
            reject(err)
          })
      })
    },

    refreshToken({ commit }) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${process.env.VUE_APP_API_URL}/auth/refresh`, {
            email: this.getters.user.email,
          })
          .then((res) => {
            const token = res.data.token
            const exp = res.data.exp.date
            const user = {
              id: res.data.user.id,
              name: res.data.user.name,
              email: res.data.user.email,
            }

            axios.defaults.headers.common['Authorization'] = `bearer ${token}`

            localStorage.setItem('__todo-user', JSON.stringify(user))
            localStorage.setItem('__todo-token', token)
            localStorage.setItem('__todo-exp', exp)

            commit('setToken', { token, exp })
            commit('setUser', user)

            resolve(res)
          })
          .catch((err) => {
            this.dispatch('logout')
            reject(err)
          })
      })
    },
  },

  getters: {
    user: (state) => state.user,
    isAuthenticated: (state) => !!state.token,
    exp: (state) => state.exp,
  },
})
