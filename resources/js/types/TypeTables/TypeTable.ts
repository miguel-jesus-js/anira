export interface TypeTable {
    id: number,
    type_table: string,
    status: number
}

export type CreateTypeEmployee = Omit<TypeTable, 'id'>;

export interface ColumnsExportAnsFilters {
    type_table: string | null,
}
