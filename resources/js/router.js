import Vue from 'vue'
import VueRouter from 'vue-router'
import dashboardroutes from './components/routes/dashboardroutes'
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
        ...dashboardroutes,
        ...errorroutes // always at last
    ],
    mode: 'history'
})