<?php

// Show PHP errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

$filename = 'content.json';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo "<pre>";

    // 1. Check if file exists
    if (!file_exists($filename)) {
        die("ERROR: content.json file does not exist");
    }

    // 2. Read JSON file
    $jsonData = file_get_contents($filename);

    if ($jsonData === false) {
        die("ERROR: Cannot read JSON file");
    }

    echo "Original JSON:\n";
    print_r($jsonData);

    // 3. Decode JSON
    $data = json_decode($jsonData, true);

    // Check JSON errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("JSON Decode Error: " . json_last_error_msg());
    }

    echo "\nDecoded Array:\n";
    print_r($data);

    // 4. Update values
    $data['pagename'] = "Home";

    // Check POST value
    if (isset($_POST['link'])) {
        $data['change'] = $_POST['link'];
    } else {
        die("ERROR: link input not received");
    }

    echo "\nUpdated Array:\n";
    print_r($data);

    // 5. Convert back to JSON
    $newJsonData = json_encode($data, JSON_PRETTY_PRINT);

    if ($newJsonData === false) {
        die("JSON Encode Error: " . json_last_error_msg());
    }

    echo "\nNew JSON:\n";
    print_r($newJsonData);

    // 6. Save file
    $result = file_put_contents($filename, $newJsonData);

    if ($result === false) {
        die("ERROR: Cannot write to JSON file");
    }

    echo "\nJSON file updated successfully!";
    echo "</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>content</title>
    <link rel="stylesheet" href="../dash/css/content.css">
</head>
<body>

<form action="content.php" method="post">

    <h1>choose the color theme of your website</h1>

    <input type="color" />

    <button type="button">color</button>

    <hr>

    <h2>change the link of the main video on the home page</h2>

    <input name="link" type="text" class="linkVideo"/>

    <button type="submit" class="upload">upload</button>

</form>

</body>
</html>