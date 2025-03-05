<?php
require '../../backend/bd/ctconex.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomca  = $_POST['txtnomca'];
    $estado = $_POST['txtestado'];
    $fere   = $_POST['txtfere'];

    $sql = "INSERT INTO categoria (nomca, estado, fere)
            VALUES (:nomca, :estado, :fere)";
    $stmt = $connect->prepare($sql);

    $stmt->bindParam(':nomca', $nomca);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':fere', $fere);

    if ($stmt->execute()) {
        echo '<script type="text/javascript">
                swal("¡Agregado!", "Categoría agregada correctamente", "success").then(function() {
                    window.location = "../categoria/mostrar.php";
                });
              </script>';
        exit(0);
    } else {
        echo '<script type="text/javascript">
                swal("Error!", "Error al agregar la categoría", "error").then(function() {
                    window.location = "../categoria/mostrar.php";
                });
              </script>';
        exit(0);
    }
}
?>