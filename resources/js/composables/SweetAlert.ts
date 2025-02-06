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

export function confirmDelete(url, id, onConfirm){
    Swal.fire({
        title: "¿Estas segur@ de eliminar este registro?",
        text: "Esta operación no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            onConfirm(url, id);
        }
    });
}
