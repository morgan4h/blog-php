<?php
    include_once "../model/sing.html"; 
    include_once "../controll/db.php";
?>

<?php
$message = "";
$messageType = ""; // Used to pass 'success' or 'error' to JS

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize basic inputs by trimming spaces
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $ps = $_POST['ps'] ?? '';

    // Validate inputs
    if (empty($name) || empty($email) || empty($ps)) {
        $message = "All fields are required!";
        $messageType = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Keeps bad email formats out
        $message = "Invalid email format!";
        $messageType = "error";
    } else {
        // Hash the password securely
        $hashed_password = password_hash($ps, PASSWORD_DEFAULT);

        // Prepared Statement completely blocks SQL Injection
        $stmt = $conn->prepare("INSERT INTO `users` (`id`, `email`, `pswd`, `name`, `verfy`) VALUES (NULL, ?, ?, ?, 'no')");
        $stmt->bind_param("sss", $email, $hashed_password, $name);

        if ($stmt->execute()) {
            header('Location: login.php?signup=success');
            exit();
        } else {
            $message = "Email is already registered.";
            $messageType = "error";
        }
        $stmt->close();
    }
}
?>

<script>
  let myTitle = document.querySelector("h2");
  if (myTitle) {
      // htmlspecialchars prevents XSS payloads from executing inside the JS string
      let msg = '<?php echo htmlspecialchars($message, ENT_QUOTES, "UTF-8"); ?>';
      let type = '<?php echo $messageType; ?>';
      
      if (msg !== '') {
          myTitle.textContent = msg;
          myTitle.style.color = (type === 'error') ? 'red' : 'green';
      }
  }
</script>