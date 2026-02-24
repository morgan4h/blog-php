<?php
    include_once "../model/login.html";
    include_once "../controll/db.php";
    include_once "../controll/global.php"
?>

<?php

@$email = $_POST['email'];
@$ps = $_POST['ps'];

?>




<?php

// check the information then allow login process

$email = @$_POST['email'];
$ps = @$_POST['ps'];


$sql = "SELECT * FROM `users`";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    // echo $row['name'];
    if(@$email == $row['email'] && @$ps == $row['pswd']) {
      setcookie("catchingLogin", $email, time() + 3600); // Expires in 1 hour
      $okayMessage = "welcome your email is  " . $_COOKIE['catchingLogin'];
    }else {
      $notOkayMessage = "somethign went wrong";
    }
  }
} else {
  echo "0 results";
}



?>

<script>
  let myTitle = document.querySelector("h2")
  myTitle.textContent = '<?php echo $okayMessage OR $notOkayMessage ?>'
  if (myTitle.textContent == 1) {
     myTitle.textContent = '<?php echo $okayMessage ?>'
  }else {
    console.log('bad')
  }
</script>