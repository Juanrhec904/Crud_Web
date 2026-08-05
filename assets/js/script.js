document.addEventListener('DOMContentLoaded', function () {

    // ---- Buscador de empleados (por nombre o cédula) ----
    const inputBuscar = document.getElementById('inputBuscar');
    const tabla = document.querySelector('table.tabla-obra tbody');
    const totalColumnas = tabla ? tabla.closest('table').querySelectorAll('thead th').length : 0;
    const filas = tabla ? Array.from(tabla.querySelectorAll('tr[data-fila-empleado]')) : [];

    if (inputBuscar && tabla) {
        inputBuscar.addEventListener('input', function () {
            const texto = this.value.trim().toLowerCase();
            let visibles = 0;

            filas.forEach(function (fila) {
                const nombre = (fila.dataset.nombre || '').toLowerCase();
                const cedula = (fila.dataset.cedula || '').toLowerCase();
                const coincide = nombre.includes(texto) || cedula.includes(texto);
                fila.style.display = coincide ? '' : 'none';
                if (coincide) visibles++;
            });

            let filaVacia = document.getElementById('filaSinResultados');
            if (visibles === 0 && texto !== '') {
                if (!filaVacia) {
                    filaVacia = document.createElement('tr');
                    filaVacia.id = 'filaSinResultados';
                    filaVacia.innerHTML = '<td colspan="' + totalColumnas + '" class="vacio">' +
                        'El empleado no existe o no está registrado.</td>';
                    tabla.appendChild(filaVacia);
                }
            } else if (filaVacia) {
                filaVacia.remove();
            }
        });
    }

    // ---- Modal de confirmación para eliminar empleado ----
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