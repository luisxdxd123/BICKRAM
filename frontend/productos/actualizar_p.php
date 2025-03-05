<?php
ob_start();
session_start();

// Verificar sesión y rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
    exit;
}
if (!isset($_SESSION['id'])) {
    header('Location: ../erro404.php');
    exit;
}

require_once '../../backend/bd/ctconex.php';

// Variable para mostrar el SweetAlert (vacía por defecto)
$mostrarSweetAlert = false;

// Recibir el id del producto a actualizar desde GET
$id = $_GET['id'] ?? '';
if (!$id) {
    echo "<script>alert('ID de producto no especificado'); window.location.href='../productos/mostrar_p.php';</script>";
    exit;
}

// Obtener los datos actuales del producto
$stmt = $connect->prepare("SELECT * FROM producto WHERE idprod = :idprod");
$stmt->bindParam(':idprod', $id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_OBJ);

if (!$product) {
    echo "<script>alert('Producto no encontrado'); window.location.href='../productos/mostrar_p.php';</script>";
    exit;
}

// Consultar las categorías para el menú desplegable
$sql_cat = "SELECT idcate, nomca FROM categoria";
$stmt_cat = $connect->prepare($sql_cat);
$stmt_cat->execute();
$categorias = $stmt_cat->fetchAll(PDO::FETCH_OBJ);

// Procesar la actualización si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stupdcst'])) {
    // Recoger y sanitizar los datos del formulario
    $codba  = trim($_POST['txtnum']);    // Código de barras
    $nomprd = trim($_POST['txtnaame']);  // Nombre del producto
    $idcate = trim($_POST['txtape']);    // ID de la categoría
    $precio = trim($_POST['txtcel']);    // Precio
    $stock  = trim($_POST['txtema']);    // Stock
    $venci  = trim($_POST['txtnaci']);   // Fecha de vencimiento
    $esta   = trim($_POST['txtesta']);   // Estado

    // Preparar la consulta UPDATE
    $sql_update = "UPDATE producto 
                   SET codba = :codba, 
                       nomprd = :nomprd, 
                       idcate = :idcate, 
                       precio = :precio, 
                       stock = :stock, 
                       venci = :venci, 
                       esta = :esta
                   WHERE idprod = :idprod";
    $stmt_update = $connect->prepare($sql_update);
    $stmt_update->bindParam(':codba',  $codba);
    $stmt_update->bindParam(':nomprd', $nomprd);
    $stmt_update->bindParam(':idcate', $idcate, PDO::PARAM_INT);
    $stmt_update->bindParam(':precio', $precio);
    $stmt_update->bindParam(':stock',  $stock, PDO::PARAM_INT);
    $stmt_update->bindParam(':venci',  $venci);
    $stmt_update->bindParam(':esta',   $esta);
    $stmt_update->bindParam(':idprod', $id, PDO::PARAM_INT);

    if ($stmt_update->execute()) {
        // Ver cuántas filas se modificaron
        if ($stmt_update->rowCount() > 0) {
            // Se han cambiado datos en la BD
            $mostrarSweetAlert = true;
        } else {
            // Se ejecutó la consulta, pero no hubo cambios (valores iguales)
            echo "<script>alert('No se realizaron cambios en la base de datos');</script>";
        }
    } else {
        echo "<script>alert('Error al actualizar');</script>";
    }
}
?>

<?php include_once "../templates/header.php"; ?>

<!-- Page Content -->
<div id="content">
    <div class="top-navbar">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                    <span class="material-icons">arrow_back_ios</span>
                </button>
                <a class="navbar-brand" href="#"> Productos </a>
                <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse" 
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="material-icons">more_vert</span>
                </button>
                <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../cuenta/configuracion.php">
                                <span class="material-icons">settings</span>
                            </a>
                        </li>
                        <li class="dropdown nav-item active">
                            <a href="#" class="nav-link" data-toggle="dropdown">
                                <img src="../../backend/img/reere.png" alt="Imagen de usuario">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="../cuenta/perfil.php">Mi perfil</a></li>
                                <li><a href="../cuenta/salir.php">Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="main-content">
        <div class="row ">
            <div class="col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../administrador/escritorio.php">Panel administrativo</a></li>
                        <li class="breadcrumb-item"><a href="../productos/mostrar_p.php">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Actualizar</li>
                    </ol>
                </nav>
                <div class="card" style="min-height: 485px">
                    <div class="card-header card-header-text">
                        <h4 class="card-title">Actualizar Producto</h4>
                        <p class="category">Modifique los datos del producto</p>
                    </div>
                    <div class="card-content table-responsive">
                        <div class="alert alert-warning">
                            <strong>Estimado usuario!</strong> Los campos remarcados con 
                            <span class="text-danger">*</span> son obligatorios.
                        </div>
                        <form enctype="multipart/form-data" method="POST" autocomplete="off">
                            <div class="row">
                                <!-- Código de Barras -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtnum">Código de Barras 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" maxlength="14" class="form-control" name="txtnum" id="txtnum" required 
                                               placeholder="Código de barras" value="<?php echo $product->codba; ?>">
                                    </div>
                                </div>
                                <!-- Nombre del Producto -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtnaame">Nombre del Producto 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="txtnaame" id="txtnaame" required 
                                               placeholder="Nombre del producto" value="<?php echo $product->nomprd; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Categoría (select) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtape">Categoría 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" name="txtape" id="txtape" required>
                                            <option value="">Seleccione una categoría</option>
                                            <?php foreach ($categorias as $cat): ?>
                                                <option value="<?php echo $cat->idcate; ?>" 
                                                    <?php if ($cat->idcate == $product->idcate) echo 'selected'; ?>>
                                                    <?php echo $cat->idcate . ' - ' . $cat->nomca; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Precio -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtcel">Precio 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" maxlength="10" name="txtcel" id="txtcel" required 
                                               placeholder="Precio" value="<?php echo $product->precio; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Stock -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtema">Stock</label>
                                        <input type="number" class="form-control" name="txtema" id="txtema" 
                                               placeholder="Stock" value="<?php echo $product->stock; ?>">
                                    </div>
                                </div>
                                <!-- Vencimiento -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtnaci">Vencimiento</label>
                                        <input type="date" class="form-control" name="txtnaci" id="txtnaci" 
                                               value="<?php echo $product->venci; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Estado -->
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="txtesta">Estado 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" name="txtesta" id="txtesta" required>
                                            <!-- Muestra primero el estado actual del producto -->
                                            <option value="<?php echo $product->esta; ?>">
                                                <?php echo $product->esta; ?>
                                            </option>
                                            <option value="">-----Seleccione-----</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button name="stupdcst" class="btn btn-success text-white">Guardar</button>
                                    <a class="btn btn-danger text-white" href="../productos/mostrar_p.php">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts principales -->
<script src="../../backend/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../backend/js/popper.min.js"></script>
<script src="../../backend/js/bootstrap.min.js"></script>
<script src="../../backend/js/jquery-3.3.1.min.js"></script>
<script src="../../backend/js/sweetalert.js"></script>
<script>
$(document).ready(function() {
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });
    $('.more-button,.body-overlay').on('click', function() {
        $('#sidebar,.body-overlay').toggleClass('show-nav');
    });
});
</script>
<script src="../../backend/js/loader.js"></script>

<?php
// Si $mostrarSweetAlert es true, se muestra la alerta de éxito
if ($mostrarSweetAlert) {
    echo '<script type="text/javascript">
            swal("¡Actualizado!", "Se actualizó correctamente", "success")
            .then(function() {
                window.location = "../productos/mostrar_p.php";
            });
          </script>';
}
?>

</body>
</html>
<?php ob_end_flush(); ?>
