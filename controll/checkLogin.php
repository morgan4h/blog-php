<?php

    include_once "../controll/db.php";
?>

<?php

@$email = $_POST['email'];
@$ps = $_POST['ps'];

?>




<?php


// functions 


function checkLogin($action) {
   $users = array();
   array_push($users,$action);
  //  var_dump($users);
   if(in_array('good',$users)) {
    header('Content-Type: application/json');
       $good = array('state' => 'successfully',
        'code' => '200', 
        'message' => 'you successfully login to your accont!',
        'username' => $_COOKIE['name'],
        'email' => $_COOKIE['email'],
        'verfy' => $_COOKIE['va']
      );
       echo json_encode($good);
   }else {
    header('Content-Type: application/json');
    $message = array('state' => 'unfortunately', 'code' => '404' ,'message' => 'you unfortunately not login, try again or contac us!');
    echo json_encode($message);
   }
}


// check the information then allow login process

$email = $_COOKIE['email'];
$ps = $_COOKIE['tokenLogin'];



$sql = "SELECT * FROM `users`";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  $callFunction;
  while($row = $result->fetch_assoc()) {
    // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    // echo $row['name'];
    if(@$email == $row['email'] && @$ps == $row['pswd']) {
      
    //   $okayMessage = "welcome your email is  " . $_COOKIE['tokenLogin'];
    $callFunction = 1;
    break;
    
      
    //   header("Location: ../public/index.html");
      // exit();
    }else {
      $notOkayMessage = "not login";
    //   echo $notOkayMessage;
    $callFunction = 0;
    
    }
  }
  if ($callFunction == 0) {
    checkLogin('bad');
  }else if ($callFunction == 1) {
    checkLogin('good');
  }else {
    echo "not exist option";
  }
} else {
  echo "0 results";
}

?>
