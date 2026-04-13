<?php 

include_once 'db.php';




// Query
$sql = "SELECT email FROM admins";
$result = $conn->query($sql);

// Check if results exist
if ($result->num_rows > 0) {
    // Loop through rows
    while ($row = $result->fetch_assoc()) {
        
        if($_COOKIE['email'] == $row['email']) {
            // echo 'you are  admin';
        }else {
           header("location: ../model/404.html ");
        }
    }
} else {
    echo "No results found";
}

// Close connection
$conn->close();
?>