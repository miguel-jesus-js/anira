import {Address} from "../Addresses/Address";
import {Employee} from "../Employees/Employee";

export interface Branch {
    id: number
    address_id: number | null,
    employee_id: number | null,
    name: string,
    email: string,
    country_code: string,
    phone_number: string,
    address: Address | null
    employee: Employee | null
}

export interface createBranch extends Omit<Branch, 'id, ,employee, address_id, employee_id'>{}

export interface ColumnsExportAnsFilters {
    address_id: number | null,
    employee_id: number | null,
    name: string | null,
    email: string | null,
    phone_number: string | null,
}
