<?php namespace Flag\Framework\Database;

use Exception;
use Flag\Framework\Http\Error\InternalServerErrorException;
use PDO;
use PDOException;
use PDOStatement;

class Database {
    
    private ?PDO $connection = null;

    public function connect(string $host = null, string $name = null, string $user = null, string $pass = null, int $port = 3306): void {
        if (!is_null($this->connection)) {
            return;
        }

        if (file_exists('../config/database.php')) {
            $configs = require '../config/database.php';
            extract($configs);
        }

        $dsn = sprintf('mysql:host=%s;dbname=%s;port=%s', $host, $name, $port);

        try {
            $this->connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            throw new InternalServerErrorException();
        }
    }

    public function raw(string $sql): PDOStatement {
        $this->connect();

        $stmt = $this->connection->prepare($sql);
        return $stmt;
    }

    public function select(string $table, array $where = null, array $fields = ['*'], array $offset = null): array {
        $fieldsString = implode(', ', $fields);
        $whereString = !is_null($where) ? ' WHERE ' . $this->prepareArray($where) : '';

        $sql = "SELECT $fieldsString FROM $table $whereString";
        
        if (!is_null($offset)) {
            $start = $offset[0];
            $from = $offset[1] ?? null;

            $sql .= " LIMIT $start";

            if ($from) {
                $sql .= ", $from";
            }
        }

        $stmt = $this->raw($sql);
        $stmt->execute($where);

        return $stmt->fetchAll();
    }

    /**
     * $data = ['name' => 'John', 'email' => 'john@example.com']
     * INSERT INTO table (name, email) VALUES (:name, :email);
     * @param string $table
     * @param array $data
     * @return array
     */
    public function insert(string $table, array $data): array {
        $fields = implode(', ', array_keys($data));
        $values = implode(', ', array_map(fn($field) => ":$field", array_keys($data)));

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $stmt = $this->raw($sql);
        $stmt->execute($data);
        
        return [
            'stmt' => $stmt,
            'lastInsertId' => $this->connection->lastInsertId()
        ];
    }

    public function update(string $table, array $data, array $where): PDOStatement {
        $whereKeys = $this->prepareArray($where);
        $fieldPairs = $this->prepareArray($data, ', ');

        $sql = "UPDATE $table SET $fieldPairs WHERE $whereKeys";
        $stmt = $this->raw($sql);
        $stmt->execute(array_merge($data, $where));

        return $stmt;
    }

    public function delete(string $table, array $where): PDOStatement {
        $whereKeys = $this->prepareArray(data: $where);

        $sql = "DELETE FROM $table WHERE $whereKeys";
        $stmt = $this->raw($sql);
        $stmt->execute($where);

        return $stmt;
    }

    private function prepareArray(array $data, string $sep = ' AND '): string {
        $keys = array_keys($data);

        return implode($sep, array_map(fn($key) => "$key = :$key", $keys));
    }
}