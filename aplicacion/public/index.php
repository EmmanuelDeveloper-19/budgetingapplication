<?php
require_once("../../vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

require_once("../app/init.php");
$app = new App();

?>