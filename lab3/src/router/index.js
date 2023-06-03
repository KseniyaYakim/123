import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/childrens/:id?',
    name: 'Childrens',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/ChildrensPage')
  },
  {
    path: '/countries',
    name: 'Countries',
    component: () => import('@/views/CountriesPage'),
  },
  {
    path: '/children-edit/:id?',
    name: 'ChildrenEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/ChildrenEdit'),
  },
  {
    path: '/country-edit/:id?',
    name: 'CountryEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/CountryEdit'),
  },
  {
    path: '/:catchAll(.*)',
    name: 'NotFound',
    component: () => import('@/views/ChildrensPage'),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router