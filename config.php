<?php
session_start();
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "lancer52662699");
define("DALE", "guest_book");
define("CHARSET", "utf-8");
define("SALT", "webDEVblog");

/*Создаем подключение к БД*/
$dsn = "mysql:host=" . HOST . ";dbname=" . DALE . ";charset=" . CHARSET . "";
try {
    $dbConn = new PDO($dsn, USER, PASSWORD);
} catch (PDOException $e) {
    die('Подключение не удалось:' . $e->getMessage());
}