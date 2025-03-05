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

    <!-- Page Content  -->
    <div id="content">
        <div class="top-navbar">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                        <span class="material-icons">arrow_back_ios</span>
                    </button>
                    <a class="navbar-brand" href="#"> Servicio </a>
                    <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                                    <img src="../../backend/img/reere.png">
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
                            <li class="breadcrumb-item"><a href="../servicio/mostrar.php">Servicios</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
                        </ol>
                    </nav>
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">¿Estás seguro de que quieres eliminar este servicio de forma definitiva?</h4>
                            <p class="category">Esta acción eliminará el servicio de manera permanente y no podrá recuperarse.</p>
                        </div>

                        <div class="card-content table-responsive">
                            <?php
                            require '../../backend/bd/ctconex.php';
                            $id = $_GET['id'];
                            
                            // Si se envía el formulario, procesamos la eliminación
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['stdltserv'])) {
                                $id = $_POST['txtidc'];
                                $stmt = $connect->prepare("DELETE FROM servicio WHERE idservc = :id");
                                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                                if ($stmt->execute()) {
                                    header("Location: ../servicio/mostrar.php?eliminado=1");
                                    exit;
                                } else {
                                    $error = "Error al eliminar el servicio.";
                                }
                            }

                            $sentencia = $connect->prepare("SELECT servicio.idservc, plan.idplan, plan.foto, plan.nompla, servicio.ini, servicio.fin, clientes.idclie, clientes.numid, clientes.nomcli, clientes.apecli, clientes.naci, clientes.celu, clientes.correo, servicio.estod, servicio.fere FROM servicio INNER JOIN plan ON servicio.idplan = plan.idplan INNER JOIN clientes ON servicio.idclie = clientes.idclie WHERE servicio.idservc= :id");
                            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
                            $sentencia->execute();

                            $data =  array();
                            if ($sentencia) {
                                while ($r = $sentencia->fetchObject()) {
                                    $data[] = $r;
                                }
                            }
                            ?>
                            <?php if (count($data) > 0) : ?>
                                <?php foreach ($data as $f) : ?>
                                    <?php if(isset($error)) { echo "<div class='alert alert-danger'>{$error}</div>"; } ?>
                                    <form enctype="multipart/form-data" method="POST" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="email">Plan<span class="text-danger">*</span></label>
                                                    <select disabled class="form-control" name="txtpln">
                                                        <option value="<?php echo $f->idplan; ?>"><?php echo $f->nompla; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="email">Cliente<span class="text-danger">*</span></label>
                                                    <select class="form-control" disabled name="txtcli">
                                                        <option value="<?php echo $f->idclie; ?>"><?php echo $f->nomcli . " " . $f->apecli; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="email">Estado del servicio<span class="text-danger">*</span></label>
                                                    <select class="form-control" disabled name="txtesta">
                                                        <option value="<?php echo $f->estod; ?>"><?php echo $f->estod; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="email">Fecha de inicio<span class="text-danger">*</span></label>
                                                    <input type="date" value="<?php echo $f->ini; ?>" class="form-control" name="txtini" disabled>
                                                    <input type="hidden" value="<?php echo $f->idservc; ?>" name="txtidc">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="email">Fecha de vencimiento<span class="text-danger">*</span></label>
                                                    <input type="date" id="fechad" value="<?php echo $f->fin; ?>" class="form-control" name="txtfin" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button name="stdltserv" class="btn btn-success text-white">Eliminar</button>
                                                <a class="btn btn-danger text-white" href="../servicio/mostrar.php">Cancelar</a>
                                            </div>
                                        </div>
                                    </form>
                                <?php endforeach; ?>
                            <?php else : ?>
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
    <script>
        // Obtener fecha actual para establecer el mínimo en el input de fecha (aunque esté deshabilitado)
        let fecha = new Date();
        fecha.setDate(fecha.getDate());
        let fechaMin = fecha.toISOString().split('T')[0];
        document.querySelector('#fechad').min = fechaMin;
    </script>
</body>
</html>

<?php } else {
    header('Location: ../erro404.php');
} ?>
<?php ob_end_flush(); ?>
