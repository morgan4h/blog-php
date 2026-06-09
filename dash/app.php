<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../controll/db.php";
include_once "../controll/lock.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            --accent-bg: #e0f2fe;
            --accent-text: #0369a1;
        }

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
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
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .nav h2 {
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

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
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .modal-box h2 {
            font-size: 1.3rem;
            color: var(--bg-sidebar);
            margin-bottom: 10px;
        }

        .modal-divider {
            border: 0;
            height: 1px;
            background: var(--border-color);
            margin-bottom: 20px;
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
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: var(--primary);
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .modal-actions .btn {
            border: none;
            padding: 12px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 8px;
            flex: 1;
        }

        .btn-cancel {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-cancel:hover {
            background: #cbd5e1;
        }

        .btn-save {
            background: var(--primary);
            color: white;
        }

        .btn-save:hover {
            background: var(--primary-hover);
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
            transition: all .2s ease;
            cursor: default;
            margin: 0;
        }

        .sidebar p:hover{
            background: var(--sidebar-hover);
            color: #fff;
            padding-left: 28px;
        }

        .content{
            margin-left: 240px;
            margin-top: 60px;
            padding: 40px;
        }

        .app-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .app-box{
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .app-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        }

        .app-info h3 {
            font-size: 1.1rem;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .app-info span {
            font-size: 0.85rem;
            color: #64748b;
        }

        .app-box img{
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin: 15px 0;
            border: 1px solid var(--border-color);
        }

        .type{
            align-self: flex-start;
            background: var(--accent-bg);
            color: var(--accent-text);
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn{
            flex: 1;
            text-align: center;
            padding: 10px 16px;
            color: #fff;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
            cursor: default;
            user-select: none;
        }

        .update{ background: var(--primary); }
        .update:hover{ background: var(--primary-hover); }
        .delete{ background: var(--danger); }
        .delete:hover{ background: var(--danger-hover); }

        .empty-state {
            grid-column: 1 / -1;
            background: #fff;
            padding: 40px;
            text-align: center;
            border-radius: 12px;
            border: 1px dashed #cbd5e1;
            color: #64748b;
        }
    </style>
</head>
<body>

<nav></nav>



<div class="content">
    <div class="app-grid">
    <?php
    $sql = "SELECT * FROM app";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="app-box">';
            echo '<div class="app-info">';
            echo '<h3>' . htmlspecialchars($row["name"] ?? 'Unnamed') . '</h3>';
            echo '<span>' . htmlspecialchars($row["id"]) . '</span>';
            echo '</div>';

            $pic = !empty($row['picture_app']) ? $row['picture_app'] : 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=500';
            echo '<img src="' . htmlspecialchars($pic) . '" alt="App Preview">';

            if(isset($row['type'])) {
                echo '<div class="type">' . htmlspecialchars($row['type']) . '</div>';
            }

            echo '<div class="actions">';
            echo '<p class="btn update">Update</p>';
            echo '<p class="btn delete">Delete</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="empty-state">No applications found.</div>';
    }
    ?>
    </div>
</div>

<div id="updateModal" class="modal-overlay">
    <div class="modal-box">
        <h2>Update Application</h2>
        <hr class="modal-divider">
        
        <form id="updateForm">
            <input type="hidden" id="editAppId">

            <div id="dynamicInputContainer"></div>

            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" id="closeModalBtn">Cancel</button>
                <button type="submit" class="btn btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/app.js"></script>
<script src="../js/disgin.js"></script>
    <script src="../controll/control.js"></script>

</body>
</html>