<?php


// Cargar variables de entorno
if (file_exists(__DIR__ . '/env.php')) {
    require_once __DIR__ . '/env.php';
} else {
    // Fallback para compatibilidad
    require_once __DIR__ . '/db_config.php';
    if (file_exists(__DIR__ . '/config.php')) {
        require_once __DIR__ . '/config.php';
    }
}

function conectar()
{
    $host = DB_HOST;
    $db = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;
    $charset = DB_CHARSET;

    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        throw new PDOException("Connection failed: " . $e->getMessage());
    }
}

function RequireLogin()
{
    if (!isset($_SESSION['usuario']) || empty($_SESSION)) {
        header("Location: /muebles-gaston/public/index.php");
        exit();
    }
}

function IsAdmin()
{
    if (!isset($_SESSION['usuario'])) {
        return false;
    }
    $conn = conectar();
    $sql = "SELECT rol FROM usuarios WHERE nombre = :usuario";
    $preparar = $conn->prepare($sql);
    $preparar->execute([':usuario' => $_SESSION['usuario']]);
    $usuario = $preparar->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $usuario['rol'] == '1') {
        return true;
    } else {
        return false;
    }
}