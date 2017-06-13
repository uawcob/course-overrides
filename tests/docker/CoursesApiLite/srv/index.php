<?php

header('Content-Type: application/json');

// semester string
$strm = $_GET['1'] ?? null;

// course number
$number = $_GET['2'] ?? null;

$json = "courses/$strm/$number.json";

if (!file_exists($json)) {
    die(json_encode([]));
}

die(file_get_contents($json));
