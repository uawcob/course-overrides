<?php

header('Content-Type: application/json');

$name = trim($_SERVER['SCRIPT_NAME'], '/');

if (($name === 'majorminors') && (($_SERVER['HTTP_X_PASSWORD'] ?? null) !== 'AuthToken')) {
    http_response_code(401);
    die();
}

$resource = $_GET['1'] ?? null;

if (isset($_GET['2'])) {
    $resource .= "/$_GET[2]";
}

$json = __DIR__."/$name/$resource.json";

if (!file_exists($json)) {
    die(json_encode([]));
}

die(file_get_contents($json));
