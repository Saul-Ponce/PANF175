<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 


require_once('../models/CompraModel.php');




class ControladorCompra{


    public static function listar() 
    {

        $respuesta = CompraModel::listar();
        return $respuesta;
    }
    public static function listarDet($id) 
    {

        $respuesta = CompraModel::listarDet($id);
        return $respuesta;
    }


}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            $dataArray = json_decode($_POST['data_array'], true);
            var_dump($dataArray);
            
            $_SESSION['success_messageC'] = 'Compra agregada exitosamente!';
            CompraModel::agregar($_POST['fecha'], $_POST['total'], $_POST['usuario_id'], $dataArray);
            

            
            header("Location: ../vistas/generar-Compra.php");
            break;

           

           case "editar":
                CompraModel::editar($_POST);
                header("Location: ../vistas/lista-Compra.php");
                break;

            case "borrar":
                CompraModel::borrar($_POST['dui_Compra']);
                 header("Location: ../vistas/lista-Compra.php");
                break;

                    case 'updateDetalleCompra':
                        // Fetch current detallecompra data
                        $detalle = CompraModel::getDetalleById($_POST['id']);
                        $currentCantidad = (int)$detalle['cantidad'];
                        $productId = $detalle['producto_id'];
                    
                        // Fetch current inventory stock
                        $currentStock = CompraModel::getStockByProductId($productId);
                    
                        // Calculate stock change
                        $newCantidad = (int)$_POST['cantidad'];
                        $stockChange = $newCantidad - $currentCantidad;
                        $newStock = $currentStock + $stockChange;
                    
                        // Check for stock constraints
                        if ($newStock < 0) {
                            echo json_encode(['success' => false, 'message' => 'No se puede reducir la cantidad porque resultaría en stock negativo.']);
                            exit;
                        }
                    
                        // Update detallecompra and inventory stock
                        $updateDetalle = CompraModel::updateDetalle($_POST);
                        $updateStock = CompraModel::updateStock($productId, $newStock);
                    
                        if ($updateDetalle && $updateStock) {
                            echo json_encode(['success' => true]);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Error al actualizar el detalle o el inventario']);
                        }
                        break;

                        case 'updateTotalCompra';
                        $result = CompraModel::updateTotal($_POST);
                        if ($result) {
                            echo json_encode(['success' => true]);
    
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Error al actualizar el detalle']);
                        }
                        break;

                        case 'checkStockMaximo':
                            
                            
                            $stockmaximo = CompraModel::getStockMaximo($_POST['productId']);

                            $stockActual = CompraModel::getStockByProductId($_POST['productId']);
                            if(!$stockActual){
                                $stockActual=0;
                            }

                            $nuevoStock = $stockActual+$_POST['cantidadCompra'];
                            
                           

                            if ($nuevoStock > $stockmaximo) {
                                echo json_encode(['success' => false, 'message' => 'Se pasa del stock recomendado, comprar de todos modosxd?','stockMaximo'  => $stockmaximo]);
                                exit;
                            }
                            else{
                                echo json_encode(['success' => true, 'message' => 'sirvio lol?.']);

                            }
                        
                            break;
                    
                

           
        default:
            
            break;
}
    
}
