import axios from 'axios';

const BASE_URL = '/api/v1';

export default {
    createCapybara: (data) => axios.post(`${BASE_URL}/capybaras`, data),
    listCapybaras: () => axios.get(`${BASE_URL}/capybaras`),
    submitObservation: (data) => axios.post(`${BASE_URL}/capybaras/${data.capybara_id}/observations`, data),
    listObservations: (url = `${BASE_URL}/observations`) => axios.get(url),
};
