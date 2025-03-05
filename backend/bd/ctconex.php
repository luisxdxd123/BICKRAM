<?php
// Inicia la sesión sólo si no existe
if(!isset($_SESSION)) {
    session_start();
}

// Define constantes de conexión únicamente si no están definidas
if(!defined('DBHOST')) {
    define('DBHOST', 'localhost');
}
if(!defined('DBUSER')) {
    define('DBUSER', 'root');
}
if(!defined('DBPASS')) {
    define('DBPASS', '');
}
if(!defined('DBNAME')) {
    define('DBNAME', 'gym');
}

// Conexión a la base de datos
try {
    // Usamos las constantes definidas
    $connect = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS);
    $connect->query("SET NAMES utf8;");

    // Configuraciones de PDO
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
