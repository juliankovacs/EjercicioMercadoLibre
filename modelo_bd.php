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

// Supongamos que tienes una conexión a la base de datos llamada $conn

// Contraseña que el usuario proporciona en el formulario
$contrasena_usuario = $_POST['contraseña'];

// Hashear la contraseña antes de almacenarla
$contrasena_hasheada = password_hash($contrasena_usuario, PASSWORD_DEFAULT);

// Insertar el nombre de usuario y la contraseña hasheada en la base de datos
$sql = "INSERT INTO usuario (contrasena_hash) VALUES ('$contrasena_hasheada')";

// Ejecutar la consulta
$conn->query($sql);



if ($captcha_ingresado === $_SESSION['captcha']) {
    $query = "SELECT * FROM usuario WHERE usuario = '$usuario'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña hasheada utilizando password_verify
       if (password_verify($contrasena_usuario, $contrasena_hasheada)) {
            echo "Inicio de sesión exitoso";
            header("Location: inicio.php"); // Redirige a la página de inicio después del inicio de sesión
            exit();
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
} else {
    echo "Captcha incorrecto.";
}

$conn->close();
?>
