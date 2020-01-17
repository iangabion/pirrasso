
import error_404 from '../error/404'
export default [
  	{
      	path : '*',
    	// beforeEnter: yourGuard,
		component: error_404,
		name: 'error_404',
		
  	},
]