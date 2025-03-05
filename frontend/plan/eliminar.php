<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
}
?>
<?php if (isset($_SESSION['id'])) { ?>

    <!doctype html>
    <html lang="es">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>BIKRAM YOGA</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../backend/css/bootstrap.min.css">
        <!----css3---->
        <link rel="stylesheet" href="../../backend/css/custom.css">
        <link rel="stylesheet" href="../../backend/css/loader.css">


        <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <!--google material icon-->
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons"
            rel="stylesheet">
        <link rel="icon" type="image/jpg" href="../../backend/img/yoga2.jpg" />
    </head>

    <body>

        <div class="wrapper">

            <div class="body-overlay"></div>
            <!-- Sidebar  -->
            <?php
            require_once '../templates/header.php';
            ?>


            <!-- Page Content  -->
            <div id="content">
                <div class='pre-loader'>

                </div>
                <div class="top-navbar">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">

                            <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                                <span class="material-icons">arrow_back_ios</span>
                            </button>

                            <a class="navbar-brand" href="#"> Planes </a>

                            <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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

                <div class="main-content" style="min-height: 100vh; width: 100%;">
                    <div class="row ">
                        <div class="col-lg-12 col-md-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../administrador/escritorio.php">Panel administrativo</a></li>
                                    <li class="breadcrumb-item"><a href="../plan/mostrar.php">Planes </a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Desactivar</li>
                                </ol>
                            </nav>
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">¿Estás seguro de que quieres eliminarlo?</h4>
                                    <p class="category">Desactivar plan reciente añadidos el dia de hoy</p>
                                </div>

                                <div class="card-content table-responsive">

                                    <?php
                                    require '../../backend/bd/ctconex.php';
                                    $id = $_GET['id'];
                                    $sentencia = $connect->prepare("SELECT * FROM plan WHERE idplan= '$id';");
                                    $sentencia->execute();

                                    $data =  array();
                                    if ($sentencia) {
                                        while ($r = $sentencia->fetchObject()) {
                                            $data[] = $r;
                                        }
                                    }
                                    ?>
                                    <?php if (count($data) > 0): ?>
                                        <?php foreach ($data as $f): ?>
                                            <form enctype="multipart/form-data" method="POST" autocomplete="off">
                                                <div class="row">


                                                    <div class="col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="email">Nombre del plan<span class="text-danger">*</span></label>
                                                            <input type="text" readonly value="<?php echo  $f->nompla; ?>" class="form-control" name="txtnampla" required placeholder="Nombre del plan">
                                                            <input type="hidden" value="<?php echo  $f->idplan; ?>" name="txtidc">
                                                        </div>
                                                    </div>

                                                </div>



                                                <hr>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <button name='studltplan' class="btn btn-success text-white">Eliminar</button>
                                                        <a class="btn btn-danger text-white" href="../plan/mostrar.php">Cancelar</a>
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
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="../../backend/js/jquery-3.3.1.slim.min.js"></script>
        <script src="../../backend/js/popper.min.js"></script>
        <script src="../../backend/js/bootstrap.min.js"></script>
        <script src="../../backend/js/jquery-3.3.1.min.js"></script>
        <script src="../../backend/js/sweetalert.js"></script>
        <?php
        include_once '../../backend/php/st_dltpln.php'
        ?>

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
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#blah')
                            .attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

    </body>

    </html>





<?php } else {
    header('Location: ../erro404.php');
} ?>
<?php ob_end_flush(); ?>