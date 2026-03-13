<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribuidora Frami</title>
    <link rel="stylesheet" href="../login.css">

    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
</head>

<body>

    <main class="main-login">
        <h1 class="login-title">Distribuidora Frami</h1>

        <h3 class="login-subtitle">Registrate para poder hacer pedidos</h3>


        <div class="register-container">
            <form action="register.php" method="post" id="register-form">
                <input type="text" class="form-control" name="usuario" id="nombre-usuario" placeholder="Usuario"
                    required>
                <input type="password" class="form-control" name="contrasena" id="contrasena-usuario"
                    placeholder="Contraseña" required>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
                <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
                <input type="text" name="dni" id="dni" class="form-control" placeholder="DNI" required>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono" required>
                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion"
                    required>
                <input type="text" name="localidad" id="" class="form-control" placeholder="Localidad" required>
                <input type="text" name="codigo_postal" id="" placeholder="Codigo Postal" required>

                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Registrarse">
            </form>
            <p class="login-parrafo">¿Ya tenés una cuenta? <a class="login-link" href="../index.php">Inicia Sesión</a>
            </p>
        </div>
    </main>
    <script src="register.js"></script>
</body>

</html>