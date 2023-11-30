<?php

// Variables para almacenar la información del producto y del vendedor
$tituloProducto = "";
$caracteristicaProducto = "";
$precioProducto = "";
$nombreVendedor = "";
$apellidoVendedor = "";
$domicilioVendedor = "";

// Verificar si se ha enviado un ID de producto y realizar la solicitud REST para obtener la información del producto
if (isset($_POST['id_producto'])) {
    $idProducto = $_POST['id_producto'];
    $url = "https://uaa-interfaces3.000webhostapp.com/parcial2_tel/post.php?id=" . urlencode($idProducto);

    // Realizar la solicitud REST
    $productoInfo = file_get_contents($url);

    if ($productoInfo !== false) {
        $productoData = json_decode($productoInfo, true);

        $tituloProducto = $productoData['titulo'];
        $caracteristicaProducto = $productoData['caracteristica'];
        $precioProducto = $productoData['precio'];
    }
}

// Verificar si se ha enviado el formulario de publicación
if (isset($_POST['realizar_publicacion'])) {
    // Recuperar los datos del formulario
    $idProductoPublicacion = $_POST['id_producto'];
    $tituloPublicacion = $_POST['titulo_publicacion'];
    $caracteristicaPublicacion = $_POST['caracteristica_publicacion'];
    $precioPublicacion = $_POST['precio_publicacion'];
    $nombreVendedor = $_POST['nombre_vendedor'];
    $apellidoVendedor = $_POST['apellido_vendedor'];
    $domicilioVendedor = $_POST['domicilio_vendedor'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Recu";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Insertar información del vendedor en la tabla "clientes"
    $sqlCliente = "INSERT INTO clientes (nombre, apellido, domicilio) VALUES ('$nombreVendedor', '$apellidoVendedor', '$domicilioVendedor')";

    if ($conn->query($sqlCliente) === TRUE) {
        // Obtener el ID del cliente recién insertado
        $idCliente = $conn->insert_id;

        // Insertar la publicación relacionada en la tabla "publicaciones"
        $sqlPublicacion = "INSERT INTO publicaciones (id_producto, id_cliente, titulo, caracteristica, precio) 
                            VALUES ('$idProductoPublicacion', '$idCliente', '$tituloPublicacion', '$caracteristicaPublicacion', '$precioPublicacion')";

        if ($conn->query($sqlPublicacion) === TRUE) {
            header("Location: confirmacion.php");
            exit();
        } else {
            echo "Error al realizar la publicación: " . $conn->error;
        }
    } else {
        echo "Error al insertar información del vendedor: " . $conn->error;
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <header>
        <a href="." class="logo">
            <img src="descarga.png" alt="Mercado Libre">
        </a>
        <nav>
            <a href="inicio.php" class="nav-line">Inicio</a>
            <a href="" class="nav-line">Noticias</a>
            <a href="login.php" class="nav-line">Ingreso</a>
        </nav>
    </header>
    <section id="publicacion-container">
       
        <!-- Formulario para buscar la información del producto -->
        <form method="post" action="formulario.php">
            <label for="id_producto">Ingrese ID del Producto:</label>
            <input type="text" name="id_producto" id="id_producto" required>
            <button type="submit">Buscar Producto</button>
        </form>

     
                <!-- Formulario para realizar la publicación -->
                <form method="post" action="formulario.php">
                    <h2>Informacion del Producto:</h2>
                    <p><strong>ID:</strong><?php echo $idProducto;?><input type="hidden" name="id_producto" value="<?php echo $idProducto; ?>">
                    <p><strong>Título:</strong> <?php echo $tituloProducto; ?></p><input type="hidden" name="titulo_publicacion" value="<?php echo $tituloProducto; ?>">
                    <p><strong>Característica:</strong> <?php echo $caracteristicaProducto; ?></p><input type="hidden" name="caracteristica_publicacion" value="<?php echo $caracteristicaProducto; ?>">
                    <p><strong>Precio:</strong> <?php echo $precioProducto; ?></p><input type="hidden" name="precio_publicacion" value="<?php echo $precioProducto; ?>">

                     <!-- Nuevos campos para el vendedor -->
                    <h2>Información del Vendedor:</h2>
                    <label for="nombre_vendedor">Nombre del Vendedor:</label>
                    <input type="text" name="nombre_vendedor" required>
                    <label for="apellido_vendedor">Apellido del Vendedor:</label>
                    <input type="text" name="apellido_vendedor" required>
                    <label for="domicilio_vendedor">Domicilio del Vendedor:</label>
                    <input type="text" name="domicilio_vendedor" required>
                    <button type="submit" name="realizar_publicacion">Realizar Publicación</button>
                </form>
 

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
