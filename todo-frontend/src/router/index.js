import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '../store'

import LoginPage from '../page/LoginPage.vue'
import Login from '../components/auth/Login.vue'
import Register from '../components/auth/Register.vue'

import NotFoundPage from '../page/NotFoundPage.vue'

import Default from '../page/Default.vue'
import Home from '../page/Home.vue'

import User from '../components/user/Index.vue'
import UserForm from '../components/user/UserForm.vue'

import Task from '../components/task/Index.vue'

Vue.use(VueRouter)

const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
    return next()
  } else return next('/')
}

const ifAuthenticated = async (to, from, next) => {
  if (Date.now() > Date.parse(store.getters.exp)) {
    await store.dispatch('refreshToken')
  }
  if (store.getters.isAuthenticated) {
    return next()
  } else {
    store.dispatch('logout')
    return next('/login')
  }
}

const routes = [
  {
    path: '/',
    component: Default,
    children: [
      {
        path: '',
        name: 'home',
        component: Home,
        beforeEnter: ifAuthenticated,
      },
      {
        path: '/users',
        component: User,
        beforeEnter: ifAuthenticated,
      },
      {
        path: '/users/create',
        component: UserForm,
        beforeEnter: ifAuthenticated,
      },
      {
        path: '/users/update/:id',
        component: UserForm,
        beforeEnter: ifAuthenticated,
      },
      { path: '/tasks', component: Task, beforeEnter: ifAuthenticated },
    ],
  },
  {
    path: '/login',
    component: LoginPage,
    beforeEnter: ifNotAuthenticated,
    children: [
      { path: '', name: 'login', component: Login },
      { path: '/register', component: Register },
    ],
  },
  {
    path: '*',
    component: NotFoundPage,
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

export default router
