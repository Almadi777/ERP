<?php

const MAX_GENERATED_NUMBERS = 100;

$generatedNumbers = array();

$id = 1;

function generate() {
    global $generatedNumbers, $id;
    if (count($generatedNumbers) >= MAX_GENERATED_NUMBERS) {
        return array('error' => 'Maximum number of generated numbers reached');
    }
    $generatedNumber = rand();
    $generatedNumbers[$id] = $generatedNumber;
    return array('id' => $id++, 'generatedNumber' => $generatedNumber);
}

function retrieve($id) {
    global $generatedNumbers;
    if (!array_key_exists($id, $generatedNumbers)) {
        return array('error' => 'Generated number not found');
    }
    return array('id' => $id, 'generatedNumber' => $generatedNumbers[$id]);
}

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET' && array_key_exists('id', $_GET)) {
    $id = intval($_GET['id']);
    $response = retrieve($id);
} elseif ($method === 'POST') {
    $response = generate();
} else {
    $response = array('error' => 'Invalid request');
}

header('Content-Type: application/json');
echo json_encode($response);