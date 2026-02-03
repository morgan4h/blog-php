<?php
    include_once "../model/sing.html";
    include_once "../controll/db.php";
?>



<?php

// let send the data to the database

$name = $_POST['name'];
$email = $_POST['email'];
$ps = $_POST['ps'];

// after you get the data send it 
if(empty($name)) {
    // echo "sorry";
}else {
$sql = "INSERT INTO `users` (`id`, `email`, `pswd`, `name`, `verfy`) VALUES (NULL, '$email', '$ps', '$name', 'no')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
   
}

?>

