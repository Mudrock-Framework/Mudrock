<?php
require_once("../vendor/autoload.php");
require_once("../app/config/config.php");
require_once("../system/helpers/functions.php");
use system\core\BaseRouter;

$app = new BaseRouter();
$app->run();