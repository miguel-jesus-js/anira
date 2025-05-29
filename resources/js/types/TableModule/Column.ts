import {CustomInput} from "../General/CustomInput";

export interface Column {
    key: string,
    label: string,
    alias?: string
    customInput?: CustomInput
}
