<?php
ob_start();
session_start();

// Verificar sesión y rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
    exit;
}
if (!isset($_SESSION['id'])) {
    header('Location: ../erro404.php');
    exit;
}

require '../../backend/bd/ctconex.php';

// Variable para indicar si se debe mostrar la animación de éxito
$mostrarSweetAlert = false;

// Si se envía el formulario de eliminación (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stdltprod'])) {
    $idprod = trim($_POST['txtidprod']);
    // Preparar la consulta DELETE
    $stmtDelete = $connect->prepare("DELETE FROM producto WHERE idprod = :idprod");
    $stmtDelete->bindParam(':idprod', $idprod, PDO::PARAM_INT);
    if ($stmtDelete->execute()) {
        // Si se elimina correctamente, activamos la bandera para mostrar SweetAlert
        $mostrarSweetAlert = true;
    } else {
        echo "<script>alert('Error al eliminar el producto'); window.location.href='../productos/mostrar.php';</script>";
        exit;
    }
} else {
    // Si es una petición GET, se obtiene el id del producto para mostrar la confirmación
    $id = $_GET['id'] ?? '';
    if (!$id) {
        echo "<script>alert('ID de producto no especificado'); window.location.href='../productos/mostrar.php';</script>";
        exit;
    }
    // Consultar los datos del producto a eliminar
    $stmt = $connect->prepare("SELECT * FROM producto WHERE idprod = :idprod");
    $stmt->bindParam(':idprod', $id, PDO::PARAM_INT);
    $stmt->execute();

    $data = array();
    if ($stmt) {
        while ($r = $stmt->fetch(PDO::FETCH_OBJ)) {
            $data[] = $r;
        }
    }
}
ob_end_flush();
?>
