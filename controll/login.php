<?php
    include_once "../model/login.html";
    include_once "../controll/db.php";
?>

<?php

$email = $_POST['email'];
$ps = $_POST['ps'];

?>




<?php

// check the information then allow login process

$email = $_POST['email'];
$ps = $_POST['ps'];


$sql = "SELECT * FROM `users`";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    // echo $row['name'];
    if($email == $row['email'] && $ps == $row['pswd']) {
      echo "welcome";
    }else {
      echo "somethign went wrong";
    }
  }
} else {
  echo "0 results";
}



?>