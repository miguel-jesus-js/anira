import {People} from '../People/People';
import {Address} from "../Addresses/Address";
import {User} from "../Users/User"
import {TypeCustomer} from "../TypeCustomers/TypeCustomer";
export interface Customer{
    id: number;
    people_id: number,
    type_customer_id: number,
    status: number,
    people: People,
    type_customer: TypeCustomer
}

export interface CreateCustomer{
    type_customer_id: number | string,
    user: Omit<User, 'id'>,
    people: Omit<People, 'id' | 'user_id' | 'profile_picture'>,
    addresses: omit<Address, 'id'>[],
    type_entity: string,
}

export interface ColumnsExportAnsFilters {
    first_name: string | null,
    last_name: string | null,
    email: string | null,
    dni: string | null,
    phone_number: string | null,
    user_name: string | null,
    type_customer_id: string | null,
    status: number | string | null,
}
