<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);
?>

<!-- Para tabla de reservas -->
<main class="main-content">
    <section class="table-container">
        <table id="tabla-reservas" class="table table-hover table-bordered text-center align-middle">
        <thead class="table-dark">
        </thead>
        <!-- Reservaciones del restaurante -->

      </table>
    </section>
</main>

<!-- Modal Editar Reserva -->
<div class="modal fade" id="modalEditarReserva" tabindex="-1" aria-labelledby="modalEditarReservaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarReservaLabel">Editar Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarReserva">
          <!-- ID oculto -->
          <input type="hidden" id="editar-id" name="id">

          <div class="mb-3">
            <label for="editar-fecha" class="form-label">Fecha</label>
            <input type="datetime-local" class="form-control" id="editar-fecha" name="fecha">
          </div>

          <div class="mb-3">
            <label for="editar-personas" class="form-label">Cantidad de personas</label>
            <input type="number" class="form-control" id="editar-personas" name="personas" min="1">
          </div>

          <div class="mb-3">
            <label for="editar-estado" class="form-label">Estado</label>
            <select class="form-select" id="editar-estado" name="estado">
              <option value="Pendiente">Pendiente</option>
              <option value="Confirmada">Confirmada</option>
              <option value="Cancelada">Cancelada</option>
              <option value="Cumplida">Cumplida</option>
              <option value="No show">No show</option>
              <option value="En lista de espera">En lista de espera</option>
              <option value="Reprogramada">Reprogramada</option>
            </select>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php

    include_once LAYOUTS . 'main_foot.php';
    setFooter($d);
?>

<?php 
    closeFooter();