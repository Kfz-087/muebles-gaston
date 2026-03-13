<?php

function admin_check(
    $conn,
    $user
) {
    $sql = "SELECT * FROM admins WHERE  id_admin != :usuario AND es_admin = 1";
    $registro = $conn->prepare($sql);
    $registro->execute([
        ':usuario' => $user
    ]);
    if ($registro->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function user_check(
    $conn,
    $user
) {
    $sql = "SELECT * FROM clientes WHERE usuario = :usuario AND es_admin = 0";
    $registro = $conn->prepare($sql);
    $registro->execute([
        ':usuario' => $user
    ]);
    if ($registro->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
?>