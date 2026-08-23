<?php
session_start();
require_once("core/app.php");
require_once("core/db.php");
require_once("core/controller.php");

define("MAIN_ROOT", __DIR__);
define("PATH", "/");
define("MODELS", __DIR__ . "/models/");
define("CONTROLLERS", __DIR__ . "/Controllers/");
define("VIEWS", __DIR__ . "/Views/");
define("INCLUDES", __DIR__ . "/includes/");
define('API_CONTROLLERS', __DIR__ . "/Controllers/api/");
define('JWT_SECRET', "TuClaveMuySegura_123!!1234567890abcdefghijklmnopqrstuvwxyz");

?>