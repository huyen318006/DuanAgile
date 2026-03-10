<?php
session_start();
// Đây là file chạy chính (Là nơi chúng require các file)
require_once "./env.php";    // Chứa các biến môi trường

require_once PATH_ROOT . "vendor/autoload.php";
// Không cần require controller và model

require_once PATH_ROOT . 'routes/router.php';
