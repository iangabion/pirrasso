const resource = '/clients';

export const CreateClient = (payload) => axios.post(`${resource}`, payload)
export const UpdateClient = (payload, id) => axios.put(`${resource}/${id}`, payload)
export const GetAllClients = () => axios.get(`${resource}`)
export const GetClient = (id) => axios.get(`${resource}/${id}`)
export const DeleteClient = (id) => axios.delete(`${resource}/${id}`)
export const FetchAllClient = (payload) => axios.post('client/search', payload)


export const ClientsPagination = (url, payload) => axios.get(`/${url}`, payload)