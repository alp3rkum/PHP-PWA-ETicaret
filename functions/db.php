<?php
class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        $this->conn = new mysqli('localhost:3307', 'root', '', '');
        $this->conn->set_charset('utf8mb4');

        if ($this->conn->connect_error) {
            die('Veritabanı bağlantısı başarısız: ' . $this->conn->connect_error);
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }

    private function __clone() {}

    public function select($queryBody, $single = false)
    {
        $query = "SELECT " . $queryBody;
        $result = $this->conn->query($query);

        if ($result) {
            if ($single) {
                return $result->fetch_assoc();
            } else {
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
        }
        else
        {
            throw new Exception('Veritabanı sorgusu başarısız: ' . $this->conn->error);
        }
    }

    public function insert($table, $data, $updateOnDuplicate = false) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        if ($updateOnDuplicate) {
            $updateColumns = implode(', ', array_map(fn($key) => "$key = VALUES($key)", array_keys($data)));
            $sql .= " ON DUPLICATE KEY UPDATE $updateColumns";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($data)), ...array_values($data));
        
        if (!$stmt->execute()) {
            throw new Exception('INSERT işlemi başarısız: ' . $stmt->error);
        }
    
        return $this->conn->insert_id;
    }
    
    public function update($table, $data, $where) {
        $allowedTables = ["adminler", "kullanicilar"];
        if (!in_array($table, $allowedTables)) {
            throw new Exception('Geçersiz tablo adı.');
        }
    
        $setPart = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));
        $stmt = $this->conn->prepare("UPDATE $table SET $setPart WHERE $where");
    
        $types = '';
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } elseif (is_string($value)) {
                $types .= 's';
            } else {
                throw new Exception('Geçersiz veri türü algılandı.');
            }
        }
    
        $stmt->bind_param($types, ...array_values($data));
    
        if (!$stmt->execute()) {
            throw new Exception('UPDATE işlemi başarısız: ' . $stmt->error);
        }
    
        return $stmt->affected_rows;
    }
    
    
    public function delete($table, $where) {
        $stmt = $this->conn->prepare("DELETE FROM $table WHERE $where");
    
        if (!$stmt->execute()) {
            throw new Exception('DELETE işlemi başarısız: ' . $stmt->error);
        }
    
        return $stmt->affected_rows;
    }
    
    public function truncate($table)
    {
        $query = "TRUNCATE TABLE $table";
        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            throw new Exception('Tabloyu temizleme işlemi başarısız: ' . $this->conn->error);
        }
    }
}
?>