<?php $pageName = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
$row = $_SESSION['usuario'];
?>



<div class="wrapper">

    <div class="sidebar" data-image="../assets/img/sidebar-8.jpg" data-color="blue">
        <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
     -->
        <div class="sidebar-wrapper">
            <div class="logo" style="background-color:white">
                <img src="../assets/img/Logo Punto Digital-01.png" class="ml-4" width="175" height="125">



            </div>
            <ul class="nav">


                <ul class="nav flex-column">
                    <!-- Empleados  -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#header1">Empleados
                            <i class="fas fa-caret-right toggle-icon"></i></a>
                        <div class="collapse" id="header1">
                            <ul class="nav flex-column pl-3">
                                <li class="<?=$pageName == 'lista-persona.php' ? 'nav-item active' : '';?> ">
                                    <a class="nav-link" href="../vistas/lista-persona.php"><i
                                            class="fa-solid fa-users-rectangle"></i>
                                        <p>Lista de empleados</p>
                                    </a>
                                </li>
                                <li class=" <?=$pageName == 'persona.php' ? 'nav-item active' : '';?>">
                                    <a class="nav-link" href="../vistas/persona.php"><i
                                            class="fa-solid fa-user-plus"></i>
                                        <p>Agregar empleado</p>
                                    </a>
                                </li>
                                <li class="<?=$pageName == 'lista-rol.php' ? 'nav-item active' : '';?>">
                                    <a class="nav-link" href="../vistas/lista-rol.php">
                                        <i class="fa-solid fa-user-tie"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>


                            </ul>
                    </li>
                </ul>

                <!--Clientes      -->

                <ul class="nav">


                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#header2">Clientes
                                <i class="fas fa-caret-right toggle-icon"></i></a>
                            <div class="collapse" id="header2">
                                <ul class="nav flex-column pl-3">
                                    <li class=" <?=$pageName == 'lista-cliente.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/lista-cliente.php">
                                            <i class="fa-solid fa-handshake"></i>
                                            <p>Lista de clientes</p>
                                        </a>
                                    </li>
                                    <li class="<?=$pageName == 'cliente.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/cliente.php">
                                            <i class="fa-solid fa-user-plus"></i>
                                            <p>Agregar cliente</p>
                                        </a>
                                    </li>




                                </ul>
                        </li>
                    </ul>
                    <!--Productos      -->




                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#header3">Productos
                                <i class="fas fa-caret-right toggle-icon"></i></a>
                            <div class="collapse" id="header3">
                                <ul class="nav flex-column pl-3">
                                    <li class=" <?=$pageName == 'producto.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/producto.php">
                                            <i class="fa-solid fa-box-open"></i>
                                            <p>Agregar producto</p>
                                        </a>
                                    </li>
                                    <li class=" <?=$pageName == 'lista-producto.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/lista-producto.php">
                                            <i class="fa-solid fa-list"></i>
                                            <p>Lista de Productos</p>
                                        </a>
                                    </li>
                                    <li class=" <?=$pageName == 'lista-proveedor.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/lista-proveedor.php">
                                            <i class="fa-solid fa-list"></i>
                                            <p>Lista de proveedores</p>
                                        </a>
                                    </li>
                                    <li class=" <?=$pageName == 'lista-categoria.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/lista-categoria.php">
                                            <i class="fa-solid fa-list"></i>
                                            <p>Lista de categorias</p>
                                        </a>
                                    </li>




                                </ul>
                        </li>
                    </ul>


                    <!--Compras      -->




                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#header4">Compras
                                <i class="fas fa-caret-right toggle-icon"></i></a>
                            <div class="collapse" id="header4">
                                <ul class="nav flex-column pl-3">
                                    <li class=" <?=$pageName == 'genera-compra.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/genera-compra.php">
                                            <i class="fa-solid fa-handshake"></i>
                                            <p>Agregar Compras</p>
                                        </a>
                                    </li>
                                    <li class=" <?=$pageName == 'lista-compra.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/lista-compra.php">
                                            <i class="fa-solid fa-list"></i>
                                            <p>Lista de Compras</p>
                                        </a>
                                    </li>




                                </ul>
                        </li>
                    </ul>


                    <!--Ventas      -->




                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#header5">Ventas
                                <i class="fas fa-caret-right toggle-icon"></i></a>
                            <div class="collapse" id="header5">
                                <ul class="nav flex-column pl-3">
                                    <li class=" <?=$pageName == 'genera-venta.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/genera-venta.php">
                                            <i class="fa-regular fa-money-bill-1"></i>
                                            <p>Agregar ventas</p>
                                        </a>
                                    </li>
                                    <li class=" <?=$pageName == 'lista-venta.php' ? 'nav-item active' : '';?>">
                                        <a class="nav-link" href="../vistas/lista-venta.php">
                                            <i class="fa-solid fa-list"></i>
                                            <p>Lista de ventas</p>
                                        </a>
                                    </li>




                                </ul>
                        </li>
                    </ul>




                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="../includes/ayuda.pdf" target="_blank"><i
                                    class="fa fa-question-circle" aria-hidden="true"></i>
                                <p>Ayuda</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="../vistas/vistabackup.php"><i class="fa-solid fa-database"></i>
                                <p>Backup</p>
                            </a>
                        </li>
                    </ul>



                    <ul class="nav flex-column">
                        <!-- ... otros elementos de la barra lateral ... -->

                        <li class="nav-item" style="margin-top: auto; margin-bottom: 40px;">
                            <a class="nav-link" href="../includes/cerrar_sesion.php">
                                <i class="fa-solid fa-power-off"></i>
                                <p>Cerrar sesión</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-top: auto; margin-bottom: 0;">
                            <div class="logo"><a href="../vistas/perfil.php">Usuario: <?php echo $row; ?></a></div>
                        </li>
                    </ul>




        </div>

    </div>
    <script>
    // Add an event listener for Bootstrap's collapse events
    $('.nav-link[data-toggle="collapse"]').on('click', function() {
        var icon = $(this).find('.toggle-icon');
        if ($(this).hasClass('collapsed')) {
            icon.removeClass('rotate-icon');
        } else {
            icon.addClass('rotate-icon');
        }
    });
    </script>

    <script>
    // Listen to Bootstrap Collapse events
    $('.collapse').on('hide.bs.collapse', function() {
        var icon = $(this).prev().find('.toggle-icon');
        setTimeout(function() {
            icon.removeClass('rotate-icon');
        }, 10); // Add a minimal delay
    }).on('show.bs.collapse', function() {
        var icon = $(this).prev().find('.toggle-icon');
        icon.addClass('rotate-icon');
    });
    </script>

    <script>
    // JavaScript to initially collapse the element
    $(document).ready(function() {
        // Select the element and trigger the collapse action
        $('#header1').collapse('hide');
    });
    </script>

    <script>
    $(document).ready(function() {
        // Check if "Empleados" section was previously expanded
        var isEmpleadosExpanded = localStorage.getItem('empleadosExpanded') === 'true';

        if (isEmpleadosExpanded) {
            $('#header1').collapse('show');
            $('.toggle-icon').addClass('rotate-icon');
        }

        // Add an event listener for Bootstrap's collapse events
        $('.nav-link[data-toggle="collapse"]').on('click', function() {
            var icon = $(this).find('.toggle-icon');
            if ($(this).hasClass('collapsed')) {
                icon.removeClass('rotate-icon');
            } else {
                icon.addClass('rotate-icon');
            }
        });

        // Save the state of "Empleados" when it is collapsed/expanded
        $('#header1').on('hide.bs.collapse', function() {
            localStorage.setItem('empleadosExpanded', 'false');
        }).on('show.bs.collapse', function() {
            localStorage.setItem('empleadosExpanded', 'true');
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        // Check if "Empleados" section was previously expanded
        var isEmpleadosExpanded = localStorage.getItem('clientesExpanded') === 'true';

        if (isEmpleadosExpanded) {
            $('#header2').collapse('show');
            $('.toggle-icon').addClass('rotate-icon');
        }

        // Add an event listener for Bootstrap's collapse events
        $('.nav-link[data-toggle="collapse"]').on('click', function() {
            var icon = $(this).find('.toggle-icon');
            if ($(this).hasClass('collapsed')) {
                icon.removeClass('rotate-icon');
            } else {
                icon.addClass('rotate-icon');
            }
        });

        // Save the state of "Empleados" when it is collapsed/expanded
        $('#header2').on('hide.bs.collapse', function() {
            localStorage.setItem('clientesExpanded', 'false');
        }).on('show.bs.collapse', function() {
            localStorage.setItem('clientesExpanded', 'true');
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        // Listen for a click event on the header links
        $('.nav-link[data-toggle="collapse"]').on('click', function() {
            var targetCollapse = $($(this).data('target'));

            // Collapse other open headers
            $('.collapse.show').not(targetCollapse).collapse('hide');
        });
    });
    </script>