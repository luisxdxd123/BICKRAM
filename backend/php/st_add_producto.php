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

require_once '../../backend/bd/ctconex.php';

// Variable para mostrar el SweetAlert (vacía por defecto)
$mostrarSweetAlert = false;

// Obtener categorías para el formulario
$sql = "SELECT idcate, nomca FROM categoria";
$stmt_cat = $connect->prepare($sql);
$stmt_cat->execute();
$categorias = $stmt_cat->fetchAll(PDO::FETCH_OBJ);

// Procesar el formulario al hacer POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['staddcust'])) {
    $codba  = trim($_POST['txtnum']);
    $nomprd = trim($_POST['txtnaame']);
    $idcate = trim($_POST['txtape']);
    $precio = trim($_POST['txtcel']);
    $stock  = trim($_POST['txtema']);
    $esta   = trim($_POST['txtesta']);

    // Validar campos obligatorios
    if ($codba && $nomprd && $idcate && $precio && $esta) {

        $sql_insert = "INSERT INTO producto (codba, nomprd, idcate, precio, stock, esta)
                       VALUES (:codba, :nomprd, :idcate, :precio, :stock, :esta)";
        $stmt = $connect->prepare($sql_insert);
        $stmt->bindParam(':codba', $codba);
        $stmt->bindParam(':nomprd', $nomprd);
        $stmt->bindParam(':idcate', $idcate);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':esta', $esta);

        if ($stmt->execute()) {
            // Si se insertó correctamente, activamos el SweetAlert
            $mostrarSweetAlert = true;
        } else {
            echo "<script>alert('Error al insertar el producto');</script>";
        }
    } else {
        echo "<script>alert('Por favor complete todos los campos obligatorios');</script>";
    }
}
ob_end_flush();
?>
