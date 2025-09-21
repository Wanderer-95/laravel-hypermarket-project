export interface Param {
    id: number;
    title: string;
    filter_type: number;
    filter_type_title: string;
    label: string;
    param_values: [];
    created_at: string;
    updated_at: string;
}

export interface FilterType {
    name: string;
    value: number;
}
