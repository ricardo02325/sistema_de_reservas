<?php
function setHeader($args){
    $ua = as_object($args->ua);
?>
<!DOCTYPE html>
<html lang="es">
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=CSS?>bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=CSS?>styles.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title><?=$args->title?></title>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <header class="sidebar-header px-2">
            <button class="toggle-btn" type="button" aria-label="Menú">
                <i class="mdi mdi-menu"></i>
            </button>
            <h4 class="mb-0">Sistema de Reservas</h4>
        </header>
        <nav>
            <a href="#" class="active"><i class="mdi mdi-calendar-check"></i><span>Reservaciones</span></a>
            <a href="#"><i class="mdi mdi-table-picnic"></i><span>Mesa</span></a>
            <a href="#" class="logout"><i class="mdi mdi-exit-to-app"></i><span>Salir</span></a>
        </nav>
    </aside>
    
    <!-- Contenedor principal -->
    <div class="main-content-wrapper">
<?php
}