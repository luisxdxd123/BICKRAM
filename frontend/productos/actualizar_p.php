<?php include_once '../../backend/php/st_updpro.php'; ?>
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

    <div class="main-content">
        <div class="row ">
            <div class="col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../administrador/escritorio.php">Panel administrativo</a></li>
                        <li class="breadcrumb-item"><a href="../productos/mostrar.php">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Actualizar</li>
                    </ol>
                </nav>
                <div class="card" style="min-height: 485px">
                    <div class="card-header card-header-text">
                        <h4 class="card-title">Actualizar Producto</h4>
                        <p class="category">Modifique los datos del producto</p>
                    </div>
                    <div class="card-content table-responsive">
                        <div class="alert alert-warning">
                            <strong>Estimado usuario!</strong> Los campos remarcados con 
                            <span class="text-danger">*</span> son obligatorios.
                        </div>
                        <form enctype="multipart/form-data" method="POST" autocomplete="off">
                            <div class="row">
                                <!-- Código de Barras -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtnum">Código de Barras 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" maxlength="14" class="form-control" name="txtnum" id="txtnum" required 
                                               placeholder="Código de barras" value="<?php echo $product->codba; ?>">
                                    </div>
                                </div>
                                <!-- Nombre del Producto -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtnaame">Nombre del Producto 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="txtnaame" id="txtnaame" required 
                                               placeholder="Nombre del producto" value="<?php echo $product->nomprd; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Categoría (select) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtape">Categoría 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" name="txtape" id="txtape" required>
                                            <option value="">Seleccione una categoría</option>
                                            <?php foreach ($categorias as $cat): ?>
                                                <option value="<?php echo $cat->idcate; ?>" <?php if ($cat->idcate == $product->idcate) echo 'selected'; ?>>
                                                    <?php echo $cat->idcate . ' - ' . $cat->nomca; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Precio -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtcel">Precio 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" maxlength="10" name="txtcel" id="txtcel" required 
                                               placeholder="Precio" value="<?php echo $product->precio; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Stock -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="txtema">Stock</label>
                                        <input type="number" class="form-control" name="txtema" id="txtema" 
                                               placeholder="Stock" value="<?php echo $product->stock; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Estado -->
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="txtesta">Estado 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" name="txtesta" id="txtesta" required>
                                            <!-- Se muestra primero el estado actual del producto -->
                                            <option value="<?php echo $product->esta; ?>">
                                                <?php echo $product->esta; ?>
                                            </option>
                                            <option value="">-----Seleccione-----</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button name="stupdcst" class="btn btn-success text-white">Guardar</button>
                                    <a class="btn btn-danger text-white" href="../productos/mostrar.php">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts principales -->
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

<?php 
// Mostrar SweetAlert después de cargar las librerías JS
if(isset($mostrarSweetAlert) && $mostrarSweetAlert): ?>
    <script type="text/javascript">
        swal("¡Actualizado!", "Se actualizó correctamente", "success")
        .then(function() {
            window.location = "../productos/mostrar.php";
        });
    </script>
<?php endif; ?>

<?php include_once "../templates/footer.php"; ?>
