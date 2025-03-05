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

    <!-- Main Content -->
    <div class="main-content" style="min-height: 100vh; width: 100%;">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../administrador/escritorio.php">Panel administrativo</a></li>
                        <li class="breadcrumb-item"><a href="mostrar.php">Categorías</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Actualizar</li>
                    </ol>
                </nav>
                <!-- Card -->
                <div class="card" style="min-height: 485px">
                    <div class="card-header card-header-text">
                        <h4 class="card-title">Actualizar categoría</h4>
                        <p class="category">Actualiza los datos de la categoría seleccionada</p>
                    </div>
                    <div class="card-content table-responsive">
                        <div class="alert alert-warning">
                            <strong>Estimado usuario!</strong> Los campos marcados con <span class="text-danger">*</span> son necesarios.
                        </div>
                        <?php
                        require_once '../../backend/bd/ctconex.php';
                        $id = $_GET['id'];
                        $sentencia = $connect->prepare("SELECT * FROM categoria WHERE idcate = :id");
                        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
                        $sentencia->execute();
                        $data = [];
                        if ($sentencia) {
                            while ($r = $sentencia->fetchObject()) {
                                $data[] = $r;
                            }
                        }
                        ?>
                        <?php if (count($data) > 0) : ?>
                            <?php foreach ($data as $f) : ?>
                                <form method="POST" autocomplete="off">
                                    <input type="hidden" name="txtidc" value="<?php echo $f->idcate; ?>">
                                    <div class="row">
                                        <!-- Nombre de la categoría -->
                                        <div class="col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="txtnomca">Nombre de la categoría <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="txtnomca" id="txtnomca" required value="<?php echo $f->nomca; ?>">
                                            </div>
                                        </div>
                                        <!-- Estado -->
                                        <div class="col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="txtestado">Estado <span class="text-danger">*</span></label>
                                                <select class="form-control" name="txtestado" id="txtestado" required>
                                                    <option value="<?php echo $f->estado; ?>"><?php echo $f->estado; ?></option>
                                                    <option>----------Seleccione----------</option>
                                                    <option value="Activo">Activo</option>
                                                    <option value="Inactivo">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Fecha de registro -->
                                        <div class="col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="txtfere">Fecha de registro</label>
                                                <input type="date" class="form-control" name="txtfere" id="txtfere" value="<?php echo (!empty($f->fere) ? $f->fere : date('Y-m-d')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button name="stupdcateg" class="btn btn-success text-white">Guardar</button>
                                            <a class="btn btn-danger text-white" href="mostrar.php">Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        <?php else : ?>
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
<?php include_once '../../backend/php/st_updcateg.php'; ?>
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
<!-- Script para autocompletar la fecha si el campo está vacío -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var dateInput = document.getElementById('txtfere');
        if(!dateInput.value) {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; // Los meses comienzan en 0
            var yyyy = today.getFullYear();
            if(dd < 10) { dd = '0' + dd; }
            if(mm < 10) { mm = '0' + mm; }
            today = yyyy + '-' + mm + '-' + dd;
            dateInput.value = today;
        }
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