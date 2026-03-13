<?php
require 'env.php';
$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tables = ['order_items', 'orders', 'foods', 'users'];
foreach ($tables as $t) {
    echo "=== $t ===" . PHP_EOL;
    try {
        $r = $db->query("DESCRIBE $t");
        while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
            echo "  " . $row['Field'] . " | " . $row['Type'] . " | " . $row['Key'] . PHP_EOL;
        }
    } catch (Exception $e) {
        echo "  Table not found" . PHP_EOL;
    }
    echo PHP_EOL;
}
