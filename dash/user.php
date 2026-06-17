<?php
// ==========================================
// 1. BACKEND ROUTING & API ENGINE (TOP OF FILE)
// ==========================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../controll/db.php";
include_once '../controll/lock.php';
// include_once "../controll/lock.php"; // Uncomment if your session locking script is needed

// Check if the request is an incoming JSON API AJAX call
$contentType = $_SERVER["CONTENT_TYPE"] ?? '';
if (stripos($contentType, 'application/json') !== false) {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);

    $action = $data['action'] ?? null;
    $userId = $data['userId'] ?? null;

    if (!$action || !$userId) {
        echo json_encode(["success" => false, "message" => "Missing action or userId tracking parameter."]);
        exit;
    }

    // Helper to grab specific user record row state
    function getUser($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // --- Action: Delete ---
    if ($action === "delete") {
        $user = getUser($conn, $userId);
        if (!$user) {
            echo json_encode(["success" => false, "message" => "User record not found."]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "user" => $user]);
        } else {
            echo json_encode(["success" => false, "message" => "Delete query failed."]);
        }
        exit;
    }

    // --- Action: Get Details ---
    if ($action === "getUserDetails") {
        $user = getUser($conn, $userId);
        if (!$user) {
            echo json_encode(["success" => false, "message" => "User data details not found."]);
            exit;
        }
        echo json_encode(["success" => true, "user" => $user]);
        exit;
    }

    // --- Action: Dynamic Update ---
    if ($action === "saveUpdate") {
        unset($data['action']);
        unset($data['userId']);

        if (empty($data)) {
            echo json_encode(["success" => false, "message" => "No updated values provided."]);
            exit;
        }

        // Fetch valid database table columns structurally to protect against SQL injections
        $tableColumnsResult = $conn->query("SHOW COLUMNS FROM users");
        $validColumns = [];
        while ($col = $tableColumnsResult->fetch_assoc()) {
            $validColumns[] = $col['Field'];
        }

        $updateFields = [];
        $typesString = "";
        $bindValues = [];

        foreach ($data as $columnKey => $columnValue) {
            if (in_array($columnKey, $validColumns) && $columnKey !== 'id') {
                $updateFields[] = "`$columnKey` = ?";
                $typesString .= "s"; // Bind parameters consistently as strings safely
                $bindValues[] = $columnValue;
            }
        }

        if (empty($updateFields)) {
            echo json_encode(["success" => false, "message" => "No matching system columns to upgrade."]);
            exit;
        }

        $typesString .= "i";
        $bindValues[] = $userId;

        $queryString = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
        $stmt = $conn->prepare($queryString);

        if (!$stmt) {
            echo json_encode(["success" => false, "message" => "SQL Statement Preparation Failed: " . $conn->error]);
            exit;
        }

        $stmt->bind_param($typesString, ...$bindValues);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "User record structural components saved successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Execution step error: " . $stmt->error]);
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users Dashboard</title>
    <link rel="stylesheet" href="../public/style/index.css">
    <style>
        :root {
            --bg-main: #f8fafc;
            --bg-nav: #1e293b;
            --bg-sidebar: #0f172a;
            --sidebar-hover: #1e293b;
            --text-dark: #334155;
            --text-light: #cbd5e1;
            --border-color: #e2e8f0;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --danger: #dc2626;
            --danger-hover: #b91c1c;
        }

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body{
            background: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .nav{
            height: 60px;
            background: var(--bg-nav);
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .sidebar{
            width: 240px;
            height: calc(100vh - 60px);
            background: var(--bg-sidebar);
            position: fixed;
            left: 0;
            top: 60px;
            padding-top: 15px;
        }

        .sidebar p{
            display: flex;
            align-items: center;
            color: var(--text-light);
            padding: 14px 24px;
            gap: 12px;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .sidebar p:hover{
            background: var(--sidebar-hover);
            color: #fff;
        }

        .content{
            margin-left: 240px;
            margin-top: 60px;
            padding: 40px;
        }

        /* User Presentation Listing Styling */
        .user-list {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-top: 20px;
        }

        .user-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .user-row:last-child {
            border-bottom: none;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .user-id {
            font-size: 0.8rem;
            color: #94a3b8;
            font-weight: bold;
        }

        .user-details {
            font-size: 1rem;
            color: #1e293b;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            color: #fff;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
            border: none;
        }

        .update { background: var(--primary); }
        .update:hover { background: var(--primary-hover); }
        .delete { background: var(--danger); }
        .delete:hover { background: var(--danger-hover); }

        /* Modal Overlays Layout Windows */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-box {
            background: #fff;
            width: 100%;
            max-width: 450px;
            max-height: 85vh;
            overflow-y: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-divider {
            border: 0;
            height: 1px;
            background: var(--border-color);
            margin: 15px 0 20px 0;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            text-transform: capitalize;
        }

        .form-group input {
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.95rem;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--primary);
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn-cancel { background: #e2e8f0; color: #475569; width: 100%; }
        .btn-save { background: var(--primary); color: white; width: 100%; }

        .empty-state {
            padding: 30px;
            text-align: center;
            color: #64748b;
        }
    </style>
</head>
<body>

<nav></nav>



<div class="content">
    <h2>System Users</h2>
    <div class="user-list">
    <?php
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="user-row">';
            
            echo '<div class="user-info">';
            echo '<span class="user-id">ID: ' . htmlspecialchars($row["id"]) . '</span>';
            
            // Build out a dynamic preview of whatever columns exist
            echo '<div class="user-details">';
            foreach ($row as $key => $val) {
                if ($key !== 'id') {
                    echo '<strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($val ?? 'N/A') . ' | ';
                }
            }
            echo '</div>';
            echo '</div>'; // End info

            echo '<div class="actions">';
            echo '<button class="btn update" data-id="' . htmlspecialchars($row["id"]) . '">Update</button>';
            echo '<button class="btn delete" data-id="' . htmlspecialchars($row["id"]) . '">Delete</button>';
            echo '</div>';

            echo '</div>';
        }
    } else {
        echo '<div class="empty-state">0 results found inside user table list mappings.</div>';
    }
    ?>
    </div>
</div>

<div id="userModal" class="modal-overlay">
    <div class="modal-box">
        <h2>Update User Profile</h2>
        <hr class="modal-divider">
        
        <form id="userUpdateForm">
            <input type="hidden" id="editUserId">

            <div id="dynamicInputs"></div>

            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" id="closeModal">Cancel</button>
                <button type="submit" class="btn btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
console.log("Single page user administration runtime running...");

const userModal = document.getElementById('userModal');
const closeModal = document.getElementById('closeModal');
const userUpdateForm = document.getElementById('userUpdateForm');
const dynamicInputs = document.getElementById('dynamicInputs');

function userCrud(action, userId, extraData = {}) {
    let payload = { action: action, userId: userId };
    if (action === 'saveUpdate') {
        payload = { action: action, userId: userId, ...extraData };
    }

    // Notice we submit the request to the exact same page URL location
    fetch(window.location.href, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
            return;
        }

        if (action === 'delete') {
            let user = data.user;
            if (confirm(`Are you sure you want to delete user ID ${user.id}?`)) {
                alert("User removed successfully.");
                location.reload();
            }
        }

        if (action === 'getUserDetails') {
            const user = data.user;
            document.getElementById('editUserId').value = user.id;
            
            // Clear prior dynamic layouts
            dynamicInputs.innerHTML = '';

            // Generate an input node element field for every single key tracking in the DB row
            Object.keys(user).forEach(key => {
                if (key === 'id') return; // Hide primary key from configuration edits

                const formGroup = document.createElement('div');
                formGroup.className = 'form-group';

                const label = document.createElement('label');
                label.textContent = key.replace('_', ' ');

                const input = document.createElement('input');
                input.type = 'text';
                input.value = user[key] !== null ? user[key] : '';
                input.dataset.col = key; 
                input.required = true;

                formGroup.appendChild(label);
                formGroup.appendChild(input);
                dynamicInputs.appendChild(formGroup);
            });

            userModal.classList.add('active');
        }

        if (action === 'saveUpdate') {
            alert("User updated successfully!");
            userModal.classList.remove('active');
            location.reload();
        }
    })
    .catch(err => console.error("Error executing dynamic operation stream:", err));
}

// Click listener capturing action buttons directly using dataset attributes
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn')) {
        const userId = e.target.dataset.id;
        
        if (e.target.classList.contains('delete')) {
            userCrud('delete', userId);
        }
        if (e.target.classList.contains('update')) {
            userCrud('getUserDetails', userId);
        }
    }
});

closeModal.addEventListener('click', () => userModal.classList.remove('active'));

userUpdateForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('editUserId').value;
    const extraData = {};

    // Map out the dynamically evaluated input variables
    const inputs = dynamicInputs.querySelectorAll('input');
    inputs.forEach(input => {
        extraData[input.dataset.col] = input.value;
    });

    userCrud('saveUpdate', id, extraData);
});
</script>
<script src="../js/disgin.js"></script>
    <script src="../controll/control.js"></script>

            <script src="../js/logger.js"></script>
</body>

</html>