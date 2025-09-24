import { Param } from '@/pages/Admin/Param/Types';

export interface ParamProduct {
    data: ParamProductData[],
    title: string,
}

export interface ParamProductData {
    id: number,
    param_id: number,
    product_id: number,
    value: string,
    param: Param
}

