<?php
class Loader {
    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
    }

    // Загрузка контроллера (логика)
    public function controller($route, $data = array()) {
        $action = new Action($route);

        // Выполняем его, передавая реестр и аргументы
        return $action->execute($this->registry, $data);
    }

    public function model($route) {
        // Превращаем 'catalog/product' в 'ModelCatalogProduct'
        $class = 'Model' . preg_replace('/[^a-zA-Z0-0]/', '', $route);

        // Путь к файлу: catalog/model/product.php
        $file = DIR_APP . 'model/' . $route . '.php';

        if (file_exists($file)) {
            include_once($file);

            // Создаем экземпляр модели и передаем ей Registry
            $proxy = new $class($this->registry);

            // Записываем модель в Registry, чтобы она была доступна везде
            // Например: $this->model_catalog_product
            $this->registry->set('model_' . str_replace('/', '_', $route), $proxy);
        } else {
            var_dump($file);
            throw new \Exception('Error: Could not load model ' . $route . '!');
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
            exit('Ошибка: Не удалось найти шаблон ' . $file . '!');
        }
    }
}