<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
    exit;
}

if (isset($_GET['id'])) {
    require '../../backend/bd/ctconex.php';
    $id = $_GET['id'];

    // Consultamos el costo total del plan asociado al servicio
    $stmt = $connect->prepare("SELECT plan.prec AS total FROM servicio INNER JOIN plan ON servicio.idplan = plan.idplan WHERE servicio.idservc = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $total = $row['total'];
        // Actualizamos el campo "canc" para igualarlo al costo total, marcando el servicio como pagado
        $update = $connect->prepare("UPDATE servicio SET canc = :total WHERE idservc = :id");
        $update->bindParam(':total', $total, PDO::PARAM_STR);
        $update->bindParam(':id', $id, PDO::PARAM_INT);

        if ($update->execute()) {
            // Redireccionamos a la lista con un indicador (opcional)
            header("Location: mostrar.php?pagado=1");
            exit;
        } else {
            echo "Error al actualizar el pago.";
        }
    } else {
        echo "Servicio no encontrado.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
