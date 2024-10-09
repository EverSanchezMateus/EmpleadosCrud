
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
                alert(data);  // Mostrar el resultado
                cargarEmpleados();  // Recargar la lista de empleados
            })
            .catch(error => {
                console.error('Error eliminando empleado:', error);
            });
    }

}

// Función para buscar empleados
function searchEmployee() {
    // Obtener el valor del campo de búsqueda
    const searchValue = document.getElementById('searchInput').value;

    // Realizar una solicitud AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'BuscarEmpleado.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Manejar la respuesta
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Actualizar el cuerpo de la tabla con la respuesta del servidor
            document.getElementById('employeeTable').innerHTML = xhr.responseText;
        }
    };

    // Enviar la solicitud con el valor de búsqueda
    xhr.send('search=' + encodeURIComponent(searchValue));
}

// Conectar la función de búsqueda al evento 'keyup' del input
document.getElementById('searchInput').addEventListener('keyup', searchEmployee);