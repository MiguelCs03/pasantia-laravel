import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
     { path: '/', redirect: '/inicio' },
    // {
    //   path: '/',
    //   name: 'Login',
    //   component: () => import('@/views/LoginNuevo.vue'),
    //   meta: {
    //     layout: 'full',
    //   },
    // },
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '*',
      redirect: 'error-404',
    },
    {
      path: '/inicio',
      name: 'Inicio',
      component: () => import('@/views/Dashboard.vue'),
      meta: {
        pageTitle: 'Dashboard',
        breadcrumb: [
          {
            text: 'Dashboard',
            active: true,
          },
        ],
      },
    },
    // Rutas de Clientes
    {
      path: '/clientes',
      name: 'ClientesList',
      component: () => import('@/views/clientes/ClientesList.vue'),
      meta: {
        pageTitle: 'Clientes',
        breadcrumb: [
          {
            text: 'Clientes',
            active: true,
          },
        ],
      },
    },
    {
      path: '/clientes/crear',
      name: 'ClienteCreate',
      component: () => import('@/views/clientes/ClienteForm.vue'),
      meta: {
        pageTitle: 'Nuevo Cliente',
        breadcrumb: [
          {
            text: 'Clientes',
            to: '/clientes',
          },
          {
            text: 'Nuevo Cliente',
            active: true,
          },
        ],
      },
    },
    {
      path: '/clientes/editar/:id',
      name: 'ClienteEdit',
      component: () => import('@/views/clientes/ClienteForm.vue'),
      meta: {
        pageTitle: 'Editar Cliente',
        breadcrumb: [
          {
            text: 'Clientes',
            to: '/clientes',
          },
          {
            text: 'Editar Cliente',
            active: true,
          },
        ],
      },
    },
    // Rutas de Órdenes
    {
      path: '/ordenes',
      name: 'OrdenesList',
      component: () => import('@/views/ordenes/OrdenesList.vue'),
      meta: {
        pageTitle: 'Órdenes',
        breadcrumb: [
          {
            text: 'Órdenes',
            active: true,
          },
        ],
      },
    },
    {
      path: '/ordenes/crear',
      name: 'OrdenCreate',
      component: () => import('@/views/ordenes/OrdenForm.vue'),
      meta: {
        pageTitle: 'Nueva Orden',
        breadcrumb: [
          {
            text: 'Órdenes',
            to: '/ordenes',
          },
          {
            text: 'Nueva Orden',
            active: true,
          },
        ],
      },
    },
    {
      path: '/ordenes/editar/:id',
      name: 'OrdenEdit',
      component: () => import('@/views/ordenes/OrdenForm.vue'),
      meta: {
        pageTitle: 'Editar Orden',
        breadcrumb: [
          {
            text: 'Órdenes',
            to: '/ordenes',
          },
          {
            text: 'Editar Orden',
            active: true,
          },
        ],
      },
    },
  ],
})

router.afterEach(() => {
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

export default router
