import type { JsonResource } from '@/types/json';
import type { UserResource } from '@/types/models/user';
import type { PermissionResource, RoleResource } from '@/types/privileges';

export type Auth = {
    user: UserResource;

    roles?: JsonResource<RoleResource>;
    permissions: JsonResource<PermissionResource>;
};

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
