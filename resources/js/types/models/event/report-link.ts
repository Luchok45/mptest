import type { EventShortResource } from '@/types/models/event/short';

export type EventReportLinkResource = {
    id: number;
    event_id: number;
    name: string;
    link: string;

    created_at: string;
    updated_at: string;

    event?: EventShortResource;
}
