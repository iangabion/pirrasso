const resource = '/items';

export const GetToApprovedItems = () => axios.get(`${resource}/getToApprovedItems`)
export const ApprovedItem = (id) => axios.get(`${resource}/approve_item/${id}`)
