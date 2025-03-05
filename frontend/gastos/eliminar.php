<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
    exit;
}
?>
<?php if (isset($_SESSION['id'])) { ?>

    <?php include_once "../templates/header.php" ?>

    <!-- Page Content -->
    <div id="content">
        <div class="top-navbar">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                        <span class="material-icons">arrow_back_ios</span>
                    </button>
                    <a class="navbar-brand" href="#"> Gastos </a>
                    <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
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

        <div class="main-content" style="min-height: 100vh; width: 100%;">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../administrador/escritorio.php">Panel administrativo</a></li>
                            <li class="breadcrumb-item"><a href="../gastos/mostrar.php">Gastos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
                        </ol>
                    </nav>
                    <!-- Card -->
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">¿Estás seguro de que quieres eliminar este gasto de forma definitiva?</h4>
                            <p class="category">Esta acción eliminará el gasto de manera permanente y no podrá recuperarse.</p>
                        </div>

                        <div class="card-content table-responsive">
                            <?php
                            require_once '../../backend/bd/ctconex.php';
                            $id = $_GET['id'];

                            // Obtenemos los datos del gasto
                            $sentencia = $connect->prepare("SELECT * FROM gastos WHERE idga = :id");
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
                                        <div class="row">
                                            <!-- Detalle -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label>Detalle <span class="text-danger">*</span></label>
                                                    <input type="text" readonly value="<?php echo $f->detail; ?>" class="form-control" name="detail">
                                                </div>
                                            </div>
                                            <!-- Monto -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label>Monto <span class="text-danger">*</span></label>
                                                    <input type="text" readonly value="<?php echo $f->total; ?>" class="form-control" name="total">
                                                </div>
                                            </div>
                                            <!-- Fecha -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label>Fecha <span class="text-danger">*</span></label>
                                                    <input type="date" readonly value="<?php echo $f->fec; ?>" class="form-control" name="fec">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Campo oculto para el ID del gasto -->
                                        <input type="hidden" name="txtidg" value="<?php echo $f->idga; ?>">
                                        <hr>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button name="stdltgasto" class="btn btn-success text-white">Eliminar</button>
                                                <a class="btn btn-danger text-white" href="../gastos/mostrar.php">Cancelar</a>
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
    <script type="text/javascript">
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
    <?php include_once '../../backend/php/st_dltgasto.php'; ?>
    </body>

    </html>

<?php } else {
    header('Location: ../erro404.php');
} ?>
<?php ob_end_flush(); ?>