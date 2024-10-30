import {People} from '../People/People';
import {TypeEmployee} from '../TypeEmployees/TypeEmployee';
export interface Employee{
    id: number;
    people_id: number,
    type_employee_id: number,
    status: number,
    people: People,
    type_employee: TypeEmployee
}

export interface CreateEmployee{
    type_employee_id: number | string,
    user: Omit<User, 'id'>,
    people: Omit<People, 'id' | 'user_id' | 'profile_picture'>,
}
