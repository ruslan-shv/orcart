<?php
abstract class Controller {
    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
    }

    // Эта магия перехватывает обращение к $this->load
    public function __get($key) {
        return $this->registry->get($key);
    }
}
