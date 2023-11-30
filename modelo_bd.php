<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Recu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Recuperar valores del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contraseña'];
$captcha_ingresado = $_POST['captcha'];

if ($captcha_ingresado === $_SESSION['captcha']) {
    $query = "SELECT * FROM usuario WHERE usuario = '$usuario' AND contraseña = '$contrasena'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "Inicio de sesión exitoso"; // Mensaje que será mostrado en el div 'mensaje'
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
} else {
    echo "Captcha incorrecto.";
}



if ($row = $result->fetch_assoc()) {
    $_SESSION['usuario_id'] = $row['id']; // Asigna el ID del usuario a la sesión
    header("Location: inicio.php"); // Redirige a la página de inicio después del inicio de sesión
    exit();
} else {
    $mensaje_error = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
}

$conn->close();
?>
