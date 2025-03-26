export interface Table{
    id: number;
    type_table_id: number,
    number: number | string,
    name: string,
    description: string,
    capacity: number | string,
    status: number
}
export interface CreateTable extends Omit<Table, 'id'>{}

export interface ColumnsExportAnsFilters {
    id: number | null;
    type_table_id: number | null,
    number: number | null,
    name: string | null,
    description: string | null,
    capacity: number | null,
    status: number | string | null,
}
