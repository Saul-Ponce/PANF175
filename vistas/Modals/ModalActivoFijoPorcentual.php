<?php
// Depuración 
if (isset($_GET['id'])) {
    $idActivo = $_GET['id'];
    // Conectar a la base de datos
    $con = connection();

    // Consulta para obtener los datos del activo
    $sql = "SELECT a.estadoActivo, a.valor_adquisicion, a.fecha_adquisicion, a.fecha_registro, c.porcentajeDepreciacion 
            FROM activo_fijo a 
            INNER JOIN Catalogo_Tipos_Activos c ON c.idTipoActivo = a.idTipoActivo
            WHERE a.id_activo = $idActivo";

    // Ejecutar la consulta
    $query = mysqli_query($con, $sql);
    $datosActivo = mysqli_fetch_assoc($query);

    // Verificar si se obtuvieron resultados
    if ($datosActivo) {
        // Verificar el estado del activo
        if ($datosActivo['estadoActivo'] == 2) {
            // Usar la fecha de registro para calcular la depreciación
            $fechaRegistro = new DateTime($datosActivo['fecha_registro']);
            $fechaAdquisicion = new DateTime($datosActivo['fecha_adquisicion']);
            $interval = $fechaAdquisicion->diff($fechaRegistro); // Usamos la fecha de registro para el cálculo
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

        // Calcular la depreciación usando el valor ajustado y el porcentaje de depreciación
        $porcentajeDepreciacion = $datosActivo['porcentajeDepreciacion'] / 100;
        $valorEnLibros = $valorAjustado;
        $resultado = [];

        // Inicializar correctamente la fecha para la depreciación (usamos la fecha de registro)
        $fechaActualDepreciacion = new DateTime($datosActivo['fecha_registro']);  // Fecha de registro como punto de inicio

        // Calcular la depreciación hasta que la depreciación anual sea cero
        while (true) {
            $depreciacionAnual = $valorEnLibros * $porcentajeDepreciacion;

            // Detener el ciclo si la depreciación anual es cero o casi cero
            if ($depreciacionAnual < 0.01) {
                break;
            }

            $valorFinal = $valorEnLibros - $depreciacionAnual;

            // Sumar un año a la fecha inicial
            $fechaActualDepreciacion->modify('+1 year');

            $resultado[] = [
                'fecha' => $fechaActualDepreciacion->format('Y-m-d'), // Fecha futura calculada desde la fecha de registro
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






<div class="modal modal-blur fade" id="mdActivofijoPorcentual" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-block w-100" id="titulo">Depreciacion porcentual</h5>
            </div> <!-- Mover el texto adicional aquí -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            <div class="modal-header">
                <p class="mt-1"> Valor original: $<?= number_format($datosActivo['valor_adquisicion'], 2); ?>
                    <br> Estado: <?= $datosActivo['estadoActivo'] == 2 ? 'usado' : 'nuevo'; ?>
                    <br> porcentaje: <?= $porcentajeDepreciacion ?>
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