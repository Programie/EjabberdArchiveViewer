<?php
use com\selfcoders\ejabberdarchiveviewer\PageRenderer;

require_once __DIR__ . "/../bootstrap.php";

$router = new AltoRouter;

$router->map("GET|POST", "/", "getMainPage");
$router->map("GET|POST", "/search", "getSearchPage");

$match = $router->match($_SERVER["PATH_INFO"] ?? "/");

if ($match === false) {
    http_response_code(404);
    echo "Not found";
    exit;
}

call_user_func(sprintf("%s::%s", PageRenderer::class, $match["target"]));