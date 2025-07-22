<?php

class Database {
    private static $instance = null;
    private $connection;
    private $host = DB_CONFIG['host'];
    private $dbname = DB_CONFIG['dbname'];
    private $username = DB_CONFIG['username'];
    private $password = DB_CONFIG['password'];
    private $charset = DB_CONFIG['charset'];
    
    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $this->connection = new PDO($dsn, $this->username, $this->password, DB_CONFIG['options']);
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
        
             public function fetchColumn($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            return false;
        }
    }
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch() : false;
    }
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll() : false;
    }
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        
        if ($this->query($sql, $data)) {
            return $this->connection->lastInsertId();
        }
        return false;
    }
    public function update($table, $data, $condition, $conditionParams = []) {
        $setClause = [];
        foreach ($data as $key => $value) {
            $setClause[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setClause);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$condition}";
        
        $params = array_merge($data, $conditionParams);
        return $this->query($sql, $params) !== false;
    }
    public function delete($table, $condition, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$condition}";
        return $this->query($sql, $params) !== false;
    }
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    public function commit() {
        return $this->connection->commit();
    }
    public function rollback() {
        return $this->connection->rollback();
    }
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
    public function rowCount($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() : 0;
    }
}
?>