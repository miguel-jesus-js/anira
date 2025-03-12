import {apiGet} from "../src/services/api";
import {defaultError, showAlert} from "./SweetAlert";

export function useExport(){
    const fetchExport = async(url: String, payload: Object, format: String, toggleModalExport: () => void) =>{
        try {
            const res = await apiGet(url, payload);
            if(res.type === 'success'){
                // Extraer datos del JSON
                const { file, mime } = res.data;

                // Decodificar el archivo base64
                const byteCharacters = atob(file);
                const byteNumbers = new Array(byteCharacters.length).fill(0).map((_, i) => byteCharacters.charCodeAt(i));
                const byteArray = new Uint8Array(byteNumbers);

                // Crear un Blob con el contenido del archivo
                const blob = new Blob([byteArray], { type: mime });

                // Crear URL y desencadenar la descarga
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'Empleados' + format); // Usar el nombre proporcionado por el backend
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                showAlert(res.type, res.title, res.message);
                toggleModalExport()
            }else{
                showAlert(res.type, res.title, res.message);
            }
        } catch (error: any) {
            if (error.response?.type) {
                showAlert(error.response.type, error.response.title, error.response.message);
            }else {
                defaultError();
            }
        }
    }
    return{
        fetchExport
    }
}
