import axios from 'axios';
const baseUrl = import.meta.env.VITE_BASE_URL
axios.defaults.baseUrl = baseUrl;
import { appStore } from '../store'

export function makeRequest(method = 'GET', url = "", params = {}, body={}, download=false) {
    const store = appStore();
      
    let headers = {};
    if (store.state.currentUser) {
        headers['Authorization'] = `Bearer ${store.state.currentUser.token}`;
    }
    headers['Accept'] = 'application/json'

    axios.interceptors.response.use((response) => {
        return response;
    }, (error) => {
        if (error.response) {
            if (error.response.status === 401) {
                store.commit('logout');
                window.location = "/";
            }
        }
        
        return Promise.reject(error);
    });

    return new Promise((resolve, reject) => {
        try{
            const response = axios({
                method,
                url,
                headers,
                params,
                data:body,
                responseType: download ? 'blob' : 'json'
            });

            resolve(response);
        } catch(error) {
            if (error.response.status === 401) {
                store.commit('logout');
            }
            reject(error);
        }
    })
    
}