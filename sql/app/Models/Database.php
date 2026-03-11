<?php

class Database {
    private $db;
    private $dbPath = __DIR__ . '/../../database/users.db';

    public function __construct() {
        try {
            $this->db = new PDO('sqlite:' . $this->dbPath);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->initializeDatabase();
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    private function initializeDatabase() {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ";
        
        $this->db->exec($sql);

        // Insertar usuarios de prueba si no existen
        $checkCount = $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        if ($checkCount == 0) {
            $this->db->exec("
                INSERT INTO users (username, password, email) VALUES
                ('admin', 'admin123', 'admin@example.com'),
                ('usuario1', 'pass123', 'usuario1@example.com'),
                ('usuario2', 'pass456', 'usuario2@example.com'),
                ('john', 'john2024', 'john@example.com')
            ");
        }
    }

    public function query($sql) {
        return $this->db->prepare($sql);
    }

    public function getConnection() {
        return $this->db;
    }

    public function execute($stmt, $params = []) {
        try {
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
