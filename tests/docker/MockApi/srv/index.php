<?php

header('Content-Type: application/json');

$name = trim($_SERVER['SCRIPT_NAME'], '/');

$resource = $_GET['1'] ?? null;

if (isset($_GET['2'])) {
    $resource .= "/$_GET[2]";
}

$json = "$name/$resource.json";

if (!file_exists($json)) {
    die(json_encode([]));
}

die(file_get_contents($json));
