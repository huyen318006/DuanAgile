<?php
// Composer require eftec/bladeone
use eftec\bladeone\BladeOne;

if (!function_exists('view')) {
    function view($viewFile, $data = [])
    {
        $viewDir = PATH_ROOT . "/views";
        $storageDir = PATH_ROOT . "/storage/cache";
        $blade = new BladeOne($viewDir, $storageDir, BladeOne::MODE_DEBUG);
        echo $blade->run($viewFile, $data);
    }
}

if (!function_exists('is_upload')) {
    function is_upload($key)
    {
        return isset($_FILES[$key]) && $_FILES[$key]['size'] > 0;
    }
}

if (!function_exists('route')) {
    function route($path)
    {
        return APP_URL . $path;
    }
}

if (!function_exists('redirect')) {
    function redirect($path)
    {
        header('Location: ' . APP_URL . $path);
        exit;
    }
}

if (!function_exists('file_url')) {
    function file_url($path)
    {
        if (!file_exists($path)) {
            return null;
        }

        return APP_URL . $path;
    }
}

if (!function_exists('asset')) {
    function asset($path)
    {
        $publicPath = realpath(PATH_ROOT . './public/'); 
        if (!file_exists($publicPath . '/' . ltrim($path, '/'))) {
            return null; 
        }

        return rtrim(APP_URL, '/') . '/public/' . ltrim($path, '/');
    }
}



if (!function_exists('redirect404')) {
    function redirect404()
    {
        header('HTTP/1.1 404 Not Found');
        exit;
    }
}

