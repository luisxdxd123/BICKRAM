<?php
if(isset($_POST['stupdgasto'])) {
    require '../../backend/bd/ctconex.php';

    // Se obtiene el id del gasto de un campo oculto (no editable)
    $idga = $_POST['idga'];
    $detail = $_POST['detail'];
    $total = $_POST['total'];
    $fec = $_POST['fec'];

    try {
        $query = "UPDATE gastos 
                  SET detail = :detail,
                      total = :total,
                      fec = :fec
                  WHERE idga = :idga
                  LIMIT 1";
        $statement = $connect->prepare($query);
        $data = [
            ':detail' => $detail,
            ':total'  => $total,
            ':fec'    => $fec,
            ':idga'   => $idga
        ];
        $query_execute = $statement->execute($data);

        if($query_execute) {
            echo '<script type="text/javascript">
swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
    window.location = "../gastos/mostrar.php";
});
</script>';
            exit(0);
        } else {
            echo '<script type="text/javascript">
swal("Error!", "Error al actualizar", "error").then(function() {
    window.location = "../gastos/mostrar.php";
});
</script>';
            exit(0);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
