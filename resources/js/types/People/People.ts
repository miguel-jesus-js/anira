import {User} from '../Users/User';

export interface People {
    id: number,
    user_id: number,
    first_name: string,
    last_name: string,
    email: string,
    dni: string
    country_code: string,
    phone_number: string,
    profile_picture: string | null,
    user: User
}
