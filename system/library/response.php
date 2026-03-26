<?php
class Response {
    private $headers = [];
    private $output;

    // Добавить HTTP-заголовок
    public function addHeader($header) {
        $this->headers[] = $header;
    }

    // Сохранить готовый HTML (то, что придет из View)
    public function setOutput($output) {
        $this->output = $output;
    }

    // Финальный вывод всего накопленного в браузер
    public function output() {
        if ($this->output) {
            foreach ($this->headers as $header) {
                header($header, true);
            }

            echo $this->output;
        }
    }

    public function redirect($url, $status = 302) {
        header('Location: ' . str_replace(['&amp;', "\n", "\r"], ['&', '', ''], $url), true, $status);
        exit;
    }
}
