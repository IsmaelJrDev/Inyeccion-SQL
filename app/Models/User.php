<?php

class User {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Método VULNERABLE - Sin validación de inyección SQL
    // Este método está intencionalmente vulnerable para propósitos educativos
    public function loginVulnerable($username, $password) {
        $sql = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";
        
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    // Método SEGURO - Con prepared statements
    public function loginSecure($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $this->db->query($sql);
        return $this->db->execute($stmt, [$username, $password])->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todos los usuarios
    public function getAllUsers() {
        $sql = "SELECT id, username, email, created_at FROM users ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        $this->db->execute($stmt);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener usuario por ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->query($sql);
        return $this->db->execute($stmt, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nuevo usuario
    public function createUser($username, $password, $email) {
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $this->db->query($sql);
        return $this->db->execute($stmt, [$username, $password, $email]);
    }
}
?>
