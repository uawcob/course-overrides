<?php

header('Content-Type: application/json');

$empty = function(){
    die(json_encode([]));
};

// strm
if ('1176' !== $_GET['1'] ?? null) {
    $empty();
}

// course number
$number = $_GET['2'] ?? null;

if (!file_exists("$number.json")) {
    $empty();
}

die(file_get_contents("$number.json"));
