import Vue from 'vue'
import VueRouter from 'vue-router'
import sidebarroutes from './components/routes/sidebarroutes'
import errorroutes from './components/routes/error'
// import itemroutes from './components/routes/itemroutes'
// import sellerroutes from './components/routes/sellerroutes'
// import routeSectionB from './routeSectionB.js'

Vue.use(VueRouter)



export default new VueRouter({
    routes: [
        // ...categoryroutes,
        // ...itemroutes,
        // ...sellerroutes
        ...sidebarroutes,
        ...errorroutes // always at last
    ],
    mode: 'history'
})