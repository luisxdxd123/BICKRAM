<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: ../erro404.php');
    exit;
}
if (isset($_SESSION['id'])) {
    include_once "../templates/header.php";
?>
<!-- Page Content -->
<div id="content">
    <div class="top-navbar">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-none d-none">
                    <span class="material-icons">arrow_back_ios</span>
                </button>
                <!-- Cambiar título a Categorías -->
                <a class="navbar-brand" href="#"> Categorías </a>
                <button class="d-inline-block d-lg-none ml-auto more-button" type="button" 
                        data-toggle="collapse" data-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" 
                        aria-label="Toggle navigation">
                    <span class="material-icons">more_vert</span>
                </button>
                <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none" 
                     id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../cuenta/configuracion.php">
                                <span class="material-icons">settings</span>
                            </a>
                        </li>
                        <li class="dropdown nav-item active">
                            <a href="#" class="nav-link" data-toggle="dropdown">
                                <img src="../../backend/img/reere.png">
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

    <!-- Contenido principal -->
    <div class="main-content" style="min-height: 100vh; width: 100%;">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Breadcrumb adaptado a categorías -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../administrador/escritorio.php">Panel administrativo</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="mostrar.php">Categorías</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
                    </ol>
                </nav>
                <!-- Card -->
                <div class="card" style="min-height: 485px">
                    <div class="card-header card-header-text">
                        <h4 class="card-title">¿Estás seguro de que deseas eliminar esta categoría?</h4>
                        <p class="category">Esta acción no podrá deshacerse.</p>
                    </div>
                    <div class="card-content table-responsive">
                        <?php
                        require '../../backend/bd/ctconex.php';
                        $id = $_GET['id'];
                        $sentencia = $connect->prepare("SELECT * FROM categoria WHERE idcate = :id");
                        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
                        $sentencia->execute();

                        $data = array();
                        if ($sentencia) {
                            while ($r = $sentencia->fetchObject()) {
                                $data[] = $r;
                            }
                        }
                        ?>
                        <?php if (count($data) > 0) : ?>
                            <?php foreach ($data as $f) : ?>
                                <form method="POST" autocomplete="off">
                                    <div class="row">
                                        <!-- Mostrar el nombre de la categoría -->
                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Nombre de la categoría <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" 
                                                       value="<?php echo $f->nomca; ?>" readonly>
                                                <input type="hidden" name="txtidc" value="<?php echo $f->idcate; ?>">
                                            </div>
                                        </div>
                                        <!-- Mostrar estado (opcional) -->
                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <input type="text" class="form-control" 
                                                       value="<?php echo $f->estado; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button name="stdltcateg" class="btn btn-success text-white">Eliminar</button>
                                            <a class="btn btn-danger text-white" href="mostrar.php">Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="alert alert-warning" role="alert">
                                ¡No se encontró ningún dato!
                            </div>
                        <?php endif; ?>
                    </div><!-- Fin .card-content -->
                </div><!-- Fin .card -->
            </div><!-- Fin .col -->
        </div><!-- Fin .row -->
    </div><!-- Fin .main-content -->
</div><!-- Fin #content -->

<!-- Scripts de JS y SweetAlert -->
<script src="../../backend/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../backend/js/popper.min.js"></script>
<script src="../../backend/js/bootstrap.min.js"></script>
<script src="../../backend/js/jquery-3.3.1.min.js"></script>
<script src="../../backend/js/sweetalert.js"></script>
<?php
// Incluir el archivo de procesamiento para eliminar
include_once '../../backend/php/st_dltcateg.php';
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
        });
        $('.more-button, .body-overlay').on('click', function() {
            $('#sidebar, .body-overlay').toggleClass('show-nav');
        });
    });
</script>
<script src="../../backend/js/loader.js"></script>
</body>
</html>
<?php
} else {
    header('Location: ../erro404.php');
    exit;
}
ob_end_flush();
?>