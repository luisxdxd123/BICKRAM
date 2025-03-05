<?php
if(isset($_POST['stdltprod'])) {
    require '../../backend/bd/ctconex.php';

    // Se obtiene el id del producto de un campo oculto (no editable)
    $idprod = $_POST['txtidprod'];

    try {
        $query = "DELETE FROM producto WHERE idprod = :idprod LIMIT 1";
        $statement = $connect->prepare($query);
        $data = [
            ':idprod' => $idprod
        ];
        $query_execute = $statement->execute($data);

        if($query_execute) {
            echo '<script type="text/javascript">
swal("¡Eliminado!", "El producto se eliminó correctamente", "success").then(function() {
    window.location = "../productos/mostrar.php";
});
</script>';
            exit(0);
        } else {
            echo '<script type="text/javascript">
swal("Error!", "Error al eliminar", "error").then(function() {
    window.location = "../productos/mostrar.php";
});
</script>';
            exit(0);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
