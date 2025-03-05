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
        
        <!-- Contenedor fluido para ocupar todo el ancho -->
        <div class="container-fluid" style="min-height: 100vh; width: 100%;">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../administrador/escritorio.php">Panel administrativo</a></li>
                            <li class="breadcrumb-item"><a href="../compra/mostrar.php">Compras</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                        </ol>
                    </nav>
                    <!-- Card de Registro -->
                    <div class="card" style="min-height: 485px;">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Registro de nueva compra</h4>
                            <p class="category">Registrar una nueva compra en el sistema</p>
                        </div>
                        <div class="card-content table-responsive">
                            <div class="alert alert-warning">
                                <strong>Estimado usuario!</strong> Los campos remarcados con <span class="text-danger">*</span> son necesarios.
                            </div>
                            <form enctype="multipart/form-data" method="POST" autocomplete="off">
                                <div class="row">
                                    <!-- Método de Pago -->
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="method">Método de Pago <span class="text-danger">*</span></label>
                                            <select class="form-control" required name="method">
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
                                            <input type="number" class="form-control" name="total_products" required placeholder="Cantidad de productos">
                                        </div>
                                    </div>
                               
                                    <!-- Precio Total -->
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="total_price">Precio Total <span class="text-danger">*</span></label>
                                            <input type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" 
                                                   class="form-control" name="total_price" required placeholder="Precio total">
                                        </div>
                                    </div>
                                    <!-- Fecha de Compra (autocompleta con la fecha actual) -->
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="placed_on">Fecha de Compra <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="placed_on" required value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                

                                <!-- Nueva fila: Estado de Pago y Tipo de Compra -->
                                
                                    <!-- Estado de Pago -->
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="payment_status">Estado de Pago <span class="text-danger">*</span></label>
                                            <select class="form-control" required name="payment_status">
                                                <option value="Pendiente">Pendiente</option>
                                                <option value="Completado">Completado</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Tipo de Compra -->
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="tipc">Descripción de Compra <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="tipc" placeholder="Tipo de compra">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button name="staddcompra" class="btn btn-success text-white">Guardar</button>
                                        <a class="btn btn-danger text-white" href="../compra/mostrar.php">Cancelar</a>
                                    </div>
                                </div>
                            </form>
                        </div><!-- Fin de card-content -->
                    </div><!-- Fin de card -->
                </div><!-- Fin de col -->
            </div><!-- Fin de row -->
        </div><!-- Fin de container-fluid -->
    </div><!-- Fin de #content -->

    <!-- Optional JavaScript -->
    <script src="../../backend/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../../backend/js/popper.min.js"></script>
    <script src="../../backend/js/bootstrap.min.js"></script>
    <script src="../../backend/js/jquery-3.3.1.min.js"></script>
    <script src="../../backend/js/sweetalert.js"></script>
    <?php include_once '../../backend/php/st_add_compr.php' ?>
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

<?php } else {
    header('Location: ../erro404.php');
} ?>
<?php ob_end_flush(); ?>
