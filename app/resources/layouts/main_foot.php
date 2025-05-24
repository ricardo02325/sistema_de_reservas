<?php
function setFooter($args)
{
    $ua = as_object($args->ua);
    ?>
    <!-- JS Scripts -->
    <script src="<?= JS ?>jquery.js"></script>
    <script src="<?= JS ?>bootstrap.js"></script>
    <script src="<?= JS ?>sweetalert2.js"></script>
    <script src="<?= JS ?>app.js"></script>
    <script src="<?= JS ?>sidebar.js"></script>

    <script>
        $(function () {
            if (typeof app !== 'undefined' && app.user) {
                app.user.sv = <?= $ua->sv ? 'true' : 'false' ?>;
                app.user.id = "<?= $ua->id ?? '' ?>";
                app.user.username = "<?= $ua->username ?? '' ?>";
                app.user.tipo = "<?= $ua->tipo ?? '' ?>";
            } else {
                console.error('El objeto app o app.user no está definido.');
            }
        });

        $(document).on("click", ".editar-reserva", function () {
            const id = $(this).data("id");
            const fecha = $(this).data("fecha");
            const personas = $(this).data("personas");
            const estado = $(this).data("estado");

            $("#editar-id").val(id);
            $("#editar-fecha").val(fecha.replace(" ", "T")); // HTML datetime-local necesita "T"
            $("#editar-personas").val(personas);
            $("#editar-estado").val(estado);
        });

    </script>
    <?php
}

function closeFooter()
{
    ?>
    </body>

    </html>
    <?php
}
?>