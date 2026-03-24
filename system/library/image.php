<?php

class Image
{
    protected $registry;
    private $quality = 90;

    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    public function resize($file, $width, $height)
    {
        // Убираем лишние слэши, чтобы путь склеился корректно
        $origin_file = DIR_IMAGE . ltrim($file, '/');

        if (!is_file($origin_file)) {
            return false;
        }

        $info = getimagesize($origin_file);
        $width0 = $info[0];
        $height0 = $info[1];
        $mime = $info['mime'];

        // Загружаем оригинал
        if ($mime == 'image/gif') {
            $image = imagecreatefromgif($origin_file);
        } elseif ($mime == 'image/png') {
            $image = imagecreatefrompng($origin_file);
        } else {
            $image = imagecreatefromjpeg($origin_file);
        }

        $new_image = imagecreatetruecolor($width, $height);

        // Работа с прозрачностью (PNG/GIF)
        if ($mime == 'image/png' || $mime == 'image/gif') {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            $background = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
            imagecolortransparent($new_image, $background);
            imagefill($new_image, 0, 0, $background);
        }

        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, $width0, $height0);

        // Формируем путь к кэшу
        $cache_dir = "cache/" . $width . "x" . $height . "/";
        $directory = DIR_IMAGE . $cache_dir;

        // ВАЖНО: Создаем дерево папок, если его нет
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $filename = pathinfo($file, PATHINFO_BASENAME);
        $new_file = $directory . $filename;
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        // Сохраняем
        if ($extension == 'png') {
            imagepng($new_image, $new_file);
        } elseif ($extension == 'gif') {
            imagegif($new_image, $new_file);
        } else {
            imagejpeg($new_image, $new_file, $this->quality);
        }

        // Чистим память: удаляем ОБА ресурса
        imagedestroy($image);
        imagedestroy($new_image);

        // Возвращаем относительный путь для вывода в HTML
        return 'image/' . $cache_dir . $filename;
    }

    public function getResize($file, $width, $height) {
        // 1. Базовые проверки пути
        if (!$file || !is_file(DIR_IMAGE . $file)) {
            return 'image/no-image.png'; // Путь к заглушке
        }

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $basename = pathinfo($file, PATHINFO_BASENAME);

        // Формируем относительный путь к кешу (например: cache/300x300/iphone.jpg)
        $cache_dir = 'cache/' . (int)$width . 'x' . (int)$height . '/';
        $cache_file = $cache_dir . $basename;

        // 2. Если файла в кеше НЕТ или оригинал ОБНОВИЛСЯ — генерируем заново
        if (!is_file(DIR_IMAGE . $cache_file) || (filemtime(DIR_IMAGE . $file) > filemtime(DIR_IMAGE . $cache_file))) {

            $directory = DIR_IMAGE . $cache_dir;
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            // Вызываем внутренний метод ресайза (который мы писали ранее)
            // ВАЖНО: передаем $file (относительный путь от DIR_IMAGE)
            $this->resize($file, $width, $height);
        }

        // 3. Всегда возвращаем путь, пригодный для <img src="...">
        return 'image/' . $cache_file;
    }

}
