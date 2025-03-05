<?php

if (isset($_POST['stupdcateg'])) {
    require_once '../../backend/bd/ctconex.php';

    // Capturar datos del formulario
    $idcate = $_POST['txtidc'];
    $nomca  = $_POST['txtnomca'];
    $estado = $_POST['txtestado'];
    $fere   = $_POST['txtfere'];

    try {
        $query = "UPDATE categoria 
                  SET nomca = :nomca, estado = :estado, fere = :fere 
                  WHERE idcate = :idcate LIMIT 1";
        $statement = $connect->prepare($query);

        $data = [
            ':nomca'  => $nomca,
            ':estado' => $estado,
            ':fere'   => $fere,
            ':idcate' => $idcate
        ];
        $query_execute = $statement->execute($data);

        if ($query_execute && $statement->rowCount() > 0) {
            echo '<script type="text/javascript">
                    swal("¡Actualizado!", "Categoría actualizada correctamente", "success").then(function(){
                        window.location = "mostrar.php";
                    });
                  </script>';
            exit;
        } else {
            echo '<script type="text/javascript">
                    swal("Error!", "Error al actualizar la categoría", "error").then(function(){
                        window.location = "mostrar.php";
                    });
                  </script>';
            exit;
        }
    } catch (PDOException $e) {
        echo '<script type="text/javascript">
                swal("Exception", "' . $e->getMessage() . '", "error").then(function(){
                    window.location = "mostrar.php";
                });
              </script>';
        exit;
    }
}
ob_end_flush();
?>