<?php include 'layouts/header.php';?>
<?php include 'layouts/headerStyles.php';?>


<body class=" d-flex flex-column bg-white">
    <script src="public/assets/js/demo-theme.min.js?1692870487"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
            <div class="container container-tight my-5 px-lg-5">
                <div class="text-center mb-4">
                    <a href="." class="navbar-brand navbar-brand-autodark"><img src="public/assets/img/logo.svg"
                            height="200" alt=""></a>
                </div>
                <h2 class="h3 text-center mb-3">
                    Iniciar Sesion
                </h2>
                <!-- method="POST" action="includes/login_usuario.php" -->
                <form id="formulario_login">
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" placeholder="usuario"
                            autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Contraseña
                            <span class="form-label-description">
                                <a href="./forgot-password.html">He olvidado mi contraseña</a>
                            </span>
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="contrasena" id="contrasena" class="form-control"
                                placeholder="Tu contraseña" autocomplete="off">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
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
                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesion</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <!-- Photo -->
            <div class="bg-cover h-100 min-vh-100" style="background-image: url(public/assets/img/bg.jpg)">
            </div>
        </div>
    </div>
    <?php include 'layouts/footerScript.php';?>
    <script>
    $(document).on("submit", "#formulario_login", function(event) {
        event.preventDefault();
        var datos = $("#formulario_login").serialize();
        console.log("evento submit", datos);
        $.ajax({
            dataType: "json",
            method: "POST",
            url: "includes/login_usuario.php",
            data: datos,
        }).done(function(json) {
            console.log("el login: ", json);
            if (json.exito) {
                /* Swal.fire({
                    icon: "success",
                    title: "Bienvendio",
                    text: json.exito,
                });
                var timer = setInterval(function() {
                    $(location).attr("href", "/vistas/home.php");
                    clearTimeout(timer);
                }, 3500); */
                $(location).attr("href", "/vistas/home.php");
            } else if (json[0] == "Bloqueo") {
                Swal.fire({
                    icon: "error",
                    title: "Usuario bloqueado",
                });
                var timer = setInterval(function() {
                    $(location).attr("href", "../home/index.php?modulo=Home");
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