const resource = '/items';

export const GetToApprovedItems = () => axios.get(`${resource}/getToApprovedItems`)
export const ApprovedItem = (id) => axios.get(`${resource}/approve_item/${id}`)
export const DisapproveMail = (payload) => axios.post('approved_items/disapprovement', payload)
export const RemoveDisapproveItem = (payload) => axios.delete('items/disapproved/'+ payload)
