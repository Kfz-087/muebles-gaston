<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribuidora Frami</title>
    <link rel="stylesheet" href="login.css">

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
        <h1 class="login-title"> Muebles Gastón </h1>

        <h3 class="login-subtitle"> Inicie Sesión Para hacer Pedidos </h3>


        <div class="login-container">
            <form action="auth/login.php" method="post">
                <input type="text" class="form-control" name="usuario" id="nombre-usuario" placeholder="Usuario">
                <input type="password" class="form-control" name="contrasena" id="contrasena-usuario"
                    placeholder="Contraseña">
                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Iniciar sesión">
            </form>
            <p class="login-parrafo">¿No tenés una cuenta? <a class="login-link"
                    href="auth/register-form.php">Registrate</a>
            </p>
        </div>
    </main>
    <script src="auth/login.js"></script>
</body>

</html>