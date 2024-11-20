<?php
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        window.location = "../index.php"
    </script>
    ';
    session_destroy();
    die();
}

?>
<script src="../../public/assets/js/demo-theme.min.js?1692870487"></script>
<!-- Navbar -->
<header class="navbar navbar-expand-md navbar-overlap d-print-none" data-bs-theme="dark">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
                <img src="../../public/assets/img/logo-white.svg" width="200" height="100" alt="Punto digital"
                    class="navbar-brand-image" style="height: 4rem;">
            </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(../public/assets/img/user.jpg)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div><?= $_SESSION['nombre'] ?></div>
                        <div class="mt-1 small text-secondary"></div>
                        <div class="mt-1 small text-secondary"><?= $_SESSION['usuario'] ?> | <?= $_SESSION['rol'] ?>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" data-bs-theme="light">
                    <a href="./profile.html" class="dropdown-item">Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a href="../includes/cerrar_sesion.php" class="dropdown-item">Salir</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../vistas/home.php">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Inicio
                            </span>
                        </a>
                    </li>
                    <?php if ($_SESSION['rol'] == 'Administrador'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Usuarios
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="../vistas/registrar_usuario.php">
                                            Crear de usuario
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-usuario.php">
                                            Gestion de usuarios
                                        </a>
                                        <a class="dropdown-item" href="../vistas/registrar_rol.php">
                                            Crear rol
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-rol.php">
                                            Gestion de Roles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if ($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Vendedor'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                        <path d="M12 12l8 -4.5" />
                                        <path d="M12 12l0 9" />
                                        <path d="M12 12l-8 -4.5" />
                                        <path d="M16 5.25l-8 4.5" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Inventario
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="./alerts.html">
                                            Gestion de inventario
                                        </a>
                                        <a class="dropdown-item" href="./accordion.html">
                                            Movimientos
                                        </a>
                                        <a class="dropdown-item" href="../vistas/registrar_proveedor.php">
                                            Registrar Proveedores
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-proveedor.php">
                                            Gestionar Proveedores
                                        </a>
                                        <a class="dropdown-item" href="../vistas/registrar_producto.php">
                                            Registrar Productos
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-producto.php">
                                            Gestionar Productos
                                        </a>
                                        <a class="dropdown-item" href="../vistas/registrar_categoria.php">
                                            Registrar Categoria de productos
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-categoria.php">
                                            Gestionar Categoria de productos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Clientes
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="../vistas/registrar_cliente_natural.php">
                                            Agregar Clientes Naturales
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-clientesnaturales.php">
                                            Lista de Clientes Naturales
                                        </a>
                                        <a class="dropdown-item" href="../vistas/clientesjuridicos.php">
                                            Agregar Clientes Juridico
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-clientesjuridicos.php">
                                            Lista de Clientes Juridicos
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-clasificacion.php">
                                            Clasificacion de clientes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-home-dollar">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M19 10l-7 -7l-9 9h2v7a2 2 0 0 0 2 2h6" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2c.387 0 .748 .11 1.054 .3" />
                                        <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                        <path d="M19 21v1m0 -8v1" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Activos
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="../vistas/lista-catalogoActivoFijo.php">
                                            Catalogo de activo fijo
                                        </a>
                                        <a class="dropdown-item" href="../vistas/lista-activoFijo.php">
                                            Activo fijo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-shopee">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 7l.867 12.143a2 2 0 0 0 2 1.857h10.276a2 2 0 0 0 2 -1.857l.867 -12.143h-16z" />
                                        <path d="M8.5 7c0 -1.653 1.5 -4 3.5 -4s3.5 2.347 3.5 4" />
                                        <path
                                            d="M9.5 17c.413 .462 1 1 2.5 1s2.5 -.897 2.5 -2s-1 -1.5 -2.5 -2s-2 -1.47 -2 -2c0 -1.104 1 -2 2 -2s1.5 0 2.5 1" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Ventas
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-ventas-a-credito"
                                                data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                                aria-expanded="false">
                                                Ventas a credito
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="./sign-in.html" class="dropdown-item">
                                                    Registrar Venta a credito
                                                </a>
                                                <a href="./sign-in.html" class="dropdown-item">
                                                    lista de Ventas a credito
                                                </a>
                                            </div>
                                        </div>
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-ventas-al-contado"
                                                data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                                aria-expanded="false">
                                                Ventas al contado
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="../vistas/genera-venta-contado.php" class="dropdown-item">
                                                    Registrar Venta al contado
                                                </a>
                                                <a href="./sign-in.html" class="dropdown-item">
                                                    lista de Ventas al contado
                                                </a>
                                            </div>
                                        </div>
                                        <a class="dropdown-item" href="./alerts.html">
                                            Facturacion
                                        </a>
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-cuentas-por-cobrar"
                                                data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                                aria-expanded="false">
                                                Cuentas por cobrar
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="./sign-in.html" class="dropdown-item">
                                                    Gestion de cuentas por cobrar
                                                </a>
                                                <a href="./sign-in-link.html" class="dropdown-item">
                                                    Intereses
                                                </a>
                                                <a href="./sign-in-illustration.html" class="dropdown-item">
                                                    Embargo
                                                </a>
                                                <a href="./sign-in-cover.html" class="dropdown-item">
                                                    Historial de pago
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>
</header>