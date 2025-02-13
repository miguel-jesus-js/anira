export interface TypeEmployee {
    id: number,
    type_employee: string,
    status: number
}

export type CreateTypeEmployee = Omit<TypeEmployee, 'id'>;

export interface ColumnsExportAnsFilters {
    type_employee: string | null,
}
