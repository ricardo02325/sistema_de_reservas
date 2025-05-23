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

<?php

    include_once LAYOUTS . 'main_foot.php';
    setFooter($d);
?>

<?php 
    closeFooter();