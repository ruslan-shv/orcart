<?php
class DB {
    private $connection;
    private $registry;

    public function __construct($registry) {
        $this->registry = $registry;
        $this->connection = new \MySQLi(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD,
            DB_DATABASE, DB_PORT);

        if ($this->connection->connect_error) {
            throw new \Exception('Ошибка подключения к БД: ' . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8");
    }

    public function query($sql) {
        $start = microtime(true);
        
        $query = $this->connection->query($sql);

        if (!$this->connection->errno) {
            if ($query instanceof \mysqli_result) {
                $data = [];
                while ($row = $query->fetch_assoc()) {
                    $data[] = $row;
                }

                $result = new \stdClass();
                $result->num_rows = $query->num_rows;
                $result->row = isset($data[0]) ? $data[0] : [];
                $result->rows = $data;

                $query->close();
            } else {
                $result = true;
            }
        } else {
            throw new \Exception('Ошибка SQL: ' . $this->connection->error . '<br />' . $sql);
        }

        // Записываем запрос в профилировщик
        if ($this->registry && $this->registry->get('profiler')) {
            $this->registry->get('profiler')->logQuery($sql, microtime(true) - $start);
        }

        return $result;
    }

    public function escape($value) {
        return $this->connection->real_escape_string($value);
    }
    
    public function getLastId() {
        return $this->connection->insert_id;
    }
}