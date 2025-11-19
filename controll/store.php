<?php 

include_once 'db.php';

$sql = "SELECT * FROM `app`";
$result = mysqli_query($conn, $sql);
$myApi = array(
    'name' => "value",
);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    // echo  $row["name"] . " => ". $row['picture_app'] . "<br>";
     $myApi[] = $row;
  }
} else {
  echo "0 results";
}

header('Content-Type: application/json');
echo json_encode($myApi, JSON_PRETTY_PRINT);


mysqli_close($conn);