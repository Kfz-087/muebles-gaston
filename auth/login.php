<?php

require_once '../config/conexion.php';
$conn = conectar();

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    if (empty($data['usuario']) || empty($data['contrasena'])) {
        echo json_encode(array("status" => "error", "message" => "Hay un campo incompleto"));
    } else {
        $user = $data['usuario'];
        $pass = $data['contrasena'];

        try {
            // First, try to find in usuarios (admins)
            $sql_usuarios = "SELECT * FROM usuarios WHERE nombre = :usuario";
            $registro = $conn->prepare($sql_usuarios);
            $registro->execute([':usuario' => $user]);
            $usuario_data = $registro->fetch(PDO::FETCH_ASSOC);

            // If not found in usuarios, try clientes
            if (!$usuario_data) {
                $sql_clientes = "SELECT * FROM clientes WHERE usuario = :usuario";
                $registro = $conn->prepare($sql_clientes);
                $registro->execute([':usuario' => $user]);
                $usuario_data = $registro->fetch(PDO::FETCH_ASSOC);
            }

            // Check if we found a user and verify password
            $authenticated = false;
            $needs_rehash = false;

            if ($usuario_data) {
                if (password_verify($pass, $usuario_data['contrasena'])) {
                    $authenticated = true;
                } elseif ($pass === $usuario_data['contrasena']) {
                    // Legacy plain-text password match
                    $authenticated = true;
                    $needs_rehash = true;
                }
            }

            if ($authenticated) {
                if ($needs_rehash) {
                    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                    if (isset($usuario_data['id_cliente'])) {
                        $update_sql = "UPDATE clientes SET contrasena = :pass WHERE id_cliente = :id";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->execute([':pass' => $hashed_pass, ':id' => $usuario_data['id_cliente']]);
                    } else {
                        $update_sql = "UPDATE usuarios SET contrasena = :pass WHERE id_usuario = :id";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->execute([':pass' => $hashed_pass, ':id' => $usuario_data['id_usuario']]);
                    }
                }

                session_start();
                session_regenerate_id(true); // Prevent session fixation
                $_SESSION["usuario"] = htmlentities($user);

                // Set id_cliente if it exists (for clients)
                if (isset($usuario_data['id_cliente'])) {
                    $_SESSION['id_cliente'] = $usuario_data['id_cliente'];
                }

                // Trim potential whitespace from role
                $rol_db = isset($usuario_data['rol']) ? trim($usuario_data['rol']) : '0';
                $_SESSION["rol"] = $rol_db;

                echo json_encode(array(
                    "status" => "success",
                    "message" => "Login Exitoso",
                    "usuario" => array(
                        "rol" => (string) $rol_db,
                        "nombre" => $user
                    )
                ));

            } else {
                echo json_encode(array("status" => "error", "message" => "Usuario o contraseña incorrectos"));
            }
        } catch (PDOException $e) {
            echo json_encode(array("status" => "error", "message" => "Error: " . $e->getMessage()));
        }
    }
} else {
    // Check if it's a standard POST request (fallback or error)
    echo json_encode(array("status" => "error", "message" => "Datos no recibidos"));
}



?>