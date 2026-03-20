<?php
class Profiler {
    private $start_time;
    private $logs = [];
    private $queries = [];

    public function __construct() {
        $this->start_time = microtime(true);
    }

    // Запись контрольной точки
    public function log($message) {
        $this->logs[] = [
            'time' => round(microtime(true) - $this->start_time, 4),
            'memory' => round(memory_get_usage() / 1024 / 1024, 2),
            'message' => $message
        ];
    }

    // Запись SQL запроса
    public function logQuery($sql, $time) {
        $this->queries[] = [
            'sql' => $sql,
            'time' => round($time, 4)
        ];
    }

    public function getMetrics() {
        return [
            'logs' => $this->logs,
            'queries' => $this->queries,
            'total_time' => round(microtime(true) - $this->start_time, 4),
            'total_memory' => round(memory_get_peak_usage() / 1024 / 1024, 2)
        ];
    }
}