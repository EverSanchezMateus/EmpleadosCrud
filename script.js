document.addEventListener("DOMContentLoaded", function() {
    console.log("Página cargada, intentando cargar empleados...");
    cargarEmpleados();
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

function cargarEmpleados() {
    console.log('Intentando cargar empleados...');  // Agrega esto para depurar

    fetch('listarEmpleados.php')  // Asegúrate de que la ruta sea correcta
        .then(response => response.json())  // Parsear la respuesta como JSON
        .then(data => {
            console.log(data);  // Mostrar los datos en la consola para depurar
            let employeeTable = document.getElementById('employeeTable');
            employeeTable.innerHTML = '';  // Limpiar cualquier contenido anterior

            data.forEach(empleado => {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td>${empleado.codigo}</td>
                    <td>${empleado.nombre}</td>
                    <td>${empleado.apellido}</td>
                    <td>${empleado.documento_identidad}</td>
                    <td>${empleado.direccion}</td>
                    <td>${empleado.email}</td>
                    <td>${empleado.telefono}</td>
                    <td>${empleado.estado}</td>
                    <td>
                        <button class="btn-edit" onclick="openEditModal( ${empleado.codigo})">Editar</button>
                        <button class="btn-delete" onclick="eliminar_empleado(${empleado.codigo})">Eliminar</button>
                    </td>
                `;
                employeeTable.appendChild(row);  // Añadir la fila a la tabla
            });
        })
        .catch(error => {
            console.error('Error cargando empleados:', error);
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

        /// respuesta del servidor

        .then(response => response.text())
        .then(data => {
            alert(data);  // Mostrar el resultado
            cargarEmpleados();  // Recargar la lista de empleados
        })
        .catch(error => {
            console.error('Error eliminando empleado:', error);
        });
    }
}

function openEditModal(codigo) {
    fetch('obtenerEmpleado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ codigo: codigo })  // Enviar el código del empleado
    })
    .then(response => response.json())
    .then(data => {
        // Llenar el formulario de edición con los datos recibidos del servidor
        document.getElementById('editCodigo').value = data.codigo;
        document.getElementById('editName').value = data.nombre;
        document.getElementById('editSurName').value = data.apellido;
        document.getElementById('editDocument').value = data.documento_identidad;
        document.getElementById('editAddress').value = data.direccion;
        document.getElementById('editEmail').value = data.email;
        document.getElementById('editTel').value = data.telefono;
        document.getElementById('editStatus').value = data.estado;

        // Mostrar el modal de edición
        document.getElementById('editEmployeeModal').style.display = 'block';
    })
    .catch(error => {
        console.error('Error al cargar los datos del empleado:', error);
    });
}
function updateEmployee() {
    const codigo = document.getElementById('editCodigo').value;
    const nombre = document.getElementById('editName').value;
    const apellido = document.getElementById('editSurName').value;
    const documento_identidad = document.getElementById('editDocument').value;
    const direccion = document.getElementById('editAddress').value;
    const email = document.getElementById('editEmail').value;
    const telefono = document.getElementById('editTel').value;
    const estado = document.getElementById('editStatus').value;

    // Realizar la solicitud para actualizar el empleado
    fetch('editarEmpleado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            codigo: codigo,
            nombre: nombre,
            apellido: apellido,
            documento_identidad: documento_identidad,
            direccion: direccion,
            email: email,
            telefono: telefono,
            estado: estado
        })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);  // Mostrar mensaje de éxito o error
        closeModal('editEmployeeModal');  // Cerrar el modal
        cargarEmpleados();  // Recargar la lista de empleados
    })
    .catch(error => {
        console.error('Error al actualizar el empleado:', error);
    });
}


function openEditModal(codigo) {
    fetch('obtenerEmpleado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ codigo: codigo })  // Enviar el código del empleado
    })
    .then(response => response.json())
    .then(data => {
        // Llenar el formulario de edición con los datos recibidos del servidor
        document.getElementById('editCodigo').value = data.codigo;
        document.getElementById('editName').value = data.nombre;
        document.getElementById('editSurName').value = data.apellido;
        document.getElementById('editDocument').value = data.documento_identidad;
        document.getElementById('editAddress').value = data.direccion;
        document.getElementById('editEmail').value = data.email;
        document.getElementById('editTel').value = data.telefono;
        document.getElementById('editStatus').value = data.estado;

        // Mostrar el modal de edición
        document.getElementById('editEmployeeModal').style.display = 'block';
    })
    .catch(error => {
        console.error('Error al cargar los datos del empleado:', error);
    });
}

// Función para actualizar el empleado
function searchEmployee() {
    // Obtener el valor del campo de búsqueda
    let searchInput = document.getElementById("searchInput").value.trim();

    // Crear el objeto FormData
    let datosBusqueda = new FormData();
    datosBusqueda.append("nombre", searchInput);

    // Enviar la solicitud al servidor
    fetch('BuscarEmpleado.php', {
        method: 'POST',
        body: datosBusqueda // Enviar el FormData
    })
    .then(response => response.json())  // Convertir la respuesta a JSON
    .then(data => {
        let employeeTable = document.getElementById('employeeTable');
        employeeTable.innerHTML = '';  // Limpiar cualquier contenido anterior

        if (data.error) {
            // Mostrar error si no se encontraron empleados
            employeeTable.innerHTML = `<tr><td colspan="9">${data.error}</td></tr>`;
        } else if (data.length > 0) {
            // Mostrar los empleados encontrados en la tabla
            data.forEach(empleado => {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td>${empleado.codigo}</td>
                    <td>${empleado.nombre}</td>
                    <td>${empleado.apellido}</td>
                    <td>${empleado.documento_identidad}</td>
                    <td>${empleado.direccion}</td>
                    <td>${empleado.email}</td>
                    <td>${empleado.telefono}</td>
                    <td>${empleado.estado}</td>
                    <td>
                        <button class="btn-edit" onclick="openEditModal(${empleado.codigo})">Editar</button>
                        <button class="btn-delete" onclick="eliminar_empleado(${empleado.codigo})">Eliminar</button>
                    </td>
                `;
                employeeTable.appendChild(row);
            });
        } else {
            employeeTable.innerHTML = `<tr><td colspan="9">No se encontraron empleados</td></tr>`;
        }
    })
    .catch(error => {
        console.error('Error al buscar el empleado:', error);
        alert('Error al buscar el empleado.');
    });
}
function continuar(){
    
}