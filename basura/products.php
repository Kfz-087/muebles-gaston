<?php
require_once __DIR__ . '/../config/conexion.php';


/**
 * Fetch all products from the database.
 * 
 * @return array Array of product associative arrays.
 */
function Productos()
{
    $pdo = conectar();
    if (!$pdo) {
        return [];
    }

    try {
        $preparar = $pdo->prepare("SELECT * FROM productos WHERE activo=1");
        $preparar->execute();
        return $preparar->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching products: " . $e->getMessage());
        return [];
    }
}

/**
 * Fetch featured products (for the homepage).
 * 
 * @param int $limit Number of products to fetch.
 * @return array Array of featured product associative arrays.
 */
function obtenerProductosDestacados($limit = 3)
{
    $pdo = conectar();
    if (!$pdo) {
        return [];
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE destacado = 1 LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching featured products: " . $e->getMessage());
        return [];
    }
}

/**
 * Fetch products by category.
 * 
 * @param string $category The category name.
 * @return array Array of products.
 */
function obtenerProductosPorCategoria($category)
{
    $pdo = conectar();
    if (!$pdo) {
        return [];
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE activo = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching products by category: " . $e->getMessage());
        return [];
    }
}