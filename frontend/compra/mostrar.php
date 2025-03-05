<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
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

                    <a class="navbar-brand" href="#"> Compras </a>

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
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Compras recientes</h4>
                            <p class="category">Últimas compras registradas</p>
                        </div>
                        <br>
                        <a href="../compra/nuevo.php" class="btn btn-danger text-white mx-3">Nueva compra</a>

                        <br>
                        <div class="card-content table-responsive">
                            <?php
                            require '../../backend/bd/ctconex.php';
                            $sentencia = $connect->prepare("SELECT * FROM compra ORDER BY idcomp DESC;");
                            $sentencia->execute();

                            $data = [];
                            if ($sentencia) {
                                while ($r = $sentencia->fetchObject()) {
                                    $data[] = $r;
                                }
                            }
                            ?>

                            <?php if (count($data) > 0) : ?>
                                <table class="table table-hover" id="example">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Método de pago</th>
                                            <th>Total de productos</th>
                                            <th>Precio total</th>
                                            <th>Descripcion</th>
                                            <th>Fecha</th>
                                            <th>Estado de pago</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data as $compra) : ?>
                                            <tr>
                                                <td><?php echo $compra->method; ?></td>
                                                <td><?php echo $compra->total_products; ?></td>
                                                <td>$<?php echo number_format($compra->total_price, 2); ?></td>
                                                <td><?php echo $compra->tipc; ?></td>
                                                <td><?php echo $compra->placed_on; ?></td>
                                                <td>
                                                    <?php 
                                                    if ($compra->payment_status == 'Completado') {
                                                        echo '<span class="badge badge-success">Completado</span>';
                                                    } elseif ($compra->payment_status == 'Cancelado') {
                                                        echo '<span class="badge badge-danger">Cancelado</span>';
                                                    } else {
                                                        echo '<span class="badge badge-warning">Pendiente</span>';
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <a class="btn btn-primary text-white" href="../compra/informacion.php?id=<?php echo $compra->idcomp; ?>"><i class='material-icons' title='Visualizar'>visibility</i></a>
                                                    <a class="btn btn-warning text-white" href="../compra/actualizar.php?id=<?php echo $compra->idcomp; ?>"><i class='material-icons' title='Editar'>edit</i></a>
                                                    <a class="btn btn-danger text-white" href="../compra/eliminar.php?id=<?php echo $compra->idcomp; ?>"><i class='material-icons' title='Eliminar'>delete</i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <div class="alert alert-warning" role="alert">
                                    No hay compras registradas.
                                </div>
                            <?php endif; ?>
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
    <!-- Data Tables -->
    <script type="text/javascript" src="../../backend/js/datatable.js"></script>
    <script type="text/javascript" src="../../backend/js/datatablebuttons.js"></script>
    <script type="text/javascript" src="../../backend/js/jszip.js"></script>
    <script type="text/javascript" src="../../backend/js/pdfmake.js"></script>
    <script type="text/javascript" src="../../backend/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonshtml5.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonsprint.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-MX.json',
                },
                // Añadiendo botón para exportar a Excel
                "buttons": [{
                        "extend": "copy",
                        "text": "<span class=\"material-symbols-outlined\">content_paste</span>",
                        "titleAttr": "Copiar",
                        "className": "btn btn-warning"
                    },
                    {
                        "extend": "csv",
                        "text": "<span class=\"material-symbols-outlined\">csv</span>",
                        "titleAttr": "Exportar en CSV",
                        "className": "btn btn-excel",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                    },
                    {
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        "extend": "excel",
                        "text": "<span class=\"material-symbols-outlined\">draft</span>",
                        "titleAttr": "Exportar en Excel",
                        "className": "btn btn-csv",
                    },

                    {
                        "extend": "pdf",
                        "text": "<span class=\"material-symbols-outlined\">picture_as_pdf</span>",
                        "titleAttr": "Exportar en PDF",
                        "className": "btn btn-pdf",
                        "exportOptions": {
                            modifier: {
                                page: 'current',
                                rows: function(node, data) {
                                    return data.length;
                                }
                            }
                        },
                        // Evento customize para ocultar la última columna al exportar en PDF
                        customize: function(doc) {
                            doc.content[1].table.body.forEach(function(row) {
                                row.splice(-1, 1);
                            });
                        }
                    },
                    {
                        // Evento beforePrint para ocultar la última columna al imprimir
                        customize: function(win) {
                            $(win.document.body).find('table').find('td:last-child, th:last-child').remove();
                        },
                        // Callback después de imprimir para restaurar la tabla original
                        title: '',
                        messageTop: function() {
                            table.columns.adjust().draw();
                        },
                        "extend": "print",
                        "text": "<span class=\"material-symbols-outlined\">print</span>",
                        "titleAttr": "Imprimir",
                        "className": "btn btn-print",

                    },
                ],
            });
        });
    </script>

    </body>

    </html>

<?php } else {
    header('Location: ../erro404.php');
} ?>

<?php ob_end_flush(); ?>
