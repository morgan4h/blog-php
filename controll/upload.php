<?php

    
include_once '../controll/db.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `app` (`id`, `name`, `type`, `picture_app`, `category`, `description`, `version`, `size`, `download_link`) VALUES (NULL, 'app1', 'mytools', 'picture.com', 'games', 'this is simple game', '1.1.1', '1mb', 'https://download.com/app1')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


<?php

include_once '../model/nav.html';
?>

<?php
    include_once '../model/uploade.html';
?>

<?php
include_once '../model/footer.html';

?>
