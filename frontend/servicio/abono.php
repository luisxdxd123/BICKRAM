<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
    exit;
}

require '../../backend/bd/ctconex.php';

// Procesamiento vía AJAX para registrar el abono
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'abono') {
    header('Content-Type: application/json');
    $id = $_POST['id'] ?? null;
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado.']);
        exit;
    }
    // Consultar detalles del servicio
    $stmt = $connect->prepare("
        SELECT servicio.idservc, servicio.canc, plan.prec AS total
        FROM servicio
        INNER JOIN plan ON servicio.idplan = plan.idplan
        WHERE servicio.idservc = :id
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$service) {
        echo json_encode(['success' => false, 'message' => 'Servicio no encontrado.']);
        exit;
    }
    $total = $service['total'];
    $current_payment = $service['canc'];
    $due = $total - $current_payment;
    $abono = isset($_POST['monto']) ? floatval($_POST['monto']) : 0;
    if ($abono <= 0) {
        echo json_encode(['success' => false, 'message' => 'El monto del abono debe ser mayor que cero.']);
        exit;
    } elseif ($abono > $due) {
        echo json_encode(['success' => false, 'message' => 'El monto del abono no puede ser mayor que la deuda pendiente ($' . number_format($due, 2) . ').']);
        exit;
    } else {
        $new_payment = $current_payment + $abono;
        $update = $connect->prepare("UPDATE servicio SET canc = :new_payment WHERE idservc = :id");
        $update->bindParam(':new_payment', $new_payment, PDO::PARAM_STR);
        $update->bindParam(':id', $id, PDO::PARAM_INT);
        if ($update->execute()) {
            echo json_encode(['success' => true, 'message' => 'Abono registrado correctamente.']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar el abono.']);
            exit;
        }
    }
}

// Consulta para obtener todos los servicios con adeudo pendiente
$stmt = $connect->prepare("
    SELECT servicio.idservc, clientes.nomcli, clientes.apecli, plan.nompla, plan.prec AS total, servicio.canc,
    (plan.prec - servicio.canc) AS due
    FROM servicio
    INNER JOIN plan ON servicio.idplan = plan.idplan
    INNER JOIN clientes ON servicio.idclie = clientes.idclie
    WHERE (plan.prec - servicio.canc) > 0
    ORDER BY servicio.idservc DESC
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Abono de Pagos</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* =============================================
   Reset y estilos básicos
============================================= */
*,
*::before,
*::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  font-size: 16px;
  scroll-behavior: smooth;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f4f7f6;
  color: #333;
  line-height: 1.5;
  padding: 20px;
}

/* Enlaces */
a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s ease;
}
a:hover {
  color: #007bff;
}

/* =============================================
   Contenedor Principal y Tarjetas
============================================= */
.container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
}

.card-custom {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  animation: fadeIn 1s ease-in-out;
  margin-bottom: 30px;
}

.card-header-custom {
  background-color: #007bff;
  color: #fff;
  padding: 15px;
  font-size: 1.5rem;
  text-align: center;
  position: relative;
}

.card-body {
  padding: 20px;
}

/* =============================================
   Tablas y Listados
============================================= */
.table-responsive {
  margin-top: 20px;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: #f9f9f9;
}

.table-striped tbody tr:hover {
  background-color: #e9f7ff;
  transition: background-color 0.3s ease;
}

.table th {
  background-color: #343a40;
  color: #fff;
}

/* =============================================
   Botones
============================================= */
.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  vertical-align: middle;
  user-select: none;
  background-color: #007bff;
  border: 1px solid #007bff;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: background-color 0.3s, border-color 0.3s, transform 0.2s;
  cursor: pointer;
}

.btn:hover {
  background-color: #0056b3;
  border-color: #0056b3;
  transform: translateY(-2px);
}

.btn:active {
  transform: translateY(0);
}

.btn-secondary {
  background-color: #6c757d;
  border-color: #6c757d;
}

.btn-secondary:hover {
  background-color: #565e64;
  border-color: #4e555b;
}

/* Botón minimal */
.btn-minimal {
  border-radius: 20px;
  font-size: 0.9rem;
  padding: 0.4rem 0.8rem;
}

/* =============================================
   Formularios
============================================= */
.form-label {
  margin-bottom: 5px;
  font-weight: 600;
}

.form-control {
  border-radius: 5px;
  padding: 10px;
  border: 1px solid #ccc;
  transition: border-color 0.3s ease;
}

.form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* =============================================
   Alertas
============================================= */
.alert {
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 0.95rem;
  margin-bottom: 15px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}

/* =============================================
   Modal
============================================= */
.modal-content {
  border-radius: 10px;
  overflow: hidden;
  animation: slideDown 0.5s ease;
}

.modal-header {
  padding: 15px;
  border-bottom: none;
}

.modal-body {
  padding: 20px;
}

.btn-close {
  background: transparent;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}

/* =============================================
   Animaciones
============================================= */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideDown {
  from { transform: translateY(-20px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* =============================================
   Transiciones y efectos adicionales
============================================= */
tr {
  transition: background-color 0.3s ease;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

/* =============================================
   Estilos para parecer que sigues en la página de servicios
============================================= */
body::before {
  content: "Servicios";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  padding: 10px 20px;
  background: rgba(0, 123, 255, 0.9);
  color: #fff;
  font-size: 1.2rem;
  font-weight: bold;
  z-index: 9999;
  text-align: center;
}

body {
  padding-top: 60px; /* Espacio para el banner fijo */
}

/* =============================================
   Responsive
============================================= */
@media (max-width: 768px) {
  .container {
    padding: 10px;
  }
  .card-header-custom {
    font-size: 1.25rem;
    padding: 10px;
  }
  .table th,
  .table td {
    padding: 8px;
  }
  .btn {
    padding: 0.3rem 0.6rem;
    font-size: 0.9rem;
  }
}

  </style>
</head>
<body>
<div class="container">
  <!-- Botón Regresar -->
  <div class="mb-3">
      <a href="mostrar.php" class="btn btn-secondary btn-minimal">Regresar</a>
  </div>
  <div class="card card-custom">
      <div class="card-header card-header-custom">
          Usuarios con Adeudo
      </div>
      <div class="card-body">
        <?php if(count($users) > 0): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID Servicio</th>
                        <th>Cliente</th>
                        <th>Plan</th>
                        <th>Total</th>
                        <th>Pagado</th>
                        <th>Deuda</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr data-id="<?php echo htmlspecialchars($user['idservc']); ?>"
                            data-nombre="<?php echo htmlspecialchars($user['nomcli'] . " " . $user['apecli']); ?>"
                            data-total="<?php echo htmlspecialchars($user['total']); ?>"
                            data-pagado="<?php echo htmlspecialchars($user['canc']); ?>"
                            data-due="<?php echo htmlspecialchars($user['due']); ?>">
                            <td><?php echo htmlspecialchars($user['idservc']); ?></td>
                            <td><?php echo htmlspecialchars($user['nomcli'] . " " . $user['apecli']); ?></td>
                            <td><?php echo htmlspecialchars($user['nompla']); ?></td>
                            <td>$<?php echo number_format($user['total'], 2); ?></td>
                            <td>$<?php echo number_format($user['canc'], 2); ?></td>
                            <td>$<?php echo number_format($user['due'], 2); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm btn-minimal open-abono-modal">Registrar Abono</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-info">No hay usuarios con adeudos pendientes.</div>
        <?php endif; ?>
      </div>
  </div>
</div>

<!-- Modal para registrar abono -->
<div class="modal fade" id="abonoModal" tabindex="-1" aria-labelledby="abonoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #007bff; color: #fff; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h5 class="modal-title" id="abonoModalLabel">Registrar Abono</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body">
        <div id="modalAlert" class="alert d-none"></div>
        <form id="abonoForm">
          <input type="hidden" name="id" id="serviceId">
          <input type="hidden" name="action" value="abono">
          <div class="mb-3">
            <label class="form-label">Cliente</label>
            <input type="text" class="form-control" id="clienteName" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Total del Plan</label>
            <input type="text" class="form-control" id="totalPlan" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Pago Actual</label>
            <input type="text" class="form-control" id="pagoActual" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Deuda Pendiente</label>
            <input type="text" class="form-control" id="deudaPendiente" readonly>
          </div>
          <div class="mb-3">
            <label for="monto" class="form-label">Monto del Abono</label>
            <input type="number" step="0.01" name="monto" id="monto" class="form-control" placeholder="Ingresa el monto" required>
          </div>
          <div class="mb-3">
            <label for="fecha" class="form-label">Fecha del Abono</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
          </div>
          <button type="submit" class="btn btn-success btn-minimal">Registrar Abono</button>
          <button type="button" class="btn btn-secondary btn-minimal" data-bs-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS y jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    var abonoModal = new bootstrap.Modal(document.getElementById('abonoModal'));
    
    // Al hacer clic en el botón "Registrar Abono" de la tabla, se carga la información en el modal
    $('.open-abono-modal').on('click', function(){
        var row = $(this).closest('tr');
        var id = row.data('id');
        var nombre = row.data('nombre');
        var total = parseFloat(row.data('total'));
        var pagado = parseFloat(row.data('pagado'));
        var due = parseFloat(row.data('due'));
        
        $('#serviceId').val(id);
        $('#clienteName').val(nombre);
        $('#totalPlan').val('$' + total.toFixed(2));
        $('#pagoActual').val('$' + pagado.toFixed(2));
        $('#deudaPendiente').val('$' + due.toFixed(2));
        $('#monto').val('');
        $('#fecha').val(new Date().toISOString().split('T')[0]);
        $('#modalAlert').removeClass('alert-danger alert-success').addClass('d-none').text('');
        
        abonoModal.show();
    });
    
    // Envío del formulario vía AJAX
    $('#abonoForm').on('submit', function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        $.post('abono.php', formData, function(response){
            if(response.success){
                $('#modalAlert').removeClass('d-none alert-danger').addClass('alert-success').text(response.message);
                setTimeout(function(){
                    abonoModal.hide();
                    location.reload(); // Actualiza la tabla
                }, 1500);
            } else {
                $('#modalAlert').removeClass('d-none alert-success').addClass('alert-danger').text(response.message);
            }
        }, 'json');
    });
});
</script>
</body>
</html>
