export interface TypeCustomer {
    id: number,
    type_customer: string,
    status: number
}

export type CreateTypeCustomer = Omit<TypeCustomer, 'id'>;

export interface ColumnsExportAnsFilters {
    id: number | null
    type_customer: string | null,
    status: number | null,
}

