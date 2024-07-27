import { createRouter, createWebHistory } from 'vue-router'
import DefaultLayout from '@/components/layout/DefaultLayout.vue'
import { ref } from 'vue'

const isAuthenticated = ref(false)
const routes = [
  {
    path: '/',
    component: DefaultLayout,
    meta: { requiresAuth: false },
    children: [
      
      {
        path: '',
        name: 'home',
        component: () => import('@/components/home/HomeView.vue')
      },
     
      {
        path: '/projects',
        name: 'projects',
        component: () => import('@/components/project/ProjectView.vue')
      },

       {
        path: '/tasks/:taskId',
        name: 'task-detail',
         component: () => import('@/components/task/TaskDetailView.vue'),
        props: true
      },
    ]
  },

  {
    path: '/login',
    name: 'login',
    meta: { requiresAuth: false },
    component: () => import('@/components/auth/LoginView.vue')
  },
  {
    path: '/register',
    name: 'register',
    meta: { requiresAuth: false },
    component: () => import('@/components/auth/RegisterView.vue')
  },


]

const router = createRouter({
  history: createWebHistory(),
  routes
})

 router.beforeEach((to, from, next) => {
  if (localStorage.getItem('userArrete') && localStorage.getItem('tokenArrete')) {
    isAuthenticated.value = true
  } else {
    isAuthenticated.value = false
  }
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth)
  if (requiresAuth) {
    if (!isAuthenticated.value) {
      next('/login')
    } else {
      next()
      }
  } else {
    if (!isAuthenticated.value) {
      next()
    } else {
      window.location.pathname = '/'
    }
  }
})
 
export default router
