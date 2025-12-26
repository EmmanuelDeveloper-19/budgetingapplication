<?php

class Db
{
    private static $connection;
    private $response;

    public function __construct() {
        self::$connection = null;
        $this->id = 0;
        $this->response = null;
    }

    public function get_connection() {
        return self::$connection;
    }

    public function set_response($response) {
        $this->response = $response;
    }

    public function get_response() {
        return $this->response;
    }

    public function connect() {
        if (!isset(self::$connection)) {
            $prefix = "";
            $config = parse_ini_file(MAIN_ROOT . '/configuration.ini');

            if ($_SERVER['HTTP_HOST'] == 'localhost')
                $prefix = "dev_";

            self::$connection = new mysqli(
                $config[$prefix . 'hosting'],
                $config[$prefix . 'username'],
                $config[$prefix . 'password'],
                $config[$prefix . 'dbname']
            );

            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }

            self::$connection->set_charset("utf8");
        }

        return self::$connection;
    }

    public function query($query) {
        return $this->connect()->query($query);
    }

    public function select($query) {
        $rows = [];
        $result = $this->query($query);

        if ($result === false) {
            return false;
        }

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function preparedQuery($query, $types, $data, $get_last_id = false) {
        $stmt = $this->get_prepared_statement($query, $types, $data);

        if ($stmt->execute()) {
            if ($get_last_id) {
                return $stmt->insert_id;
            } else {
                return $stmt->affected_rows;
            }
        }

        return false;
    }

    public function preparedSelect($query, $types, $data) {
        $stmt = $this->get_prepared_statement($query, $types, $data);

        if ($stmt->execute()) {
            $meta = $stmt->result_metadata();
            $params = [];
            $row = [];
            
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }

            call_user_func_array([$stmt, 'bind_result'], $params);

            $rows = [];
            while ($stmt->fetch()) {
                $tmp = [];
                foreach ($row as $key => $val) {
                    $tmp[$key] = $val;
                }
                $rows[] = $tmp;
            }

            return $rows;
        }

        $stmt->close();
        return false;
    }

    private function get_prepared_statement($query, $types, $data) {
        $params = [];
        $params[] = $types;
        
        foreach ($data as $index => $value) {
            $params[] = &$data[$index];
        }

        $stmt = $this->connect()->prepare($query);

        if ($stmt === false) {
            throw new Exception('Failed to prepare statement: ' . $this->connect()->error);
        }

        call_user_func_array([$stmt, 'bind_param'], $params);

        return $stmt;
    }

    public function error() {
        return $this->connect()->error;
    }

    public function quote($value) {
        $connection = $this->connect();
        return $connection->real_escape_string($value);
    }

    /* === NUEVOS MÉTODOS PARA TRANSACCIONES === */
    public function beginTransaction() {
        $this->connect()->begin_transaction();
    }

    public function commit() {
        $this->connect()->commit();
    }

    public function rollback() {
        $this->connect()->rollback();
    }
}

?>
