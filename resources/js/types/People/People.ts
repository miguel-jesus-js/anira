import {User} from '../Users/User';
import {Address} from "../Addresses/Address";

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
    addresses: Address
}
