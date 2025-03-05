<?php
require '../../backend/bd/ctconex.php';

if (isset($_POST['stdltcateg'])) {
    $id = $_POST['txtidc'];

    $stmt = $connect->prepare("DELETE FROM categoria WHERE idcate = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo '<script type="text/javascript">
                swal({
                    title: "¡Éxito!",
                    text: "Categoría eliminada correctamente.",
                    icon: "success",
                    button: "Aceptar"
                }).then(function(){
                    window.location.href = "mostrar.php";
                });
              </script>';
        exit;
    } else {
        echo '<script type="text/javascript">
                swal({
                    title: "¡Error!",
                    text: "Ocurrió un error al eliminar la categoría.",
                    icon: "error",
                    button: "Aceptar"
                });
              </script>';
        exit;
    }
}
?>