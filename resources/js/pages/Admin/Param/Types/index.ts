export interface Param {
    id: number;
    title: string;
    filter_type: number;
    filter_type_title: string;
    created_at: string;
    updated_at: string;
}

export interface FilterType {
    name: string;
    value: number;
}
