<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location: administrador/escritorio.php');
}
include_once '../backend/php/ctlogx.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIKRAM YOGA</title>
    <link rel="stylesheet" href="../backend/css/style.css">
    <link rel="icon" type="image/png" href="../backend/img/bikram_yoga.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="login-wrapper">
        <!-- Columna izquierda con imagen -->
        <div class="box-image box-col">
            <img src="../backend/img/img2.jpg" alt="Bikram Yoga CDMX">
        </div>

        <!-- Columna derecha con formulario -->
        <div class="box-col">
            <div class="box-form">
                <div class="inner">
                    <div class="form-head">
                        <img src="../backend/img/bikram_yoga.jpg" alt="Logo" class="logo-pequeno">
                        <div class="title">
                            Bienvenido de nuevo
                        </div>
                        <br>
                        
                        <form class="login-form" autocomplete="off" method="post" role="form">
                            <!-- Campo Usuario -->
                            <div class="form-group">
                                <div class="label-text">Nombre de usuario</div>
                                <input type="text" name="usuario" 
                                    value="<?php if(isset($_POST['usuario'])) echo $_POST['usuario']; ?>" 
                                    autocomplete="off" 
                                    required 
                                    class="form-control" 
                                    placeholder="Ingrese su usuario">
                            </div>
                            
                            <!-- Campo Contraseña -->
                            <div class="form-group">
                                <div class="label-text">Contraseña</div>
                                <input name="clave" 
                                    type="password" 
                                    required 
                                    class="form-control" 
                                    placeholder="Ingrese su contraseña">
                            </div>
                            <?php 
                                if (isset($errMsg)) {
                                    echo '<div style="color:#9562f3;text-align:center;font-size:13px;">'.$errMsg.'</div>';
                                }
                            ?>
                            <!-- Botón de acceso -->
                            <div class="actions">
                                <button name='ctglog' type="submit" class="btn btn-submit">
                                    Acceder
                                    <div class="hoverEffect">
                                    <div></div>
                                    </div>
                                </button>   
                                <!-- Enlace opcional de registro -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../backend/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../backend/js/reenvio.js"></script>
</body>
</html>