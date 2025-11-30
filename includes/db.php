<?php
// Configuración de la conexión a la base de datos (PDO)
$host = 'localhost'; // El servidor XAMPP local
$user = 'root';      // Usuario predeterminado de XAMPP
$pass = '';          // Contraseña predeterminada de XAMPP (vacía)
$db   = 'dblibreria'; // Nombre de la base de datos

try {
    // Cadena de conexión (DSN)
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    
    // Opciones de PDO
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    // Crear la instancia de PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
    
} catch (\PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
