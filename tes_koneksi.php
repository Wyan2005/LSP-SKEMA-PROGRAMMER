<?php
echo "__DIR__ = " . __DIR__ . "<br>";
echo "File exists? ";

if (file_exists(__DIR__ . "/config/database.php")) {
    echo "YA<br>";
    require_once __DIR__ . "/config/database.php";
    echo "DATABASE OK";
} else {
    echo "TIDAK";
}
