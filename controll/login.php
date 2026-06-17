<?php
    include_once "../model/login.html";
    include_once "../controll/db.php";
    include_once "../controll/global.php";
?>

<?php
$feedbackMessage = "";
$loginSuccess = false;

// Check if user arrived here freshly after a successful signup
if (isset($_GET['signup']) && $_GET['signup'] === 'success') {
    $feedbackMessage = "Account created successfully! Please log in.";
    $loginSuccess = true; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $ps = $_POST['ps'] ?? '';

    if (!empty($email) && !empty($ps)) {
        // Prepared statement handles SQL Injection safety
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Password verification
            if (password_verify($ps, $row['pswd'])) {
                
                // Set cookies safely
                setcookie("tokenLogin", $row['pswd'], time() + 3600, '/'); 
                setcookie("email", $email, time() + 3600, '/'); 
                setcookie("name", $row['name'], time() + 3600, '/'); 
                setcookie("va", $row['verfy'], time() + 3600, '/'); 
                
                $feedbackMessage = "Welcome back, " . $row['name'] . "!";
                $loginSuccess = true;
                
                header("Location: ../public/index.html");
                exit();
            } else {
                $feedbackMessage = "Incorrect email or password.";
            }
        } else {
            $feedbackMessage = "Incorrect email or password.";
        }
        $stmt->close();
    } else {
        $feedbackMessage = "Please enter both your email and password.";
    }
}
?>

<script>
  let myTitle = document.querySelector("h2");
  if (myTitle) {
      // htmlspecialchars applied here eliminates XSS injection threats
      let msg = '<?php echo htmlspecialchars($feedbackMessage, ENT_QUOTES, "UTF-8"); ?>';
      let isSuccess = '<?php echo $loginSuccess ? "1" : "0"; ?>';
      
      if (msg !== '') {
          myTitle.textContent = msg;
          if (isSuccess === "1") {
              myTitle.style.color = 'green';
          } else {
              myTitle.style.color = 'red';
              console.log('bad login attempt');
          }
      }
  }
</script>