export interface Column {
    key: string,
    label: string,
    enum?: Record<string, string>,
    rowRenderer?: string;
}
