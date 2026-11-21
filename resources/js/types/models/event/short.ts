import type { UserResource } from '@/types/models/user';
import type { PreloadedFile } from '@/types/preloaded-file';
import { EventStatus } from '@/types';

export interface EventShortResource {
    id: number;
    status: EventStatus;
    name: string;
    date: string;
    image?: PreloadedFile;

    creator_id: number;
    creator: UserResource;
}
