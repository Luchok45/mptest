import type { EnumElement } from '@/types';
import type { EventMemberResource } from '@/types/models/event/member';
import type { EventShortResource } from '@/types/models/event/short';

export type EventMemberWinnerResource = {
    id: number;
    event_id: number;
    event_member_id: number;
    reward_type: EnumElement<string>

    created_at: string;
    updated_at: string;

    event?: EventShortResource;
    member?: EventMemberResource;
}
