<?php
require '../../backend/bd/ctconex.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $detail = $_POST['detail'];
    $total = $_POST['total'];
    $fec = $_POST['fec'];

    $sql = "INSERT INTO gastos (detail, total, fec)
            VALUES (:detail, :total, :fec)";
    $stmt = $connect->prepare($sql);

    $stmt->bindParam(':detail', $detail);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':fec', $fec);

    if ($stmt->execute()) {
        echo '<script type="text/javascript">
swal("¡Agregado!", "Gasto agregado correctamente", "success").then(function() {
    window.location = "../gastos/mostrar.php";
});
</script>';
        exit(0);
    } else {
        echo '<script type="text/javascript">
swal("Error!", "Error al agregar el gasto", "error").then(function() {
    window.location = "../gastos/mostrar.php";
});
</script>';
        exit(0);
    }
}
?>
