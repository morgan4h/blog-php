<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize message
$msg = "";

// Include database config
include_once '../controll/db.php';
include_once '../controll/lock.php';

// Only process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        $msg = "❌ Connection failed: " . $conn->connect_error;
    } else {

        // Get POST values safely
        $name        = trim($_POST['name'] ?? '');
        $type        = trim($_POST['type'] ?? '');
        $picture     = trim($_POST['picture'] ?? '');
        $category    = trim($_POST['category'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $version     = trim($_POST['version'] ?? '');
        $size        = trim($_POST['size'] ?? '');
        $download    = trim($_POST['download'] ?? '');

        // Validate input
        if (
            empty($name) || empty($type) || empty($picture) ||
            empty($category) || empty($description) || empty($version) ||
            empty($size) || empty($download)
        ) {
            $msg = "⚠️ Please fill in all fields!";
        } else {

            // Prepare SQL statement
            $stmt = $conn->prepare("
                INSERT INTO `app` 
                (`name`, `type`, `picture_app`, `category`, `description`, `version`, `size`, `download_link`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            if ($stmt === false) {
                $msg = "❌ Prepare failed: " . $conn->error;
            } else {

                // FIXED: The first argument must be the types string "ssssssss" (8 strings)
                // Removed the 'null' argument you had previously.
                $stmt->bind_param(
                    "ssssssss", 
                    $name,
                    $type,
                    $picture,
                    $category,
                    $description,
                    $version,
                    $size,
                    $download
                );

                // Execute
                if ($stmt->execute()) {
                    $msg = "✅ App added successfully!";
                    // Optional: Clear POST data so form empties on success
                    $_POST = array(); 
                } else {
                    $msg = "❌ Insert failed: " . $stmt->error;
                }

                $stmt->close();
            }
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload App</title>
<link rel="stylesheet" href="../public/style/index.css">
<link rel="stylesheet" href="../public/style/upload.css">
</head>
<body>
    <nav></nav>
<a href="../dash/">dash</a>
<div class="container">
    <h2>Upload New App</h2>

    <?php if ($msg): ?>
        <div class="msg <?php echo strpos($msg, 'successfully') !== false ? 'success' : ''; ?>">
            <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="App Name"
               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>

        <input type="text" name="type" placeholder="Type (mobile / desktop)"
               value="<?php echo htmlspecialchars($_POST['type'] ?? ''); ?>" required>

        <input type="text" name="picture" placeholder="Picture URL"
               value="<?php echo htmlspecialchars($_POST['picture'] ?? ''); ?>" required>

        <input type="text" name="category" placeholder="Category"
               value="<?php echo htmlspecialchars($_POST['category'] ?? ''); ?>" required>

        <textarea name="description" placeholder="Description" required><?php
            echo htmlspecialchars($_POST['description'] ?? '');
        ?></textarea>

        <input type="text" name="version" placeholder="Version"
               value="<?php echo htmlspecialchars($_POST['version'] ?? ''); ?>" required>

        <input type="text" name="size" placeholder="Size (e.g., 25MB)"
               value="<?php echo htmlspecialchars($_POST['size'] ?? ''); ?>" required>

        <input type="text" name="download" placeholder="Download Link"
               value="<?php echo htmlspecialchars($_POST['download'] ?? ''); ?>" required>

        <button type="submit">Upload App</button>
    </form>
</div>
<script src="../js/disgin.js"></script>
</body>
</html>
