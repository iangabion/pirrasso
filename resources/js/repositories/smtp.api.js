const resource = '/smtp';

export const SetDefault = (id) => axios.get(`${resource}/set_default/${id}`)
