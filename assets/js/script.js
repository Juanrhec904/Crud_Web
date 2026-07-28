
document.addEventListener('DOMContentLoaded', function () {
    const modalEliminar = document.getElementById('modalEliminar');
    if (!modalEliminar) return;

    modalEliminar.addEventListener('show.bs.modal', function (event) {
        const boton = event.relatedTarget; 
        const id = boton.getAttribute('data-id');
        const nombre = boton.getAttribute('data-nombre');

        document.getElementById('nombreEmpleado').textContent = nombre;
        document.getElementById('btnConfirmarEliminar').href = 'eliminar.php?id=' + id;
    });
});