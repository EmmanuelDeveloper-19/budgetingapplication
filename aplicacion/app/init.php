<?php
session_start();
require_once("core/app.php");
require_once("core/db.php");
require_once("core/controller.php");

define("MAIN_ROOT", __DIR__);
define("PATH", "/budgetingapp/aplicacion/public/");
define("MODELS", __DIR__ . "/Models/");
define("CONTROLLERS", __DIR__ . "/Controllers/");
define("VIEWS", __DIR__ . "/Views/");
define("INCLUDES", __DIR__ . "/includes/");
define('JWT_SECRET', "TuClaveMuySegura_123!!1234567890abcdefghijklmnopqrstuvwxyz");

?>