<?php
header('Content-Type: application/json');

// Modify pathway references to fit your project structuring
include_once "db.php"; 
// include_once "lock.php"; // Uncomment if session locking checks are needed

if (!isset($conn)) {
    echo json_encode(["success" => false, "message" => "Database link instance variable unavailable."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$action = $data['action'] ?? null;
$appId  = $data['appId'] ?? null;

if (!$action || !$appId) {
    echo json_encode(["success" => false, "message" => "Missing core routing action attributes or target App ID tracking indices."]);
    exit;
}

function getApp($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM app WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// 1. ACTION: DELETE APPLICATION
if ($action === "delete") {
    $app = getApp($conn, $appId);
    if (!$app) {
        echo json_encode(["success" => false, "message" => "App target target not found."]);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM app WHERE id = ?");
    $stmt->bind_param("i", $appId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "action" => "delete", "app" => $app]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete record entry sequence logs."]);
    }
    exit;
}

// 2. ACTION: GET APP DETAILS (RETURNS ALL COLUMNS AUTOMATICALLY)
if ($action === "getAppDetails") {
    $app = getApp($conn, $appId);
    if (!$app) {
        echo json_encode(["success" => false, "message" => "App information data record not tracked."]);
        exit;
    }

    echo json_encode(["success" => true, "app" => $app]);
    exit;
}

// 3. ACTION: COMPLETELY DYNAMIC DATABASE RECORD UPDATE
if ($action === "saveUpdate") {
    // Unset transactional system configurations away from column update strings
    unset($data['action']);
    unset($data['appId']);

    if (empty($data)) {
        echo json_encode(["success" => false, "message" => "No upgrade dataset properties provided."]);
        exit;
    }

    // Security Filter: Get the real columns from the database table to prevent SQL column injection errors
    $tableColumnsResult = $conn->query("SHOW COLUMNS FROM app");
    $validColumns = [];
    while ($col = $tableColumnsResult->fetch_assoc()) {
        $validColumns[] = $col['Field'];
    }

    $updateFields = [];
    $typesString = "";
    $bindValues = [];

    // Construct statements matching only data properties that are true database columns
    foreach ($data as $columnKey => $columnValue) {
        if (in_array($columnKey, $validColumns) && $columnKey !== 'id') {
            $updateFields[] = "`$columnKey` = ?";
            $typesString .= "s"; // Bind all updates dynamically as string formats safely
            $bindValues[] = $columnValue;
        }
    }

    if (empty($updateFields)) {
        echo json_encode(["success" => false, "message" => "No modification update fields matches schema rules."]);
        exit;
    }

    // Append the primary key integer tracking rules down to parameter binding maps
    $typesString .= "i"; 
    $bindValues[] = $appId;

    // Build standard parameterized MySQL string query statement
    $queryString = "UPDATE app SET " . implode(", ", $updateFields) . " WHERE id = ?";
    $stmt = $conn->prepare($queryString);

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Statement parsing failure initialization tracking step: " . $conn->error]);
        exit;
    }

    // Dynamically unpack arguments directly into bind_param
    $stmt->bind_param($typesString, ...$bindValues);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Database dynamically matching attributes updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Execution step execution error failure status caught: " . $stmt->error]);
    }
    exit;
}