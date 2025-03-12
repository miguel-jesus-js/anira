export interface Address {
    id: number
    address: string,
    street: string,
    neighborhood: string,
    interior_number: string | null,
    outer_number: string | null,
    city: string,
    state: string,
    locality: string,
    cp: number,
    latitude: string,
    longitude: string
}

export interface createAddress extends Omit<Address, 'id'>{}
