import { apiClient } from './api';
import {Response} from "../../types/Response";
import {Employee} from "../../types/Employees/Employee";

export const getEmployees = async (pageUrl: string, filters: [], paginate: boolean): Promise<Employee> => {
    const response = await apiClient.get<Response<Employee>>(pageUrl,{
        params: {filters: filters, paginate: paginate}
    });
    return response.data
};

export const updateEmployee = async (id: number, data: []): Promise => {
    const response = await apiClient.put(`employees/${id}`, data, {});
    return  response.data;
}
