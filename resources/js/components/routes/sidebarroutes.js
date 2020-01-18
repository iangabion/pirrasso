import show_category from '../settings/category/show'
import show_status from '../settings/status/show'
import show_dashboard from '../dashboard/show'
import show_item from '../item/show'
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
  	// {
    //   	path : '/items',
    // 	// beforeEnter: yourGuard,
	// 	component: show_item,
	// 	name: 'item',
		
	//   },
	  
	  {
		path : '/statuses',
	  // beforeEnter: yourGuard,
	  component: show_status,
	  name: 'status',
	  
	},
]