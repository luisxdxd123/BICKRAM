<?php
if(isset($_POST['studltplan']))
{
    $idplan = $_POST['txtidc'];
    
    try {

        // Se elimina el plan de forma permanente
        $query = "DELETE FROM plan WHERE idplan = :idplan LIMIT 1";
        $statement = $connect->prepare($query);

        $data = [
            ':idplan' => $idplan
        ];
        $query_execute = $statement->execute($data);

        if($query_execute)
        {
            echo '<script type="text/javascript">
swal("¡Eliminado!", "Plan eliminado correctamente", "error").then(function() {
    window.location = "../plan/mostrar.php";
});
</script>';
            exit(0);
        }
        else
        {
            echo '<script type="text/javascript">
swal("Error!", "Error al eliminar el plan", "error").then(function() {
    window.location = "../plan/mostrar.php";
});
</script>';
            exit(0);
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
