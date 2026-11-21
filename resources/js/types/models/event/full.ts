import type { EnumElement, EventStatus } from '@/types';
import type { CoauthorResource } from '@/types/models/event/coauthor';
import type { EventMemberResource } from '@/types/models/event/member';
import type { EventReportLinkResource } from '@/types/models/event/report-link';
import type { UserResource } from '@/types/models/user';
import type { PreloadedFile } from '@/types/preloaded-file';
import { EventMemberWinnerResource } from '@/types/models/event/member-winner';

export interface EventFullResource {
    id: number;

    system: {
        status: EventStatus;
        reject_comment?: string;
    };

    main: {
        name: string;
        event_level: EnumElement<string>;
        activity_direction: EnumElement<string>;
        youth_policy_direction: EnumElement<string>;
    };

    dates: {
        start_date: string;
        end_date?: string;
        start_time: string;
    };

    plan: {
        target_audience: string;
        description: string;
        target_smart: string;
        qualitative_indicators: string;

        scenario_file?: PreloadedFile;
        estimate_file?: PreloadedFile;
    };

    announcement: {
        enabled: boolean;
        description?: string;
        image_file?: PreloadedFile;
    };

    registration: {
        enabled: boolean;
        end_date?: string;
        members_count?: number;
    };

    created_at?: string;
    updated_at?: string;

    creator_id: number;
    creator?: UserResource;
    coauthors?: CoauthorResource[];
    members?: EventMemberResource[];
    winners?: EventMemberWinnerResource[];
    report_links?: EventReportLinkResource[];

    coauthors_count: number;
    members_count: number;
}
