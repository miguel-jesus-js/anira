import {apiPost, apiPut} from './api';
import {data} from "autoprefixer";
import {Address} from "../../types/Addresses/Address";

export const postAddress = async (pageUrl: string, data: data) => {
    return apiPost<Address>(pageUrl, data);
}

export const putAddress = async (pageUrl: string, data: data) => {
    return apiPut<Address>(pageUrl, data);
}
