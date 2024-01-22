export interface IUploadFile {
    id?: number|null;
    name: string,
    size: number,
    type: string,
    base64?: string,
    file?: string,
    id_primary?: string|number,
    id_reference_relation?: string|number,
    documentType?: string|null
}
