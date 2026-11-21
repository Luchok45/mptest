import { RoleResource } from '@/types/privileges';

export interface UserResource {
    id: number;
    prometheus_id?: undefined|null|number|string;
    avatar: string;
    last_name: string;
    first_name: string;
    patronymic?: undefined|null|string;
    name: string;
    full_name: string;
    birthdate: null|string;
    phone: null|string;
    email: string;
    created_at: Date;
    updated_at: Date;

    roles?: RoleResource[];
}
