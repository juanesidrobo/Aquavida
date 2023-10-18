<?php
include("connection.php");
$conn = connection();

// Obtén el ID del usuario enviado desde el formulario
if(isset($_POST["idUsuario"])) {
    $idUsuario = $_POST["idUsuario"];
    
    // Realiza la consulta SQL para obtener los datos del usuario
    $sql = "SELECT id, name, lastname, username, password, identifier FROM users WHERE id = $idUsuario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario fue encontrado, obtén los datos
        $row = $result->fetch_assoc();
        $nombres = $row["name"];
        $apellidos = $row["lastname"];
        $id = $row["id"];
        $usuario = $row["username"];
        $contraseña = $row["password"];
        $identificador = $row["identifier"]; // Agregar el campo "identifier"

        // Crea un arreglo asociativo con los datos del usuario
        $usuarioEncontrado = array(
            "nombres" => $nombres,
            "apellidos" => $apellidos,
            "id" => $id,
            "usuario" => $usuario,
            "identificador" => $identificador, // Agregar "identificador" al arreglo de respuesta
        );

        // Devuelve los datos en formato JSON
        echo json_encode($usuarioEncontrado);
    } else {
        // El usuario no fue encontrado
        $respuestaError = array(
            "error" => "Usuario no encontrado"
        );
        echo json_encode($respuestaError);
    }
} else {
    echo "ID del usuario no proporcionado";
}

// Cierra la conexión a la base de datos
$conn->close();
?>

