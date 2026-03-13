<?php
try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/../../config/conexion.php';
    $conn = conectar();

    $data = json_decode(file_get_contents('php://input'), true);
    $id_cliente = $data['id_cliente'] ?? null;

    if (!$id_cliente) {
        throw new Exception('ID de cliente no recibido o inválido.');
    }

    // DEBUG: Verify client exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM clientes WHERE id_cliente = :id");
    $stmt->execute([':id' => $id_cliente]);
    if ($stmt->fetchColumn() == 0) {
        throw new Exception("El cliente con ID $id_cliente no existe en la base de datos.");
    }

    $id_sucursal = $data['id_sucursal'] ?? null;

    if (!$id_sucursal) {
        // Fallback: Get a valid sucursal for the client (taking the first one for now)
        $stmt = $conn->prepare("SELECT id_sucursal FROM sucursales_clientes WHERE id_cliente = :id LIMIT 1");
        $stmt->execute([':id' => $id_cliente]);
        $id_sucursal = $stmt->fetchColumn();

        if (!$id_sucursal) {
            throw new Exception("El cliente no tiene sucursales registradas para asignar el pedido.");
        }
    }

    if (empty($_SESSION['carrito'])) {
        throw new Exception('El carrito está vacío');
    }

    $carrito = $_SESSION['carrito'];
    $total = 0;

    // DEBUG: Verify all products exist and have enough stock
    foreach ($carrito as $item) {
        $stmt = $conn->prepare("SELECT precio, cantidad, nombre FROM productos WHERE id_producto = :id FOR UPDATE"); // Lock row
        $stmt->execute([':id' => $item['id']]);
        $producto_db = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto_db) {
            throw new Exception("El producto con ID " . $item['id'] . " no existe en la base de datos.");
        }

        if ($producto_db['cantidad'] < $item['cantidad']) {
            throw new Exception("No hay suficiente stock para '" . $producto_db['nombre'] . "'. Disponible: " . $producto_db['cantidad']);
        }

        // Use the price from the database to be safe
        $total += (float) $producto_db['precio'] * $item['cantidad'];
    }

    $conn->beginTransaction();

    $sql = "INSERT INTO pedidos (id_cliente, id_sucursal, precio, estado, fecha_ingreso) VALUES (:id_cliente, :id_sucursal, :precio, '0', current_timestamp())";
    $preparar = $conn->prepare($sql);
    $preparar->execute([
        ':id_cliente' => $id_cliente,
        ':id_sucursal' => $id_sucursal,
        ':precio' => $total
    ]);

    $id_pedido = $conn->lastInsertId();

    foreach ($carrito as $item) {
        // Insert item into productos_pedidos
        $sql = "INSERT INTO productos_pedidos (id_pedido, id_producto, cantidad) VALUES (:id_pedido, :id_producto, :cantidad)";
        $preparar = $conn->prepare($sql);
        $preparar->execute([
            ':id_pedido' => $id_pedido,
            ':id_producto' => $item['id'],
            ':cantidad' => $item['cantidad'],
        ]);

        // Decrease stock
        $sql_stock = "UPDATE productos SET cantidad = cantidad - :cantidad WHERE id_producto = :id_producto";
        $preparar_stock = $conn->prepare($sql_stock);
        $preparar_stock->execute([
            ':cantidad' => $item['cantidad'],
            ':id_producto' => $item['id']
        ]);
    }

    $conn->commit();
    unset($_SESSION['carrito']);
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>