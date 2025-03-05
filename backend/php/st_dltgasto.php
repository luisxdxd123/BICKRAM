    <?php
    if(isset($_POST['stdltgasto'])) {
        require '../../backend/bd/ctconex.php';

        // Se obtiene el id del gasto de un campo oculto (no editable)
        $idga = $_POST['txtidg'];

        try {
            $query = "DELETE FROM gastos WHERE idga = :idga LIMIT 1";
            $statement = $connect->prepare($query);
            $data = [
                ':idga' => $idga
            ];
            $query_execute = $statement->execute($data);

            if($query_execute) {
                echo '<script type="text/javascript">
    swal("¡Eliminado!", "Eliminado correctamente", "success").then(function() {
        window.location = "../gastos/mostrar.php";
    });
    </script>';
                exit(0);
            } else {
                echo '<script type="text/javascript">
    swal("Error!", "Error al eliminar", "error").then(function() {
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
