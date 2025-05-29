<?php
    include_once LAYOUTS . 'main_head.php';
    setHeader($d);
?>

<main class="main-content container my-4">
  <!-- Placeholder para alertas -->
  <div id="alert-placeholder" class="position-fixed top-0 end-0 p-3" style="z-index: 1100"></div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Reservas</h2>
    <button id="btnAgregarReserva" class="btn btn-success">
      <i class="mdi mdi-plus-circle-outline"></i> Añadir Reserva
    </button>
  </div>

  <div class="row mb-3">
    <div class="col-md-4">
      <label for="filtro-estado" class="form-label">Filtrar por estado:</label>
      <select id="filtro-estado" class="form-select">
        <option value="">Todos</option>
        <option value="Pendiente">Pendiente</option>
        <option value="Confirmada">Confirmada</option>
        <option value="Cancelada">Cancelada</option>
        <option value="Cumplida">Cumplida</option>
        <option value="No show">No show</option>
        <option value="En lista de espera">En lista de espera</option>
        <option value="Reprogramada">Reprogramada</option>
      </select>
    </div>
    <div class="col-md-4">
      <label for="filtro-fecha" class="form-label">Filtrar por fecha:</label>
      <input type="date" id="filtro-fecha" class="form-control">
    </div>
    <div class="col-md-4">
      <label for="filtro-usuario" class="form-label">Filtrar por usuario:</label>
      <input type="text" id="filtro-usuario" class="form-control" placeholder="Nombre de usuario">
    </div>
  </div>

  <div class="table-responsive">
    <table id="tabla-reservas" class="table table-hover table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>N° Reserva</th>
          <th>Usuario</th>
          <th>N° Mesa</th>
          <th>Fecha</th>
          <th>Personas</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Se llenará dinámicamente -->
      </tbody>
    </table>
  </div>
</main>

<!-- Modal Agregar Reserva -->
<div class="modal fade" id="modalAgregarReserva" tabindex="-1" aria-labelledby="modalAgregarReservaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formAgregarReserva" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarReservaLabel">Añadir Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="agregar-usuario" class="form-label">Usuario</label>
          <select class="form-select" id="agregar-usuario" name="usuario" required>
            <option value="">Cargando usuarios...</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="agregar-mesa" class="form-label">Mesa</label>
          <select class="form-select" id="agregar-mesa" name="mesa" required>
            <option value="">Cargando mesas...</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="agregar-fecha" class="form-label">Fecha y hora</label>
          <input type="datetime-local" class="form-control" id="agregar-fecha" name="fecha" required>
        </div>
        <div class="mb-3">
          <label for="agregar-personas" class="form-label">Cantidad de personas</label>
          <input type="number" class="form-control" id="agregar-personas" name="personas" min="1" max="10" required>
        </div>
        <div class="mb-3">
          <label for="agregar-estado" class="form-label">Estado</label>
          <select class="form-select" id="agregar-estado" name="estado" required>
            <option value="">Seleccione...</option>
            <option value="Pendiente">Pendiente</option>
            <option value="Confirmada">Confirmada</option>
            <option value="Cancelada">Cancelada</option>
            <option value="Cumplida">Cumplida</option>
            <option value="No show">No show</option>
            <option value="En lista de espera">En lista de espera</option>
            <option value="Reprogramada">Reprogramada</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Guardar Reserva</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Editar Reserva -->
<div class="modal fade" id="modalEditarReserva" tabindex="-1" aria-labelledby="modalEditarReservaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditarReserva" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarReservaLabel">Editar Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editar-id" name="id">
        <div class="mb-3">
          <label for="editar-usuario" class="form-label">Usuario</label>
          <select class="form-select" id="editar-usuario" name="usuario" required>
            <option value="">Cargando usuarios...</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="editar-mesa" class="form-label">Mesa</label>
          <select class="form-select" id="editar-mesa" name="mesa" required>
            <option value="">Cargando mesas...</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="editar-fecha" class="form-label">Fecha y hora</label>
          <input type="datetime-local" class="form-control" id="editar-fecha" name="fecha" required>
        </div>
        <div class="mb-3">
          <label for="editar-personas" class="form-label">Cantidad de personas</label>
          <input type="number" class="form-control" id="editar-personas" name="personas" min="1" max="10" required>
        </div>
        <div class="mb-3">
          <label for="editar-estado" class="form-label">Estado</label>
          <select class="form-select" id="editar-estado" name="estado" required>
            <option value="Pendiente">Pendiente</option>
            <option value="Confirmada">Confirmada</option>
            <option value="Cancelada">Cancelada</option>
            <option value="Cumplida">Cumplida</option>
            <option value="No show">No show</option>
            <option value="En lista de espera">En lista de espera</option>
            <option value="Reprogramada">Reprogramada</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Confirmar Eliminación -->
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que deseas eliminar esta reserva? Esta acción no se puede deshacer.</p>
        <input type="hidden" id="reserva-id-eliminar">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btn-confirmar-eliminar" class="btn btn-danger">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<?php
    include_once LAYOUTS . 'main_foot.php';
    setFooter($d);
?>