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
                    <a class="navbar-brand" href="#"> Compras </a>
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
                            <li class="breadcrumb-item"><a href="mostrar.php">Compras</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Actualizar</li>
                        </ol>
                    </nav>
                    <!-- Card -->
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Actualizar compra</h4>
                            <p class="category">Actualiza los datos de la compra</p>
                        </div>
                        <div class="card-content table-responsive">
                            <div class="alert alert-warning">
                                <strong>Estimado usuario!</strong> Los campos remarcados con
                                <span class="text-danger">*</span> son necesarios.
                            </div>
                            <?php
                            require_once '../../backend/bd/ctconex.php';
                            // Obtenemos el id de la compra
                            $id = $_GET['id'];

                            // Consulta para obtener los datos de la compra
                            $sentencia = $connect->prepare("SELECT * FROM compra WHERE idcomp = :id");
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
                                    <!-- Formulario para actualizar -->
                                    <form method="POST" autocomplete="off">
                                        <!-- Campo oculto para el ID de la compra -->
                                        <input type="hidden" name="idcomp" value="<?php echo $f->idcomp; ?>">

                                        <div class="row">
                                            <!-- Método de Pago -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="method">Método de Pago <span class="text-danger">*</span></label>
                                                    <select class="form-control" required name="method">
                                                        <option value="<?php echo $f->method; ?>"><?php echo $f->method; ?></option>
                                                        <option value="">----------Seleccione------------</option>
                                                        <option value="Efectivo">Efectivo</option>
                                                        <option value="Tarjeta">Tarjeta</option>
                                                        <option value="Transferencia">Transferencia</option>
                                                        <option value="Paypal">Paypal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Total de Productos -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="total_products">Total de Productos <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="total_products" required value="<?php echo $f->total_products; ?>" placeholder="Cantidad de productos">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Precio Total -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="total_price">Precio Total <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="total_price" required value="<?php echo $f->total_price; ?>" placeholder="Precio total">
                                                </div>
                                            </div>
                                            <!-- Fecha de Compra -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="placed_on">Fecha de Compra <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="placed_on" required value="<?php echo $f->placed_on; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Estado de Pago -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="payment_status">Estado de Pago <span class="text-danger">*</span></label>
                                                    <select class="form-control" required name="payment_status">
                                                        <option value="<?php echo $f->payment_status; ?>"><?php echo $f->payment_status; ?></option>
                                                        <option value="">----------Seleccione------------</option>
                                                        <option value="Pendiente">Pendiente</option>
                                                        <option value="Completado">Completado</option>
                                                        <option value="Cancelado">Cancelado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Descripción de compra (tipc) -->
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="tipc">Descripción de compra <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="tipc" required value="<?php echo $f->tipc; ?>" placeholder="Ej: Donas, Ropa, etc.">
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button name="stupdcomp" class="btn btn-success text-white">Guardar</button>
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
                </div><!-- Fin col -->
            </div><!-- Fin row -->
        </div><!-- Fin .main-content -->
    </div><!-- Fin #content -->

    <!-- Scripts -->
    <script src="../../backend/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../../backend/js/popper.min.js"></script>
    <script src="../../backend/js/bootstrap.min.js"></script>
    <script src="../../backend/js/jquery-3.3.1.min.js"></script>
    <script src="../../backend/js/sweetalert.js"></script>
    <!-- Se incluye la lógica para actualizar la compra -->
    <?php include_once '../../backend/php/st_updcompr.php'; ?>

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
    </body>

    </html>

<?php } else {
    header('Location: ../erro404.php');
}
ob_end_flush();
?>