export type PreloadedFile = {
    disk: string,
    path: string,

    original: {
        filename: string,
        extension: string,
    },

    hashed: {
        filename: string,
        extension: string,
    },

    public_link?: string,
}
