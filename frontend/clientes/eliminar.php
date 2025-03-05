<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
    exit;
}
if (!isset($_SESSION['id'])) {
    header('Location: ../erro404.php');
    exit;
}

require_once '../../backend/php/st_dltprodc.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    echo "<script>alert('ID de producto no especificado'); window.location.href='../productos/mostrar_p.php';</script>";
    exit;
}

$data = getProduct($id);
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
  
    <div class="main-content" style="min-height: 100vh; width: 100%;">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../administrador/escritorio.php">Panel administrativo</a></li>
                        <li class="breadcrumb-item"><a href="../productos/mostrar_p.php">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
                    </ol>
                </nav>
                <!-- Card -->
                <div class="card" style="min-height: 485px">
                    <div class="card-header card-header-text">
                        <h4 class="card-title">¿Estás seguro de que quieres eliminar el producto de forma definitiva?</h4>
                        <p class="category">Esta acción eliminará el producto de manera permanente y no podrá recuperarse.</p>
                    </div>
                    <div class="card-content table-responsive">
                        <?php if(count($data) > 0): ?>
                            <?php foreach($data as $f): ?>
                                <form method="POST" autocomplete="off">
                                    <div class="row">
                                        <!-- Nombre del producto (solo lectura) -->
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
                                            <a class="btn btn-danger text-white" href="../productos/mostrar_p.php">Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                No se encontró ningún dato!
                            </div>
                        <?php endif; ?>
                    </div><!-- Fin .card-content -->
                </div><!-- Fin .card -->
            </div><!-- Fin .col -->
        </div><!-- Fin .row -->
    </div><!-- Fin .main-content -->
</div><!-- Fin #content -->

<!-- Scripts -->
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

<?php include_once '../../backend/php/st_dltprodc.php'; ?>
<?php ob_end_flush(); ?>
