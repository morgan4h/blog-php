<?php
include_once '../model/uploade.html';
?>
<style>
  body {
    color: red !important; 
    margin: 0;
    padding: 0;
  }
</style>

<?php


include_once '../controll/db.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$type = $_POST['type'];
$picture = $_POST['picture'];
$des = $_POST['description'];
$version = $_POST['version'];
$size = $_POST['size'];
$download = $_POST['download'];
if (empty($name) || empty($type) || empty($picture) || empty($des) || empty($version) || empty($size) || empty($download)) {
  $msg = "invalid data or method request";
} else {

  $sql = "INSERT INTO `app` (`id`, `name`, `type`, `picture_app`, `category`, `description`, `version`, `size`, `download_link`) VALUES (NULL, '$name', '$type', '$picture', '$type', '$des', '$version', '$size', '$download')";

  if ($conn->query($sql) === TRUE) {
    $msg = "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<script>
  document.querySelector('.msg').textContent = '<?php echo $msg; ?>'
</script>


