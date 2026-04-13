<?php

include_once "../controll/db.php";
include_once "../controll/lock.php";

$sql = "SELECT * FROM users";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["email"]. " " . $row["ps"]. "<br>";
  }
} else {
  echo "0 results";
}