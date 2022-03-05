const resource = '/smtp';

export const SetDefault = (id) => axios.get(`${resource}/set_default/${id}`)
export const DeleteSmtpData = (id) => axios.delete('smtp/delete/' + id)
export const GetAllSmtp = (payload) => axios.post('smtp/search', payload)
export const ShowSmtp = (id, {}) => axios.get('smtp/show/' + id, {})
export const UpdateSmtp = (id, payload) => axios.put('smtp/update/' + id, payload)
export const CreateSmtp = (payload) => axios.post('smtp/create', payload)