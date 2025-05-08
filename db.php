<?php
// Configuración de la base de datos
$host = 'localhost';   // Cambia esto si tu base de datos está en otro host
$dbname = 'sgp';       // Nombre de tu base de datos
$username = 'root';    // Tu nombre de usuario de MySQL
$password = 'Admin123';        // Tu contraseña de MySQL

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configurar el modo de error para PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Establecer el juego de caracteres a UTF-8
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Si ocurre un error, muestra el mensaje y detiene la ejecución
    echo 'Error de conexión: ' . $e->getMessage();
    exit;
}
?>