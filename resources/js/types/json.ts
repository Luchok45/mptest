export type JsonResourceLinks = {
    first: string;
    last: string;
    next: null|string;
    prev: null|string;
};

export type JsonResourceMetaLink = {
    url: null|string;
    page: null|number;
    label: string;
    active: boolean;
};

export type JsonResourceMeta = {
    current_page: number;
    last_page: number;
    from: number;
    to: number;
    total: number;
    per_page: number;
    path: string;
    links: Array<JsonResourceMetaLink>
};

export type JsonResource<T> = {
    data: Array<T>,
    links?: JsonResourceLinks,
    meta?: JsonResourceMeta,
};

export type EnumElement<T> = {
    sys_name: string,
    value: T,
    display_name: string,
}

export interface EventStatus extends EnumElement<string> {
    color: string;
}
