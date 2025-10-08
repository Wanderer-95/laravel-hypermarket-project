import { Cart } from '@/pages/Client/Cart/types';

export interface Order {
    id: number;
    carts: Cart[];
}
