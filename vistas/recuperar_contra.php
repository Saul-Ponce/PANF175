<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Recuperar Contraseña</title>
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
            <form class="card card-md" method="POST" id="formulario_recuperacion" autocomplete="off" novalidate>
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Recuperar contraseña</h2>
                    <p class="text-secondary mb-4">Ingresa tu correo electronico para poder cambiar tu contraseña</p>
                    <div class="mb-3">
                        <label class="form-label">Correo electronico</label>
                        <input type="email" id="correo_recuperacion" name="correo_recuperacion" class="form-control"
                            placeholder="su correo">
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100"> <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>Recuperar contraseña</button>
                    </div>
                </div>
            </form>
        </div>
        <?php include '../layouts/footerScript.php'; ?>
        <script>
            $(document).on("submit", "#formulario_recuperacion", function (event) {
                event.preventDefault();
                var datos = $("#formulario_recuperacion").serialize();
                console.log("evento submit", datos);
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Por favor espera mientras procesamos tu solicitud',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    dataType: "json",
                    method: "POST",
                    url: "../includes/recuperar_pass.php",
                    data: datos,
                }).done(function (json) {
                    if (json.exito) {
                        Swal.fire({
                            icon: "success",
                            title: 'correo enviado',
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


            });
        </script>
</body>

</html>