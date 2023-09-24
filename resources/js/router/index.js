import {createRouter, createWebHistory} from 'vue-router'
import About from '../components/massage/About.vue'
import Account from '../components/massage/Account.vue'
import Home from '../components/massage/Home.vue'
import NotFound from '../components/massage/NotFound.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
          meta: {
            title: "About",
          },
          path: "/about",
          name: "About",
          component: About,
        },      
        {
          meta: {
            title: "Account",
          },
          path: "/account",
          name: "Account",
          component: Account,
        },
        {
          meta: {
            title: "Home",
          },
          path: "/home",
          name: "Home",
          component: Home,
        },
        {
            meta: {
              title: "Massage Home",
            },
            path: "/massage/",
            name: "Massage Home",
            children: [
              {
                path: 'about',
                component: () => import('../components/massage/About.vue')
              },
              {
                path: 'home',
                component: () => import('../components/massage/Home.vue')
              },
            ]
        },
        {
            path: '/:pathMatch(.*)*',
            component: NotFound
        }
    ]
})

export default router