<?php
header('Content-Type: application/json');

// --- CONFIGURATION ---
$log_file = __DIR__ . '/activity_logs.txt';
// ---------------------

$response = ["status" => "error", "message" => "No operational data processed."];

// 1. DISK STORAGE ROTATION CHECK (30 Days)
// 30 days = 2,592,000 seconds
if (file_exists($log_file)) {
    $file_age = time() - filemtime($log_file);
    if ($file_age >= 2592000) {
        file_put_contents($log_file, ''); // Clear the content completely
        $response["rotation_status"] = "Log file exceeded 30 days and was automatically cleared.";
    }
}

// 2. PROCESSING INBOUND TELEMETRY
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents('php://input');
    $decoded_data = json_decode($json_data, true);

    if ($decoded_data) {
        $type        = filter_var($decoded_data['type'] ?? 'interaction', FILTER_DEFAULT);
        $page        = filter_var($decoded_data['page'] ?? 'Unknown', FILTER_SANITIZE_URL);
        $details     = filter_var($decoded_data['details'] ?? '', FILTER_DEFAULT);
        $username    = filter_var($decoded_data['username'] ?? 'Guest', FILTER_DEFAULT);
        
        $timestamp   = date('Y-m-d H:i:s');
        $ip_address  = $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP';
        
        $geo_info = "";
        if (strtolower($username) === 'guest') {
            $user_timezone = date_default_timezone_get();
            $geo_info = " | Timezone: " . $user_timezone;
        }

        $log_entry = "[$timestamp] [$type] User: $username | IP: $ip_address$geo_info | Page: $page | Action: $details" . PHP_EOL;
        
        if (file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX) !== false) {
            $response["status"] = "success";
            $response["message"] = "Event logged successfully on server.";
        } else {
            $response["status"] = "error";
            $response["message"] = "Server filesystem error: cannot write to activity_logs.txt.";
        }
    }
}

echo json_encode($response);
?>