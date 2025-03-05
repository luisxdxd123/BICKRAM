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

require '../../backend/bd/ctconex.php';

// Procesar la eliminación si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stdltprod'])) {
    $idprod = trim($_POST['txtidprod']);
    // Preparar la consulta DELETE
    $stmtDelete = $connect->prepare("DELETE FROM producto WHERE idprod = :idprod");
    $stmtDelete->bindParam(':idprod', $idprod, PDO::PARAM_INT);
    if ($stmtDelete->execute()) {
        echo "<script>alert('Producto eliminado correctamente'); window.location.href='../productos/mostrar.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error al eliminar el producto'); window.location.href='../productos/mostrar.php';</script>";
        exit;
    }
}

// Recibir el id del producto a eliminar desde GET
$id = $_GET['id'] ?? '';
if (!$id) {
    echo "<script>alert('ID de producto no especificado'); window.location.href='../productos/mostrar.php';</script>";
    exit;
}

// Consultar los datos del producto a eliminar
$stmt = $connect->prepare("SELECT * FROM producto WHERE idprod = :idprod");
$stmt->bindParam(':idprod', $id, PDO::PARAM_INT);
$stmt->execute();

$data = array();
if($stmt){
    while($r = $stmt->fetch(PDO::FETCH_OBJ)){
        $data[] = $r;
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
                                <li>
                                    <a href="../cuenta/perfil.php">Mi perfil</a>
                                </li>
                                <li>
                                    <a href="../cuenta/salir.php">Salir</a>
                                </li>
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
                    <li class="breadcrumb-item"><a href="../productos/mostrar.php">Productos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
                  </ol>
                </nav>
                <div class="card" style="min-height: 485px">
                    <div class="card-header card-header-text">
                        <h4 class="card-title">¿Estás seguro de que quieres eliminar el producto?</h4>
                        <p class="category">Esta acción eliminará el producto seleccionado</p>
                    </div>
                    <div class="card-content table-responsive">
                        <?php if(count($data) > 0): ?>
                            <?php foreach($data as $f): ?>
                                <form enctype="multipart/form-data" method="POST" autocomplete="off">
                                    <div class="row">
                                        <!-- Mostrar el nombre del producto en modo solo lectura -->
                                        <div class="col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="txtnomprd">Nombre del producto <span class="text-danger">*</span></label>
                                                <input type="text" readonly value="<?php echo $f->nomprd; ?>" class="form-control" name="txtnomprd" required placeholder="Nombre del producto">
                                                <input type="hidden" value="<?php echo $f->idprod; ?>" name="txtidprod">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button name="stdltprod" class="btn btn-success text-white">Eliminar</button>
                                            <a class="btn btn-danger text-white" href="../productos/mostrar.php">Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                No se encontró ningún dato!
                            </div>
                        <?php endif; ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
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
</body>
</html>
<?php ob_end_flush(); ?>
