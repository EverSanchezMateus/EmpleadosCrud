document.addEventListener("DOMContentLoaded", function () {
    console.log("La Página esta intentado cargar los EMPLEADOS..");
    listarEmpleados();
});
// Función para abrir un modal
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

// Función para cerrar un modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}


function agregarEmpleado(event) {
    event.preventDefault();

    let nombre = document.getElementById("addName").value;
    let apellido = document.getElementById("addSurName").value;
    let documento_identidad = document.getElementById("addDocument").value;
    let direccion = document.getElementById("addAddress").value;
    let email = document.getElementById("addEmail").value;
    let celular = document.getElementById("addTel").value;
    let fotoElement = document.getElementById("addFoto");

    foto = fotoElement.files[0];


    let estado = document.getElementById("addStatus").value;

    let datosFormulario = new FormData();
    datosFormulario.append("nombre", nombre);
    datosFormulario.append("apellido", apellido);
    datosFormulario.append("documento_identidad", documento_identidad);
    datosFormulario.append("direccion", direccion);
    datosFormulario.append("email", email);
    datosFormulario.append("telefono", celular);
    if (foto) {
        datosFormulario.append("foto", foto);
    }

    datosFormulario.append("estado", estado);

    fetch('agregarEmpleado.php', {
        method: 'POST',
        body: datosFormulario
    })
        .then(response => response.text())
        .then(data => {
            //document.querySelector('#addEmployeeModal form').reset(); // Limpiar el formulario después de agregar el empleado por si se agrega otro
            //cerrarModal('addEmployeeModal');
            alert(data)
        })

        .catch(error => {
            console.error('Error:', error);
        });
}

function eliminar_empleado(codigo) {
    if (confirm('¿Estás seguro de que deseas eliminar este empleado?')) {
        fetch('eliminarEmpleado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ codigo: codigo })  // Enviar el código del empleado a eliminar
        })
            .then(response => response.text())
            .then(data => {
                alert(data);  // muestra si el empelado fue Eliminado
                listarEmpleados();  // Recargar la lista de empleados
            })
            .catch(error => {
                console.error('Error eliminando empleado:', error);
            });
    }
}


function listarEmpleados() {
    console.log("La función listarEmpleados se ha ejecutado.");

    // Hacer la solicitud para obtener los empleados desde el servidor
    fetch('ruta_al_php_que_lista_empleados.php') // Cambia esta ruta al archivo PHP que devuelve los empleados en JSON
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            console.log(data);
            let listaEmpleados = document.getElementById('employeeTable'); // ID correcto de la tabla
            listaEmpleados.innerHTML = ''; // Limpiar el contenido anterior

            // Recorrer los datos y generar las filas de la tabla
            data.forEach(empleado => {
                let fila = document.createElement('tr');

                fila.innerHTML = `
                    <td>${empleado.codigo}</td>
                    <td>${empleado.nombre}</td>
                    <td>${empleado.apellido}</td>
                    <td>${empleado.documento_identidad}</td>
                    <td>${empleado.direccion}</td>
                    <td>${empleado.email}</td>
                    <td>${empleado.telefono}</td>
                    <td>${empleado.estado}</td>
                `;

                listaEmpleados.appendChild(fila); // Añadir la fila a la tabla
            });

            console.log('Tabla de empleados actualizada');
        })
}

function cargarDatosEmpleado() {
    const codigo = document.getElementById('codigo').value; // Obtener el código del empleado

    if (!codigo) {
        alert("Por favor ingresa un código válido.");
        return;
    }

    // Enviar el código al servidor para obtener los datos del empleado
    fetch('obtenerEmpleado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ codigo: codigo }) // Enviar el código en el cuerpo de la solicitud
    })
        .then(response => response.json())  // Obtener los datos en formato JSON
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                // Rellenar el formulario de edición con los datos del empleado
                document.getElementById('codigo-editar').value = codigo;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('apellido').value = data.apellido;
                document.getElementById('documento_identidad').value = data.documento_identidad;
                document.getElementById('direccion').value = data.direccion;
                document.getElementById('email').value = data.email;
                document.getElementById('telefono').value = data.telefono;
                document.getElementById('estado').value = data.estado;

                // Mostrar el formulario de edición
                document.getElementById('editEmployeeForm').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error al cargar los datos del empleado:', error);
        });
}

// Función para editar el empleado con los datos modificados
function editar() {
    const empleado = {
        codigo: document.getElementById('codigo-editar').value,
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        documento_identidad: document.getElementById('documento_identidad').value,
        direccion: document.getElementById('direccion').value,
        email: document.getElementById('email').value,
        telefono: document.getElementById('telefono').value,
        estado: document.getElementById('estado').value
    };

    // Enviar los datos modificados al servidor para actualizar el empleado
    fetch('editar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(empleado)  // Enviar los datos actualizados
    })
        .then(response => response.text())
        .then(data => {
            alert(data);  // Mostrar el mensaje de éxito o error
            document.getElementById('editEmployeeForm').style.display = 'none'; // Ocultar el formulario de edición
        })
        .catch(error => {
            console.error('Error al editar el empleado:', error);
        });
}

function searchEmployee() {
    // Obtener el valor ingresado en el campo de búsqueda
    let searchInput = document.getElementById("searchInput").value.trim();

    // Verificar si el input está vacío
    if (!searchInput) {
        // Si está vacío, puedes simplemente limpiar la tabla o mostrar todos los empleados
        listarEmpleados(); // Mostrar todos los empleados si no hay búsqueda
        return;
    }

    // Preparar los datos para enviar al servidor
    let searchCriteria = {
        nombre: searchInput,
        documento_identidad: searchInput
    };

    // Enviar la solicitud al servidor
    fetch('buscarEmpleado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(searchCriteria) // Enviar el input como posible nombre o documento
    })
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            let resultadoBusqueda = document.getElementById("resultadoBusqueda");
            resultadoBusqueda.innerHTML = ''; // Limpiar resultados previos

            if (data.error) {
                // Si hubo un error, mostrarlo
                resultadoBusqueda.innerHTML = data.error;
            } else {
                // Mostrar los empleados encontrados en la tabla
                let listaEmpleados = '';
                data.forEach(empleado => {
                    listaEmpleados += `
                    <tr>
                        <td>${empleado.codigo}</td>
                        <td>${empleado.nombre}</td>
                        <td>${empleado.apellido}</td>
                        <td>${empleado.documento_identidad}</td>
                        <td>${empleado.direccion}</td>
                        <td>${empleado.email}</td>
                        <td>${empleado.telefono}</td>
                        <td>${empleado.estado}</td>
                    </tr>`;
                });

                resultadoBusqueda.innerHTML = `
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Documento Identidad</th>
                            <th>Dirección</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${listaEmpleados}
                    </tbody>
                </table>`;
            }
        })
        .catch(error => {
            console.error('Error al buscar el empleado:', error);
            alert('Error al buscar el empleado.');
        });
}