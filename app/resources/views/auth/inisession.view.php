<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h5 class="mb-0">Inicio de sesión</h5>
                </div>
                <div class="card-body">
                    <form action="" id="login-form">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Nombre de usuario</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input type="text" class="form-control"
                                    id="username"
                                    name="username"
                                    placeholder="Nombre de usuario"
                                    required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="passwd" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" class="form-control"
                                    id="passwd"
                                    name="passwd"
                                    placeholder="Contraseña"
                                    required>
                            </div>
                        </div>
                        <div class="form-text text-danger d-none mb-3" id="error">
                            Sus datos de inicio de sesión son incorrectos.
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">
                                Iniciar sesión <i class="bi bi-box-arrow-in-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="/Register" class="btn btn-link">¿No tienes una cuenta? Registrarse</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

    include_once LAYOUTS . 'main_foot.php';
    setFooter($d);
?>

    <script>
        $( function(){
            const $lf = $('#login-form');
            $lf.on("submit", function(e){
                e.preventDefault();
                e.stopPropagation();
                const data = new FormData(this)
                fetch(app.routes.login, {
                    method : 'POST',
                    body : data,
                }).then(res => res.json())
                .then(res => {
                    if(res.r !== false){
                        location.href = "/"
                    }else{
                        $("#error").removeClass("d-none")
                    }
                }).catch(err => {
                    console.log(err)
                })
            })
        })
    </script>

<?php 
    closeFooter();