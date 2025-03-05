<?php
if(isset($_POST['stupdcomp'])) {
    require '../../backend/bd/ctconex.php';

    // Se obtiene el id de la compra de un campo oculto (no editable)
    $idcomp = $_POST['idcomp'];
    $method = $_POST['method'];
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];
    $placed_on = $_POST['placed_on'];
    $payment_status = $_POST['payment_status'];
    $tipc = $_POST['tipc']; // Campo opcional

    try {
        $query = "UPDATE compra 
                  SET method = :method,
                      total_products = :total_products,
                      total_price = :total_price,
                      placed_on = :placed_on,
                      payment_status = :payment_status,
                      tipc = :tipc
                  WHERE idcomp = :idcomp
                  LIMIT 1";

        $statement = $connect->prepare($query);
        $data = [
            ':method'         => $method,
            ':total_products' => $total_products,
            ':total_price'    => $total_price,
            ':placed_on'      => $placed_on,
            ':payment_status' => $payment_status,
            ':tipc'           => $tipc,
            ':idcomp'         => $idcomp
        ];

        $query_execute = $statement->execute($data);

        if($query_execute) {
            echo '<script type="text/javascript">
swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
    window.location = "../compra/mostrar.php";
});
</script>';
            exit(0);
        } else {
            echo '<script type="text/javascript">
swal("Error!", "Error al actualizar", "error").then(function() {
    window.location = "../compra/mostrar.php";
});
</script>';
            exit(0);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
