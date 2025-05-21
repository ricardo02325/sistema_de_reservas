<?php
function setFooter($args){
    $ua = as_object($args->ua);
?>
    <script src="<?=JS?>jquery.js"></script>
    <script src="<?=JS?>bootstrap.js"></script>
    <script src="<?=JS?>sweetalert2.js"></script>
    <script src="<?=JS?>app.js"></script>
    <script src="<?=JS?>sidebar.js"></script>

    <script>
        $(function(){
            if (typeof app !== 'undefined' && app.user) {
                app.user.sv = <?= $ua->sv ? 'true' : 'false' ?>;
                app.user.id = "<?= $ua->id ?? '' ?>";
                app.user.username = "<?= $ua->username ?? '' ?>";
                app.user.tipo = "<?= $ua->tipo ?? '' ?>";
            } else {
                console.error('El objeto app o app.user no está definido.');
            }
        });
    </script>
<?php 
} 

function closeFooter() { ?>
    </body>
    </html> 
<?php 
}
?>