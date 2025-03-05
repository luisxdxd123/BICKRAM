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

// Recibir el id del producto a actualizar desde GET
$id = $_GET['id'] ?? '';
if (!$id) {
    echo "<script>alert('ID de producto no especificado'); window.location.href='../productos/mostrar.php';</script>";
    exit;
}

// Obtener los datos actuales del producto
$stmt = $connect->prepare("SELECT * FROM producto WHERE idprod = :idprod");
$stmt->bindParam(':idprod', $id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_OBJ);

if (!$product) {
    echo "<script>alert('Producto no encontrado'); window.location.href='../productos/mostra.php';</script>";
    exit;
}

// Consultar las categorías para el menú desplegable
$sql_cat = "SELECT idcate, nomca FROM categoria";
$stmt_cat = $connect->prepare($sql_cat);
$stmt_cat->execute();
$categorias = $stmt_cat->fetchAll(PDO::FETCH_OBJ);

// Procesar la actualización si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stupdcst'])) {
    // Recoger y sanitizar los datos del formulario
    $codba  = trim($_POST['txtnum']);    // Código de barras
    $nomprd = trim($_POST['txtnaame']);    // Nombre del producto
    $idcate = trim($_POST['txtape']);      // ID de la categoría
    $precio = trim($_POST['txtcel']);      // Precio
    $stock  = trim($_POST['txtema']);      // Stock
    $esta   = trim($_POST['txtesta']);     // Estado

    // Preparar la consulta UPDATE
    $sql_update = "UPDATE producto 
                   SET codba = :codba, 
                       nomprd = :nomprd, 
                       idcate = :idcate, 
                       precio = :precio, 
                       stock = :stock, 
                       esta = :esta
                   WHERE idprod = :idprod";
    $stmt_update = $connect->prepare($sql_update);
    $stmt_update->bindParam(':codba',  $codba);
    $stmt_update->bindParam(':nomprd', $nomprd);
    $stmt_update->bindParam(':idcate', $idcate, PDO::PARAM_INT);
    $stmt_update->bindParam(':precio', $precio);
    $stmt_update->bindParam(':stock',  $stock, PDO::PARAM_INT);
    $stmt_update->bindParam(':esta',   $esta);
    $stmt_update->bindParam(':idprod', $id, PDO::PARAM_INT);

    if ($stmt_update->execute()) {
        // Ver cuántas filas se modificaron
        if ($stmt_update->rowCount() > 0) {
            // Se han cambiado datos en la BD
            $mostrarSweetAlert = true;
        } else {
            echo "<script>alert('No se realizaron cambios en la base de datos');</script>";
        }
    } else {
        echo "<script>alert('Error al actualizar');</script>";
    }
}
ob_end_flush();
?>
