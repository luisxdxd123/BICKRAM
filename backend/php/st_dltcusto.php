<?php
// Asegúrate de que la conexión ($connect) esté disponible, ya sea incluyéndola aquí o en otro archivo.
if(isset($_POST['stdltcst']))
{
    $idclient = $_POST['txtidc'];
    
    try {
        // Sentencia DELETE para eliminar el cliente permanentemente
        $query = "DELETE FROM clientes WHERE idclie = :idclient LIMIT 1";
        $statement = $connect->prepare($query);

        $data = [
            ':idclient' => $idclient
        ];
        $query_execute = $statement->execute($data);

        if($query_execute)
        {
            echo '<script type="text/javascript">
swal("¡Eliminado!", "Cliente eliminado correctamente", "error").then(function() {
    window.location = "../clientes/mostrar.php";
});
</script>';
            exit(0);
        }
        else
        {
            echo '<script type="text/javascript">
swal("Error!", "Error al eliminar el cliente", "error").then(function() {
    window.location = "../clientes/mostrar.php";
});
</script>';
            exit(0);
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
