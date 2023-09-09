import { PageProps } from "@inertiajs/core";

export interface AuthUserType extends PageProps {
 user?: object;
 _token: string;
 cordinate: object;
}

export interface WidgetType {
 label: string;
 icon: string;
 color: string;
 value: number | string;
}

export interface WorkerGroupType {
 id?: number;
 name?: string;
 summary?: string;
 attributes: Array<[]>;
}

export interface WorkerPropType {
 data: Array<{
  id: number;
  name: string;
  email: string;
  birth_date: Date;
 }>;
 current_page: number;
 from: number;
 first_page_url: string;
 next_page_url?: string;
 per_page: number;
 prev_page_url?: string;
 to: number;
}

export interface MultiSelectType {
 label: string | number;
 value: string | number;
}

export interface ReportModelType {
 month: Date | string | null;
 location?: MultiSelectType;
}

export interface WorkerFormType {
 id: number;
 role: string;
 name: string;
 email: string;
 personal_id: string;
 pangkat: string;
 jabatan: string;
 unit_kerja: string;
 description: string;
}

export interface HolidayFormType {
 id?: number;
 name: string;
 holiday_at: Date;
}

export interface TimeType {
 hours?: number | undefined;
 minutes?: number;
 seconds?: number;
}

export interface SettingTimeType {
 clock_in?: string;
 clock_in_tolerance?: string;
 clock_out?: string;
 clock_out_tolerance?: string;
}

export {};
declare global {
 export namespace inertia {
  export interface Props extends PageProps {
   user: {
    id: number;
    name: string;
    email: string;
    created_at: Date;
    updated_at: Date;
   };
   jetstream: {
    [key: string]: boolean;
   };
   errorBags: unknown;
   errors: unknown;
  }
 }
}
