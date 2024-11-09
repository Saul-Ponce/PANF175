<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    if (!isset($_GET['usuario'])) {
        header('../index.php');
        session_destroy();
        die();
    }
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Cambiar Contraseña</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body class="d-flex flex-column">
    <script src="../public/assets/js/demo-theme.min.js?1692870487"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-0">
                <a href="." class="navbar-brand navbar-brand-autodark">
                    <img src="../public/assets/img/logo.svg" height="150">
                </a>
            </div>
            <form class="card card-md" method="POST" id="formulario_cambio" autocomplete="off" novalidate>
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Cambiar contraseña</h2>
                    <input type="hidden" name="usuario"
                        value="<?= isset($_SESSION['usuario']) ? $_SESSION["usuario"] : $_GET['usuario'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña</label>
                        <div class="input-group input-group-flat mb-3">
                            <input type="password" class="form-control" placeholder="contrasena" id="contrasena"
                                name="contrasena" autocomplete="off">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" id="togglePassword">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                        <label class="form-label">Repetir nueva contraseña</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" placeholder="contraseña" id="repetir-contrasena"
                                name="repetir-contrasena" autocomplete="off">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" id="togglePassword2">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Cambiar contraseña</button>
                    </div>
                </div>
            </form>
        </div>
        <?php include '../layouts/footerScript.php'; ?>
        <script>
            let ver_contra = (input, button) => {
                // Seleccionar el campo de contraseña y el botón
                const passwordInput = document.getElementById(input);
                const togglePasswordButton = document.getElementById(button);

                // Agregar un evento de clic al botón
                togglePasswordButton.addEventListener('click', () => {
                    // Verificar el tipo actual del campo de contraseña
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text'; // Cambia a texto para mostrar la contraseña
                        togglePasswordButton.innerHTML =
                            '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>';
                    } else {
                        passwordInput.type = 'password'; // Cambia a contraseña para ocultarla
                        togglePasswordButton.innerHTML =
                            '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>';

                    }
                });
            }

            ver_contra('contrasena', 'togglePassword');
            ver_contra('repetir-contrasena', 'togglePassword2');

            $(document).on("submit", "#formulario_cambio", function (event) {
                event.preventDefault();
                const contrasena = document.getElementById('contrasena').value;
                const contrasena2 = document.getElementById('repetir-contrasena').value;
                if (contrasena === contrasena2) {
                    var datos = $("#formulario_cambio").serialize();
                    console.log("evento submit", datos);
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        url: "../includes/cambiar_pass.php",
                        data: datos,
                    }).done(function (json) {
                        console.log("el login: ", json);
                        if (json.exito) {
                            Swal.fire({
                                icon: "success",
                                title: 'contraseña cambiada',
                                text: json.exito,
                            });
                            let timer = setInterval(function () {
                                $(location).attr("href", "../index.php");
                                clearTimeout(timer);
                            }, 3500);

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: json[1],
                                text: json.error,
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'Error de contraseña',
                        text: 'las contraseñas no coinciden',
                    });
                }


            });
        </script>
</body>

</html>