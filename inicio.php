<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Recu";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Consulta para obtener todas las publicaciones con datos del vendedor
$sql = "SELECT publicaciones.*, clientes.nombre as nombre_vendedor, clientes.apellido as apellido_vendedor, clientes.domicilio as domicilio_vendedor 
        FROM publicaciones 
        INNER JOIN clientes ON publicaciones.id_cliente = clientes.ID";

$result = $conn->query($sql);

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Publicaciones</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <header>
        <a href="." class="logo">
            <img src="descarga.png" alt="Mercado Libre">
        </a>
        <nav>
            <a href="formulario.php" class="nav-line">Nueva Publicación</a>
            <a href="verpublicaciones.php" class="nav-line">Ver Publicaciones</a>
            <a href="login.php" class="nav-line">Ingreso</a>
        </nav>
    </header>
    <section id="publicaciones-container">
        <div class="container mt-5">
            <h2>Lista de Publicaciones</h2>
            <?php
            // Mostrar las publicaciones con datos del vendedor si hay resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card mt-3'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['titulo'] . "</h5>";
                    echo "<p class='card-text'>Característica: " . $row['caracteristica'] . "</p>";
                    echo "<p class='card-text'>Precio: " . $row['precio'] . "</p>";
                    echo "<p class='card-text'>Vendedor: " . $row['nombre_vendedor'] . " " . $row['apellido_vendedor'] . "</p>";
                    echo "<p class='card-text'>Domicilio del Vendedor: " . $row['domicilio_vendedor'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No hay publicaciones.";
            }
            ?>
        </div>
    </section>
    <footer>
        <p>&copy; 2023 Company, Inc</p>
        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Shop</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
        </ul>
    </footer>
</body>
</html>
