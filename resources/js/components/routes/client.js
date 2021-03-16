import view_client from '../seller/show'
export default [
  	{
		path : '/client/:id/view',
	  	component: view_client,
	  	name: 'view_client',
    },
]





// import create_event from '../event/create'
// import view_event from '../event/view'
// import edit_event from '../event/edit'


// export default [
//   	{
// 		path : '/event/create',
// 	 	component: create_event,
// 	  	name: 'create_event',
//     },
//   	{
// 		path : '/event/:id/edit',
// 	  	component: edit_event,
// 	  	name: 'edit_event',
//     },
//   	{
// 		path : '/event/:id/view',
// 	  	component: view_event,
// 	  	name: 'view_event',
//     },
// ]
