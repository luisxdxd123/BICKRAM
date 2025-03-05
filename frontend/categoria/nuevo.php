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
    
    <!-- Contenedor fluido -->
    <div class="container-fluid" style="min-height: 100vh; width: 100%;">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../administrador/escritorio.php">Panel administrativo</a></li>
                        <li class="breadcrumb-item"><a href="mostrar.php">Categorías</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                    </ol>
                </nav>
                <!-- Card de Registro -->
                <div class="card" style="min-height: 485px;">
                    <div class="card-header card-header-text">
                        <h4 class="card-title">Registro de nueva categoría</h4>
                        <p class="category">Registrar una nueva categoría en el sistema</p>
                    </div>
                    <div class="card-content table-responsive">
                        <div class="alert alert-warning">
                            <strong>Estimado usuario!</strong> Los campos remarcados con <span class="text-danger">*</span> son necesarios.
                        </div>
                        <form enctype="multipart/form-data" method="POST" autocomplete="off">
                            <div class="row">
                                <!-- Nombre de la Categoría -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtnomca">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="txtnomca" required placeholder="Nombre de la categoría">
                                    </div>
                                </div>
                                <!-- Estado -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtestado">Estado <span class="text-danger">*</span></label>
                                        <select class="form-control" name="txtestado" required>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Fecha de registro (autocompleta con la fecha actual) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtfere">Fecha de registro <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="txtfere" required value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button name="staddcateg" class="btn btn-success text-white">Guardar</button>
                                    <a class="btn btn-danger text-white" href="mostrar.php">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div><!-- Fin card-content -->
                </div><!-- Fin card -->
            </div><!-- Fin col -->
        </div><!-- Fin row -->
    </div><!-- Fin container-fluid -->
</div><!-- Fin #content -->

<!-- Scripts -->
<script src="../../backend/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../backend/js/popper.min.js"></script>
<script src="../../backend/js/bootstrap.min.js"></script>
<script src="../../backend/js/jquery-3.3.1.min.js"></script>
<script src="../../backend/js/sweetalert.js"></script>
<?php include_once '../../backend/php/st_add_categ.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sidebarCollapse').on('click', function(){
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
        });
        $('.more-button, .body-overlay').on('click', function(){
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
}
ob_end_flush();
?>