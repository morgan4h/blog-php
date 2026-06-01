<?php

$action = $_SERVER['HTTP_ACTION'] ?? ($_SERVER['HTTP_X_ACTION'] ?? '');

$file = __DIR__ . '/../js/links.json';
$json = json_decode(file_get_contents($file), true);

// -------------------------
// 1. SOCIAL LINKS UPDATE
// -------------------------
if ($action === 'sc') {

    $newData = json_decode(file_get_contents('php://input'), true);

    $json['sm'][0] = [
        'telegram' => $newData['telegram'] ?? '',
        'yt'       => $newData['yt'] ?? '',
        'email'    => $newData['email'] ?? '',
        'x'        => $newData['x'] ?? ''
    ];

    file_put_contents(
        $file,
        json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    );

    echo json_encode([
        'success' => true,
        'message' => 'social links updated'
    ]);

    exit;
}

// -------------------------
// 2. MAIN VIDEO UPDATE
// -------------------------
if ($action === 'mainVideo') {

    $newData = json_decode(file_get_contents('php://input'), true);

    if (isset($newData['mainVideo'])) {
        $json['mainVideo'] = $newData['mainVideo'];
    }

    file_put_contents(
        $file,
        json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    );

    echo json_encode([
        'success' => true,
        'message' => 'main video updated',
        'mainVideo' => $json['mainVideo']
    ]);

    exit;
}

// -------------------------
// fallback
// -------------------------
echo json_encode([
    'success' => false,
    'message' => 'invalid action'
]);