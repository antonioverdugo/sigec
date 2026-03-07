// Cargar la confirmación de eliminacion
document.addEventListener("submit", (e) => {
    if (e.target.classList.contains("form-delete")) {
        e.preventDefault();
        // Logica sweetalert
        Swal.fire({
            title: "¿Estas Seguro de Eliminar el Elemento?",
            text: "¡Esta acción no se puede revertir!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviamos el formulario
                e.target.submit();
            }
        });
    }
});
