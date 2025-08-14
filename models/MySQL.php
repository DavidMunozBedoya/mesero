<?php
//clase para gestionar la conexion a la base de datos 
require_once __DIR__ . '/../config/config.php';
class MySql
{
    //datos de conexion
    private $pdo;

    //metodo para conectar a la base de datos
    public function __construct() {
        try {
            $this->pdo = config::conectar();
        } catch (PDOException $e) {
            throw new Exception("Error de conexión: " . $e->getMessage());
        }
    }

    // Método para ejecutar consultas simples
    public function efectuarConsulta($sql) {
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    // Método para ejecutar sentencias preparadas
    public function ejecutarSentenciaPreparada($sql, $parametros = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parametros);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error en la sentencia preparada: " . $e->getMessage());
        }
    }

    // Método para ejecutar INSERT/UPDATE/DELETE con parámetros
    public function ejecutarConsultaPreparada($sql, $parametros = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parametros);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Error en la consulta preparada: " . $e->getMessage());
        }
    }

    // Método para ejecutar SELECT con parámetros
    public function consultarConParametros($sql, $parametros = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error en la consulta con parámetros: " . $e->getMessage());
        }
    }

    // Método para obtener el último ID insertado
    public function obtenerUltimoId() {
        return $this->pdo->lastInsertId(); // funcion nativa de PDO
    }
}
?>
