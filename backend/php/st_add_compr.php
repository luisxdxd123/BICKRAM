<?php
require '../../backend/bd/ctconex.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = $_POST['method'];
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];
    $placed_on = $_POST['placed_on'];
    $payment_status = $_POST['payment_status'];
    // Campo opcional, puede ser nulo
    $tipc = isset($_POST['tipc']) ? $_POST['tipc'] : null;

    $sql = "INSERT INTO compra (method, total_products, total_price, placed_on, payment_status, tipc)
            VALUES (:method, :total_products, :total_price, :placed_on, :payment_status, :tipc)";
    $stmt = $connect->prepare($sql);

    $stmt->bindParam(':method', $method);
    $stmt->bindParam(':total_products', $total_products);
    $stmt->bindParam(':total_price', $total_price);
    $stmt->bindParam(':placed_on', $placed_on);
    $stmt->bindParam(':payment_status', $payment_status);
    $stmt->bindParam(':tipc', $tipc);

    if ($stmt->execute()) {
        echo '<script type="text/javascript">
swal("¡Agregado!", "Compra agregada correctamente", "success").then(function() {
            window.location = "../compra/mostrar.php";
        });
        </script>';
        exit(0);
    } else {
        echo '<script type="text/javascript">
swal("Error!", "Error al agregar la compra", "error").then(function() {
            window.location = "../compra/mostrar.php";
        });
        </script>';
        exit(0);
    }
}
?>
