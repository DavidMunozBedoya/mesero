<?php

// Clase para gestionar las consultas del mesero
require_once __DIR__ . "/../MySQL.php";
require_once __DIR__ . "/../../config/config.php";


class consultas_mesero
{
    // Atributo para la conexión a la base de datos
    private $mysql;

    public function __construct()
    {
        $this->mysql = new MySql();
    }

    public function traerMesas(){
        $query = "
            SELECT 
                m.idmesas,
                m.nombre,
                m.estados_idestados,
                -- Verificar si tiene pedidos confirmados (en proceso)
                CASE 
                    WHEN EXISTS (
                        SELECT 1 FROM pedidos p 
                        WHERE p.mesas_idmesas = m.idmesas 
                        AND p.estados_idestados = 3
                    ) THEN 'ocupada_pedido'
                    WHEN EXISTS (
                        SELECT 1 FROM tokens_mesa t 
                        WHERE t.mesas_idmesas = m.idmesas 
                        AND t.estado_token = 'activo' 
                        AND t.fecha_hora_expiracion > NOW()
                    ) THEN 'ocupada_token'
                    ELSE 'disponible'
                END as estado_mesa
            FROM mesas m 
            WHERE m.estados_idestados = 1
            ORDER BY m.nombre";
        return $this->mysql->efectuarConsulta($query);
    }

    public function traerCategorias()
    {
        $query = "SELECT idcategorias, nombre_categoria FROM categorias WHERE estados_idestados = 1 ORDER BY nombre_categoria";
        return $this->mysql->efectuarConsulta($query);
    }



}

?>