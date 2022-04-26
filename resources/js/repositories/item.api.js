const resource = '/items';

export const GetToApprovedItems = () => axios.get(`${resource}/getToApprovedItems`)
export const ApprovedItem = (id) => axios.put(`${resource}/approve_item/${id}`)
export const DisapproveMail = (payload) => axios.post('approved_items/disapprovement', payload)
export const ApproveMail = (payload) => axios.post('approved_items/approve', payload)
export const RemoveDisapproveItem = (payload) => axios.delete('items/disapproved/' + payload)
export const getStock = () => axios.get('/stock_count')
export const getMonthlyItemReport = (payload) => axios.post(`/month_item`, payload)