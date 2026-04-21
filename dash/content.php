<?php
$filename = 'content.json';

// 1. Read the file
$jsonData = file_get_contents($filename);

// 2. Decode JSON into a PHP associative array
$data = json_decode($jsonData, true);

// 3. Update the values
$data['pagename'] = "Home";
$data['change'] = "https://www.youtube.com/embed/vuhdNaJ4cko";

// 4. Encode back to JSON
// Use JSON_PRETTY_PRINT to keep the file readable for humans
$newJsonData = json_encode($data, JSON_PRETTY_PRINT);

// 5. Save the updated content back to the file
file_put_contents($filename, $newJsonData);

echo "JSON file updated successfully!";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>content</title>
</head>

<body>

    <h1>choose the color them of your website</h1>
    <input type="color">
    <button>color</button>
    <hr>
    <h2>change the link of the main video on the home page</h2>
    <input type="text" class="linkVideo">
    <button class="upload">upload</button>
</body>
</html>