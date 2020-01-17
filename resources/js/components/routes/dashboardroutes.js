// import display_category from '../category/display'
import show_dashboard from '../dashboard/show'
export default [
  	// {
    //   	// path : '/categories',
    // 	// // beforeEnter: yourGuard,
	// 	// // component: display_category,
	// 	// name: 'categories',
		
  	// },
  	{
      	path : '/dashboard',
    	// beforeEnter: yourGuard,
		component: show_dashboard,
		name: 'dashboard',
		
  	},
]