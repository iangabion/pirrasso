import show_category from '../settings/category/show'
import show_status from '../settings/status/show'
import show_apps_images from '../settings/images/show'
import smtp from '../settings/smtp/index'
import show_sms from '../settings/sms_sender/show'
import show_dashboard from '../dashboard/show'
import show_item from '../item/show'
import index_seller from '../seller/index'
import approved_items from '../approved_items/index'
import test from '../test/test.vue'
import promotions from '../settings/promotions/index'
export default [{
        path: '/categories',
        component: show_category,
        name: 'category',

    },
    {
        path: '/dashboard',
        // beforeEnter: yourGuard,
        component: show_dashboard,
        name: 'dashboard',

    },
    {
        path: '/items_show',
        // beforeEnter: yourGuard,
        component: show_item,
        name: 'item',

    },
    {
        path: '/sellers',
        component: index_seller,
        name: 'seller',

    },
    {
        path: '/approved_items',
        component: approved_items,
        name: 'approved_item',

    },
    {
        path: '/statuses',
        component: show_status,
        name: 'status',

    },

    {
        path: '/apps_images',
        component: show_apps_images,
        name: 'images',

    },
    {
        path: '/smtps',
        component: smtp,
        name: 'smtp',

    },
    {
        path: '/sms',
        component: show_sms,
        name: 'sms',

    },

    {
        path: '/test',
        component: test,
        name: 'test'
    },
    {
        path: '/promotions',
        component: promotions,
        name: 'promotions',

    },
]