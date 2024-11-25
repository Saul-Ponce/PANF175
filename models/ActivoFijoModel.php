<?php
require_once "conexion.php";
include "../models/UsuarioModel.php";

class ActivoFijoModel
{

    public static function listar()
    {
        $con = connection();
        $sql = "SELECT a.id_activo,a.codigo,a.nombre,c.idTipoActivo,c.nombreActivo,a.estadoActivo,
        a.fecha_adquisicion,a.valor_adquisicion,a.vida_util,a.codigoUnidad,a.estado
                from activo_fijo a 
                INNER JOIN Catalogo_Tipos_Activos c on c.idTipoActivo=a.idTipoActivo";
        $query = mysqli_query($con, $sql);
        return $query;
    }

    public static function agregar(
        $codigoUnidad,
        $nombre,
        $idTipoActivo,
        $fechaAdquisicion,
        $valorAdquisicion,
        $vidaUtil,
        $estadoActivo,
        $idUsuario
    ) {
        // Obtener el último id_activo
        $con = connection();
        $query = "SELECT MAX(id_activo) AS ultimo_id FROM activo_fijo";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        // Obtener el último id y sumarle 1
        $ultimoId = $row['ultimo_id'] ? $row['ultimo_id'] : 0;  // Si no existe, comenzamos desde 0
        $nuevoId = $ultimoId + 1;

        // Generar el nuevo código en el formato 00001-codigoUnidad-idTipoActivo
        $nuevoCodigo = "00001" . "-" . $codigoUnidad . "-" . $idTipoActivo . "-" . str_pad($nuevoId, 5, '0', STR_PAD_LEFT);

        // Realizar la inserción en la base de datos
        $sql2 = " INSERT INTO activo_fijo (codigo, nombre, idTipoActivo, fecha_adquisicion, valor_adquisicion, vida_util, estadoActivo,codigoUnidad,idUsuario) 
                 VALUES ('$nuevoCodigo', '$nombre', '$idTipoActivo', '$fechaAdquisicion','$valorAdquisicion','$vidaUtil','$estadoActivo','$codigoUnidad','$idUsuario')";

        $query2 = mysqli_query($con, $sql2);

        return $query2;  // Retorna el resultado de la inserción
    }


    public static function editar($data)
    {
        $con = connection();
        $nombre = $data['nombre'];
        $idTipoActivo = $data['idTipoActivo'];
        $fecha_adquisicion = $data['fecha_adquisicion'];
        $valor_adquisicion = $data['valor_adquisicion'];
        $vida_util = $data['vida_util'];
        $estadoActivo = $data['estadoActivo'];
        $codigoUnidad = $data['codigoUnidad'];

        //  código completo del activo.
        $codigo = $data['codigo'];
        $posPrimerGuion = strpos($codigo, "-");
        $posUltimoGuion = strrpos($codigo, "-");

        // Extraer la institución (todo antes del primer guion)
        $codigoInstitucionup = substr($codigo, 0, $posPrimerGuion);

        // Extraer el serial (todo después del último guion)
        $serialup = substr($codigo, $posUltimoGuion + 1);

        // Vuelve a juntar las partes en un solo string
        $nuevoCodigo = $codigoInstitucionup . "-" . $codigoUnidad . "-" . $idTipoActivo . "-" . $serialup;
        $id_activo = $data['id_activo'];

        //ejecutamos el query con posibles datos nuevos
        $sql = "UPDATE activo_fijo SET nombre='$nombre', idTipoActivo='$idTipoActivo',fecha_adquisicion='$fecha_adquisicion' 
        ,valor_adquisicion='$valor_adquisicion', vida_util='$vida_util',estadoActivo='$estadoActivo'
        ,codigoUnidad='$codigoUnidad',codigo='$nuevoCodigo'
          WHERE id_activo='$id_activo'";
        $query = mysqli_query($con, $sql);
    }

    public static function borrar($id_activo)
    {
        $con = connection();

        $sql = "DELETE FROM activo_fijo WHERE id_activo='$id_activo'";
        $query = mysqli_query($con, $sql);
    }

    public static function cambiarEstado($data)
    {
        $con = connection();
        $id_activo = $data['id_activo'];
        $estado = $data['estado'];
        $sql = $estado ? "UPDATE activo_fijo SET estado=$estado WHERE id_activo='$id_activo'" : "UPDATE activo_fijo SET estado='$estado' WHERE id_activo='$id_activo'";
        $query = mysqli_query($con, $sql);
    }
}
