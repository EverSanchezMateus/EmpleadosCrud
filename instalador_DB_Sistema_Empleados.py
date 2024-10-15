import mysql.connector

def crear_base_de_datos():
    # Solicitar datos de conexión al usuario
    host = input("Ingrese el host de la base de datos (ejemplo: localhost): ")
    user = input("Ingrese el usuario de la base de datos (ejemplo: root): ")
    password = input("Ingrese la contraseña del usuario de la base de datos: ")

    if host =="":
        host="localhost"
    if user=="":
        user="root"

    try:
        # Creo la conexión
        conexion = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
        )

        cursor = conexion.cursor()

        # Creo la base de datos si no existe
        cursor.execute("CREATE DATABASE IF NOT EXISTS sistema_empleados")
        cursor.execute("USE sistema_empleados")  # Usar la base de datos 'sistema_empleados'

        # Ahora creo la tabla si no existe
        cursor.execute('''CREATE TABLE IF NOT EXISTS empleados (
            codigo INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            apellido VARCHAR(100) NOT NULL,
            documento_identidad BIGINT NOT NULL UNIQUE,
            direccion VARCHAR(255),
            email VARCHAR(255),
            telefono BIGINT,SELECT codigo FROM empleados;
            foto LONGBLOB,
            estado VARCHAR(255) NOT NULL
                
        )''')

        # Mensaje de éxito
        print("La base de datos y la tabla 'empleados' se crearon correctamente.")
        input("Presiona una tecla para salir")
    
    except mysql.connector.Error as err:
        print(f"Error: {err}")

    finally:
        # Cierre del cursor y conexión
        if cursor:
            cursor.close()
        if conexion:
            conexion.close()

# Se ejecuta 
if __name__ == "__main__":
    crear_base_de_datos()
