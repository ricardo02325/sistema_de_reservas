<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);
?>

<!-- Para tabla de reservas -->
<main class="main-content">
    <section class="table-container">
        <table class="table table-hover table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Estado</th>
          </tr>
        </thead>
        <!-- Reservaciones del restaurante -->
        <tbody>
          <tr>
            <td>1</td>
            <td>Juan Pérez</td>
            <td>2025-05-20</td>
            <td><span class="badge bg-success">Confirmado</span></td>
          </tr>
          <tr>
            <td>2</td>
            <td>María López</td>
            <td>2025-05-22</td>
            <td><span class="badge bg-warning text-dark">Pendiente</span></td>
          </tr>
          <tr>
            <td>3</td>
            <td>Carlos Ruiz</td>
            <td>2025-05-25</td>
            <td><span class="badge bg-danger">Cancelado</span></td>
          </tr>
        </tbody>
      </table>
    </section>

<?php

    include_once LAYOUTS . 'main_foot.php';
    setFooter($d);
?>

<?php 
    closeFooter();