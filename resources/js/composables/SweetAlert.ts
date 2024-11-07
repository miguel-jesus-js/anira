import Swal from 'sweetalert2'

export function showAlert(type: String, title: String, message: String){
    Swal.fire({
        toast: true,
        position: "top-end",
        icon: type,
        title: title,
        text: message,
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
}
