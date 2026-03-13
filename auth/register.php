<?php


require_once "../config/conexion.php";
$conn = conectar();

if (isset($_POST['submit'])) {
    if (empty($_POST['usuario']) || empty($_POST['contrasena']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['email']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['localidad']) || empty($_POST['codigo_postal'])) {
        echo "Hay un Campo incompleto";
    } else {



        $user = $_POST['usuario'];
        $pass = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
        $nombre = $_POST['nombre'];
        // ...
        try {
            $sql = "INSERT INTO clientes 
        (usuario, contrasena, nombre, apellido, dni, correo, telefono, direccion, localidad, postal) 
        VALUES 
        (:usuario, :contrasena, :nombre, :apellido, :dni, :email, :telefono, :direccion, :localidad, :codigo_postal)";
            $registro = $conn->prepare($sql);
            $registro->execute([
                ':usuario' => $user,
                ':contrasena' => $pass,
                ':nombre' => $nombre,
                ':apellido' => $apellido,
                ':dni' => $dni,
                ':email' => $email,
                ':telefono' => $telefono,
                ':direccion' => $direccion,
                ':localidad' => $localidad,
                ':codigo_postal' => $codigo_postal
            ]);
            if ($registro) {
                echo json_encode(array("status" => "success", "message" => "Usuario registrado exitosamente"));
                header("Location: ../index.php");
            } else {
                echo json_encode(array("status" => "error", "message" => "Error al registrar el usuario"));
            }
        } catch (PDOException $e) {
            echo json_encode(array("status" => "error", "message" => "Error: " . $e->getMessage()));
        }
    }
}



?>