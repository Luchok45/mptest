import type { EventShortResource } from '@/types/models/event/short';
import type { UserResource } from '@/types/models/user';

export type EventMemberResource = {
    id: number;
    event_id: number;
    user_id: number;

    created_at: string;
    updated_at: string;

    event?: EventShortResource;
    user?: UserResource;
}
