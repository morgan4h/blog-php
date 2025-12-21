<?php
include_once 'db.php';

// Tell the browser this is JSON
header('Content-Type: application/json');

$sql = "SELECT id, name, type, picture_app, category, description, version, size, download_link FROM app";
$result = mysqli_query($conn, $sql);

$apps = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $apps[] = $row; // push each row as an object
    }

    echo json_encode([
        "success" => true,
        "count" => count($apps),
        "data" => $apps
    ], JSON_PRETTY_PRINT);

} else {
    echo json_encode([
        "success" => false,
        "count" => 0,
        "data" => [],
        "message" => "No results found"
    ]);
}

mysqli_close($conn);
