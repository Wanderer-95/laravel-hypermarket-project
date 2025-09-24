export interface ProductParam {
    id: number,
    values: [],
    label: string,
    param_id: number; // у тебя в данных именно param_id
    title: string;
    value: string;
}

export interface ProductImage {
    id: number;
    url: string;
}

export interface Product {
    id: number;
    title: string;
    price: number;
    old_price: number;
    category_id: number;
    parent_id: number;
    description: string;
    content: string;
    product_group_id: number;
    qty: number;
    created_at: string;
    updated_at: string;
    article: string;
    images: ProductImage[];      // ✅ массив изображений
    params: ProductParam[];      // ✅ массив параметров
    group_products: Product[];      // ✅ массив параметров
    preview_url: string;      // ✅ массив параметров
    productsChildData?: Product[] | null;
}
