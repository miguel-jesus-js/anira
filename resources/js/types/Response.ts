export interface Response<T> {
    data: T[];
    current_page: number;
    first_page_url: string | null;
    last_page: number;
    last_page_url: string | null;
    next_page_url: string | null;
    prev_page_url: string | null;
    per_page: number;
    total: number;
}
