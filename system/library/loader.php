<?php
class Loader {
    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
    }

    // Загрузка контроллера (логика)
    public function controller($route, $data = array()) {
        $parts = explode('/', str_replace('../', '', (string)$route));
        $method = array_pop($parts); // Последняя часть — это метод (например, index)
        $file = DIR_APP . 'controller/' . implode('/', $parts) . '.php';
        $class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', implode('', $parts));

        if (file_exists($file)) {
            include_once($file);
            $controller = new $class($this->registry);
            return $controller->$method($data);
        } else {
            exit('Ошибка: Не удалось загрузить контроллер ' . $route . '!');
        }
    }

    // Загрузка шаблона (отображение)
    public function view($route, $data = array()) {
        $file = DIR_APP . 'view/' . $route . '.php'; // Пока используем простой PHP
        
        if (file_exists($file)) {
            extract($data); // Превращает ['title' => 'Hello'] в переменную $title
            ob_start();
            require($file);
            return ob_get_clean();
        } else {
            exit('Ошибка: Не удалось найти шаблон ' . $route . '!');
        }
    }
}