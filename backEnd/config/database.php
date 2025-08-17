<?php

class Database {
    private $host = "localhost"; // Corregido: solo el host, sin puerto
    private $db_name = "miniStockly_api";
    private $username = "root";
    private $password = "";
    private $port = 3307; // Cambia el puerto si es necesario
    public $conn;

    public function conectar() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;port=$this->port;dbname=$this->db_name;charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
                return $this->conn;
            }
        }