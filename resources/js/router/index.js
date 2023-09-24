import {createRouter, createWebHistory} from 'vue-router'
import About from '../components/massage/About.vue'
import Account from '../components/massage/Account.vue'
import Home from '../components/massage/Home.vue'
import NotFound from '../components/massage/NotFound.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_URL),
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
        // {
        //     meta: {
        //       title: "Massage Home",
        //     },
        //     path: "/massage/",
        //     name: "Massage Home",
        //     children: [
        //       {
        //         path: 'about',
        //         component: () => About
        //       },
        //       {
        //         path: 'home',
        //         component: () => Home
        //       },
        //     ]
        // },
        {
            path: '/:pathMatch(.*)*',
            component: NotFound
        }
    ]
})

export default router