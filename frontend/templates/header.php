
<!doctype html>
<html lang="es">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>BIKRAM YOGA</title>
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../../backend/css/bootstrap.min.css">
  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="../../backend/css/custom.css">


  
  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="../../backend/css/datatable.css">
  <link rel="stylesheet" type="text/css" href="../../backend/css/buttonsdataTables.css">
  <link rel="stylesheet" type="text/css" href="../../backend/css/font.css">
  
  <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
  <!-- Conexión a Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  
  <!-- Google Material Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../../backend/img/bikram_yoga.jpg" />

  <style>
    /* Estilos personalizados para los botones de exportación */
    .dataTables_wrapper .btn-warning {
      background-color: #ff9800;
      border-color: #ff9800;
      color: #ffffff !important;
      border-radius: 5px;
    }
    .dataTables_wrapper .btn-warning:hover {
      background-color: #ff7700;
      border-color: #ff7700;
    }
    /* Botón CSV */
    .dataTables_wrapper .btn-csv {
      background-color: #4caf50;
      border-color: #4caf50;
      color: #ffffff !important;
    }
    .dataTables_wrapper .btn-csv:hover {
      background-color: #388e3c;
      border-color: #388e3c;
    }
    /* Botón Excel */
    .dataTables_wrapper .btn-excel {
      background-color: #2196f3;
      border-color: #2196f3;
      color: #ffffff !important;
    }
    .dataTables_wrapper .btn-excel:hover {
      background-color: #1565c0;
      border-color: #1565c0;
    }
    /* Botón PDF */
    .dataTables_wrapper .btn-pdf {
      background-color: #e91e63;
      border-color: #e91e63;
      color: #ffffff !important;
    }
    .dataTables_wrapper .btn-pdf:hover {
      background-color: #c2185b;
      border-color: #c2185b;
    }
    /* Botón Imprimir */
    .dataTables_wrapper .btn-print {
      background-color: #607d8b;
      border-color: #607d8b;
      color: #ffffff !important;
    }
    .dataTables_wrapper .btn-print:hover {
      background-color: #455a64;
      border-color: #455a64;
    }
  </style>
</head>
<body>

    <!-- Sidebar -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3>
          <img src="../../backend/img/bikram_yoga.jpg" class="img-fluid" alt="Bikram Yoga">
          <span>BIKRAM YOGA</span>
        </h3>
      </div>
      <ul class="list-unstyled components">
        <li>
          <a href="../administrador/escritorio.php" class="dashboard">
            <i class="material-icons">dashboard</i>
            <span>Panel administrativo</span>
          </a>
        </li>
        <!-- CLIENTES -->
        <li class="dropdown">
          <a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">group</i>
            <span>Clientes</span>
          </a>
          <ul class="collapse list-unstyled menu" id="homeSubmenu1">
            <li><a href="../clientes/mostrar.php">Mostrar</a></li>
            <li><a href="../clientes/nuevo.php">Nuevo</a></li>
          </ul>
        </li>
        <!-- PLANES -->
        <li class="dropdown">
          <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">dataset</i>
            <span>Planes</span>
          </a>
          <ul class="collapse list-unstyled menu" id="pageSubmenu2">
            <li><a href="../plan/mostrar.php">Mostrar</a></li>
            <li><a href="../plan/nuevo.php">Nuevo</a></li>
          </ul>
        </li>
        <!-- SERVICIOS -->
        <li>
          <a href="../servicio/mostrar.php">
            <i class="material-icons">view_timeline</i>
            <span>Servicio</span>
          </a>
        </li>
        <!-- USUARIOS -->
        <li class="dropdown">
          <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">manage_accounts</i>
            <span>Usuarios</span>
          </a>
          <ul class="collapse list-unstyled menu" id="pageSubmenu3">
            <li><a href="../usuario/mostrar.php">Mostrar</a></li>
          </ul>
        </li>
        <!-- PRODUCTOS -->
        <li class="dropdown">
          <a href="#pageSubmenu4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">conveyor_belt</i>
            <span>Productos</span>
          </a>
          <ul class="collapse list-unstyled menu" id="pageSubmenu4">
            <li><a href="../producto/mostrar.php">Mostrar</a></li>
            <li><a href="../producto/nuevo.php">Nuevo</a></li>
          </ul>
        </li>
        <!-- CATEGORIAS -->
        <li class="dropdown">
          <a href="#pageSubmenu5" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">category</i>
            <span>Categorias</span>
          </a>
          <ul class="collapse list-unstyled menu" id="pageSubmenu5">
            <li><a href="../categoria/mostrar.php">Mostrar</a></li>
            <li><a href="../categoria/nuevo.php">Nuevo</a></li>
          </ul>
        </li>
        <!-- VENTAS -->
        <li class="dropdown">
          <a href="#pageSubmenu6" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">point_of_sale</i>
            <span>Ventas</span>
          </a>
          <ul class="collapse list-unstyled menu" id="pageSubmenu6">
            <li><a href="../venta/mostrar.php">Mostrar</a></li>
            <li><a href="../venta/nuevo.php">Nuevo</a></li>
          </ul>
        </li>
        <!-- COMPRAS -->
        <li class="dropdown">
          <a href="#pageSubmenu09" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">shopping_basket</i>
            <span>Compras</span>
          </a>
          <ul class="collapse list-unstyled menu" id="pageSubmenu09">
            <li><a href="../compra/mostrar.php">Mostrar</a></li>
            <li><a href="../compra/nuevo.php">Nuevo</a></li>
          </ul>
        </li>
        <!-- GASTOS -->
        <li class="dropdown">
          <a href="#pageSubmenu010" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">savings</i>
            <span>Gastos</span>
          </a>
          <ul class="collapse list-unstyled menu" id="pageSubmenu010">
            <li><a href="../gastos/mostrar.php">Mostrar</a></li>
            <li><a href="../gastos/nuevo.php">Nuevo</a></li>
          </ul>
        </li>
        <!-- REPORTES -->
        <li class="dropdown">
          <a href="#pageSubmenu7" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">signal_cellular_alt</i>
            <span>Reportes</span>
          </a>
          <ul class="collapse list-unstyled menu" id="pageSubmenu7">
            <li><a href="../reporte/productos.php">Productos</a></li>
            <li><a href="../reporte/clientes.php">Clientes</a></li>
            <li><a href="../reporte/ventas.php">Ventas</a></li>
          </ul>
        </li>
        <!-- GRAFICOS -->
        <li class="dropdown">
          <a href="../graficos/mostrar.php">
            <i class="material-icons">grain</i>
            <span>Graficos</span>
          </a>
        </li>
        <!-- CONFIGURACION -->
        <li class="dropdown">
          <a href="../cuenta/configuracion.php">
            <i class="material-icons">settings</i>
            <span>Configuracion</span>
          </a>
        </li>
      </ul>
    </nav>
  
</body>
</html>
