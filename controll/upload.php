<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize message
$msg = "";

// Include database config
include_once '../controll/db.php';

// Only process POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        $msg = "Connection failed: " . $conn->connect_error;
    } else {

        // Get POST values safely
        $name = trim($_POST['name'] ?? '');
        $type = trim($_POST['type'] ?? '');
        $picture = trim($_POST['picture'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $version = trim($_POST['version'] ?? '');
        $size = trim($_POST['size'] ?? '');
        $download = trim($_POST['download'] ?? '');

        // Validate
        if (!$name || !$type || !$picture || !$category || !$description || !$version || !$size || !$download) {
            $msg = "⚠️ Please fill in all fields!";
        } else {
            // Prepared statement
            $stmt = $conn->prepare("INSERT INTO app (name,type,picture_app,category,description,version,size,download_link) VALUES ('$name','$type','$picture','$category','$description','$version','$size','$download')");
            if ($stmt === false) {
                $msg = "Prepare failed: " . $conn->error;
            } else {
                $stmt->bind_param($name, $type, $picture, $category, $description, $version, $size, $download);
                if ($stmt->execute()) {
                    $msg = "✅ App added successfully!";
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
<style>
    body { font-family: Arial; background:#f4f4f4; display:flex; justify-content:center; padding-top:50px;}
    .container { background:#fff; padding:20px 30px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1); width:400px;}
    h2 { text-align:center; margin-bottom:20px; color:#333;}
    input[type=text], textarea { width:100%; padding:8px 10px; margin:6px 0 12px 0; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;}
    textarea { resize:vertical; height:60px; }
    button { width:100%; padding:10px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; font-size:16px;}
    button:hover { background:#218838; }
    .msg { margin-bottom:15px; text-align:center; font-weight:bold; color:red; }
    .msg.success { color:green; }
</style>
</head>
<body>
<div class="container">
    <h2>Upload New App</h2>
    <?php if($msg): ?>
        <div class="msg <?php echo strpos($msg,'successfully') !== false ? 'success' : ''; ?>">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="App Name" value="<?php echo htmlspecialchars($_POST['name'] ?? '') ?>" required>
        <input type="text" name="type" placeholder="Type (mobile/desktop)" value="<?php echo htmlspecialchars($_POST['type'] ?? '') ?>" required>
        <input type="text" name="picture" placeholder="Picture URL" value="<?php echo htmlspecialchars($_POST['picture'] ?? '') ?>" required>
        <input type="text" name="category" placeholder="Category" value="<?php echo htmlspecialchars($_POST['category'] ?? '') ?>" required>
        <textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        <input type="text" name="version" placeholder="Version" value="<?php echo htmlspecialchars($_POST['version'] ?? '') ?>" required>
        <input type="text" name="size" placeholder="Size (e.g., 25MB)" value="<?php echo htmlspecialchars($_POST['size'] ?? '') ?>" required>
        <input type="text" name="download" placeholder="Download Link" value="<?php echo htmlspecialchars($_POST['download'] ?? '') ?>" required>
        <button type="submit">Upload App</button>
    </form>
</div>
</body>
</html>
