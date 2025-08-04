<?php
require_once "../models/mesero/consultas_mesero.php";

$consultasMesero = new consultas_mesero();
$mesas = $consultasMesero->traerMesas();

$option = "";
if (empty($mesas)) {
    $option = "<option value=\"\">No hay mesas creadas</option>";
    echo $option;
    exit;
}
//opcion por defecto
$option .= "<option value=\"\">Seleccione Mesa</option>"; // el .= concatena!!!
foreach ($mesas as $mesa) {
    $estadoTexto = "";
    $disabled = "";
    
    switch ($mesa['estado_mesa']) {
        case 'ocupada_pedido':
            $estadoTexto = " (Con pedido activo)";
            $disabled = " disabled";
            break;
    }
    
    $option .= "<option value=\"{$mesa['idmesas']}\"{$disabled}>{$mesa['nombre']}{$estadoTexto}</option>";
}
echo $option;