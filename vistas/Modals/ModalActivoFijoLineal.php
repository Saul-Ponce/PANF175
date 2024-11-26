<?php
// Depuración 
if (isset($_GET['id'])) {
    $idActivo = $_GET['id'];
    // Conectar a la base de datos
    $con = connection();

    // Consulta para obtener los datos del activo
    $sql = "SELECT a.estadoActivo, a.valor_adquisicion, a.fecha_adquisicion, a.vida_util, a.fecha_registro
            FROM activo_fijo a 
            WHERE a.id_activo = $idActivo";

    // Ejecutar la consulta
    $query = mysqli_query($con, $sql);
    $datosActivo = mysqli_fetch_assoc($query);

    // Verificar si se obtuvieron resultados
    if ($datosActivo) {
        // Verificar el estado del activo
        if ($datosActivo['estadoActivo'] == 2) {
            $fechaAdquisicion = new DateTime($datosActivo['fecha_adquisicion']);
            $fechaRegistro = new DateTime($datosActivo['fecha_registro']);  // Fecha en que se registró el activo
            $interval = $fechaAdquisicion->diff($fechaRegistro);  // Usamos la diferencia entre fecha de adquisición y fecha de registro
            $anios = $interval->y;

            if ($anios < 1) {
                $valorAjustado = $datosActivo['valor_adquisicion'];
            } elseif ($anios == 1) {
                $valorAjustado = $datosActivo['valor_adquisicion'] * 0.80;
            } elseif ($anios == 2) {
                $valorAjustado = $datosActivo['valor_adquisicion'] * 0.60;
            } elseif ($anios == 3) {
                $valorAjustado = $datosActivo['valor_adquisicion'] * 0.40;
            } else {
                $valorAjustado = $datosActivo['valor_adquisicion'] * 0.20;
            }
        } else {
            // Si el estado no es usado, el valor ajustado es el valor de adquisición
            $valorAjustado = $datosActivo['valor_adquisicion'];
        }

        // Calcular la depreciación lineal anual
        $vidaUtil = $datosActivo['vida_util']; // Vida útil en años
        $valorDepreciable = $valorAjustado; // Si no hay valor de rescate, el valor depreciable es el valor ajustado
        $depreciacionAnual = $valorDepreciable / $vidaUtil; // Depreciación lineal

        // Inicializar los valores para el cálculo de la depreciación
        $valorEnLibros = $valorAjustado;
        $fechaRegistroDepreciacion = new DateTime($datosActivo['fecha_registro']);  // Usar la fecha de registro como fecha inicial
        $resultado = [];

        // Calcular la depreciación hasta que se alcance la vida útil
        for ($i = 1; $i <= $vidaUtil; $i++) {
            // Restar la depreciación anual del valor en libros
            $valorFinal = $valorEnLibros - $depreciacionAnual;

            // Asegurar que no se baje de cero el valor en libros
            if ($valorFinal < 0) {
                $valorFinal = 0;
            }

            // Sumar un año a la fecha de registro
            $fechaRegistroDepreciacion->modify('+1 year');

            $resultado[] = [
                'fecha' => $fechaRegistroDepreciacion->format('Y-m-d'), // Fecha futura, sumando los años a la fecha de registro
                'valorInicio' => number_format($valorEnLibros, 2),
                'depreciacionAnual' => number_format($depreciacionAnual, 2),
                'valorFinal' => number_format($valorFinal, 2),
            ];

            // Actualizar el valor en libros para el siguiente ciclo
            $valorEnLibros = $valorFinal;
        }
    } else {
        $resultado = [];
    }
} else {
    echo "no trae el id ";
}
?>

<div class="modal modal-blur fade" id="mdActivofijoLineal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-block w-100" id="titulo">Depreciacion lineal</h5>
            </div> <!-- Mover el texto adicional aquí -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            <div class="modal-header">
                <p class="mt-1"> Valor original: $<?= number_format($datosActivo['valor_adquisicion'], 2); ?>
                    <br> Estado: <?= $datosActivo['estadoActivo'] == 2 ? 'usado' : 'nuevo'; ?>
                    <br> Vida util <?= $vidaUtil ?>
                </p>
            </div>
            <div class=" modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Valor Inicio</th>
                            <th>Depreciación Anual</th>
                            <th>Valor Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado as $fila): ?>
                            <tr>
                                <td><?= $fila['fecha'] ?></td>
                                <td><?= $fila['valorInicio'] ?></td>
                                <td><?= $fila['depreciacionAnual'] ?></td>
                                <td><?= $fila['valorFinal'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!-- Mostrar el valor original aquí -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>