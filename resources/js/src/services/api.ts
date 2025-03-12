import axios from 'axios';

export const apiClient = axios.create({
    baseURL: '/api/',
    timeout: 10000
})

export const apiGet = async (pageUrl: string, payload: {}): Promise<T> => {
    const response = await apiClient.get(pageUrl,{
        params: payload
    });
    return response.data
};

export const apiPost = async (pageUrl: string, data: []): Promise<T> => {
    const response = await apiClient.post(pageUrl, data);
    return response.data
};

export const apiPut = async (pageUrl: string, data: []): Promise<T> => {
    const response = await apiClient.put(pageUrl, data);
    return response.data
};

export const apiDelete = async (pageUrl: string): Promise<T> => {
    const response = await apiClient.delete(pageUrl);
    return response.data
}
/*apiClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});*/
