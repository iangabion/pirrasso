import show_category from '../settings/category/show'
import show_dashboard from '../dashboard/show'
export default [
  	{
		path : '/categories',
	  component: show_category,
	  name: 'category',
	  
	},
  	{
      	path : '/dashboard',
    	// beforeEnter: yourGuard,
		component: show_dashboard,
		name: 'dashboard',
		
  	},
]