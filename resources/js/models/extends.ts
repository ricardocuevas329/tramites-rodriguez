
import type { AxiosResponseHeaders, AxiosRequestConfig } from 'axios';
import type { Pagination } from './Pagination';


export interface metaInfo{
    status: boolean;
    message: string;
}

export interface axiosDefaultRequest  {
    status: number;
    statusText: string;
    headers: AxiosResponseHeaders;
    config: AxiosRequestConfig<any>;
    request?: any;
};

interface IEntity<T> extends metaInfo {
    data: T;
}


export interface ResponseList<T> extends axiosDefaultRequest {
    data: {
        data: T[];
        meta: Pagination;
    };
}

export interface ResponseByEntity<T> extends axiosDefaultRequest {
    data: IEntity<T>;
}
