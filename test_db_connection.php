<?php
require_once 'config/conexion.php';

echo "Testing Supabase Connection...\n";
$pdo = conectar();

if ($pdo) {
    echo "SUCCESS: Connected to database successfully!\n";
    // Optional: Query version to confirm
    $stmt = $pdo->query('SELECT version()');
    $version = $stmt->fetchColumn();
    echo "PostgreSQL Version: " . $version . "\n";
} else {
    echo "FAILURE: Could not connect to database.\n";
}
?>