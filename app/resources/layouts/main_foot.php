<?php
function setFooter($args)
{
    $ua = as_object($args->ua);
?>
    </div> <!-- Cierre de main-content-wrapper -->
    
    <!-- JS Scripts -->
    <script src="<?= JS ?>jquery.js"></script>
    <script src="<?= JS ?>bootstrap.js"></script>
    <script src="<?= JS ?>sweetalert2.js"></script>
    <script src="<?= JS ?>app.js"></script>
    
    <script>
        // Función para el sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            
            // Guardar estado en localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
        
        // Inicialización
        $(function () {
            // Configuración del usuario
            if (typeof app !== 'undefined' && app.user) {
                app.user.sv = <?= $ua->sv ? 'true' : 'false' ?>;
                app.user.id = "<?= $ua->id ?? '' ?>";
                app.user.username = "<?= $ua->username ?? '' ?>";
                app.user.tipo = "<?= $ua->tipo ?? '' ?>";
            } else {
                console.error('El objeto app o app.user no está definido.');
            }
            
            // Evento para el botón del sidebar
            $('.toggle-btn').on('click', toggleSidebar);
            
            // Cargar estado inicial del sidebar
            if(localStorage.getItem('sidebarCollapsed') === 'true') {
                toggleSidebar();
            }
            
            // Evento para editar reserva (tu código existente)
            $(document).on("click", ".editar-reserva", function () {
                const id = $(this).data("id");
                const fecha = $(this).data("fecha");
                const personas = $(this).data("personas");
                const estado = $(this).data("estado");

                $("#editar-id").val(id);
                $("#editar-fecha").val(fecha.replace(" ", "T"));
                $("#editar-personas").val(personas);
                $("#editar-estado").val(estado);
            });
        });
    </script>
<?php
}

function closeFooter()
{
?>

<!-- Antes de cerrar el body (en main_foot.php o similar) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  // Configuración opcional de toastr
  toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
  };
</script>
</body>
</html>
<?php
}
?>