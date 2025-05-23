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

<!-- Modal para editar reserva -->
<div class="modal fade" id="modalEditarReserva" tabindex="-1" aria-labelledby="modalEditarReservaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarReservaLabel">Editar Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      
      <div class="modal-body">
        <form id="formEditarReserva">
          <input type="hidden" id="reservaId">

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="usuarioId" class="form-label">Usuario</label>
              <select id="usuarioId" class="form-select" required></select>
            </div>
            <div class="col-md-6">
              <label for="mesaId" class="form-label">Mesa</label>
              <select id="mesaId" class="form-select" required></select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="fechaHoraReserva" class="form-label">Fecha y Hora</label>
              <input type="datetime-local" id="fechaHoraReserva" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="cantidadPersonas" class="form-label">Cantidad de Personas</label>
              <input type="number" id="cantidadPersonas" class="form-control" min="1" max="10" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="estadoReserva" class="form-label">Estado</label>
            <select id="estadoReserva" class="form-select" required>
              <option value="Pendiente">Pendiente</option>
              <option value="Confirmada">Confirmada</option>
              <option value="Cancelada">Cancelada</option>
              <option value="Cumplida">Cumplida</option>
              <option value="No show">No show</option>
              <option value="En lista de espera">En lista de espera</option>
              <option value="Reprogramada">Reprogramada</option>
            </select>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="mdi mdi-close"></i> Cancelar
        </button>
        <button type="submit" form="formEditarReserva" class="btn btn-primary">
          <i class="mdi mdi-content-save"></i> Guardar Cambios
        </button>
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