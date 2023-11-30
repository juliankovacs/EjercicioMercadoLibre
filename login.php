<!-- login.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Iniciar Sesión</title>
</head>
<body>
    <header>
        <a href="." class="logo">
            <img src="descarga.png" alt="Mercado Libre">
        </a>
        <nav>
            <a href="" class="nav-line">Inicio</a>
            <a href="" class="nav-line">Noticias</a>
            <a href="login.php" class="nav-line">Ingreso</a>
        </nav>
    </header>
    
     <form action="modelo_bd.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br>

        
        <label for="captcha">Captcha:</label>
        <input type="text" id="captcha" name="captcha" required>
        <img src="captcha.php" alt="Captcha"><br>

        <input type="submit" value="Iniciar sesión">
    </form>
    
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

<script>
    $(document).ready(function(){
        $('#loginForm').submit(function(event){
            event.preventDefault();

            // Obtener datos del formulario y serializarlos
            var formData = $(this).serialize();

            // Realizar la solicitud AJAX
            $.ajax({
                type: 'POST',
                url: 'modelo_bd.php',
                data: formData,
                success: function(response){
                    // Manejar la respuesta del servidor
                    $('#mensaje').html(response); // Mostrar el mensaje en el div 'mensaje'
                },
                error: function(error){
                    // Manejar errores en la solicitud
                    alert('Error en la solicitud: ' + error.statusText);
                }
            });
        });
    });
</script>