<?php 
include_once '../controll/lock.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content</title>
    <link rel="stylesheet" href="../public/style/index.css">
    <link rel="stylesheet" href="../public/style/content.css">
</head>

<body>
    <nav></nav>
<div class="title-header">change content page dashboard</div>
    <div class="dash">
        <h1>change links in the site</h1>
        <select name="" class="select-links">
            <option value="socailMedai">socail medai</option>
            <option value="mainVideo">main video</option>
        </select>
        <button class="links">change link</button>
    </div>
    <!-- another section for theme -->
     <div class="theme">
        <h2>change theme</h2>
        <select name="" class="select-theme">
            <option value="color">change color</option>
            <option value="themeDarkLight">change the theme dark/light</option>
            <!-- <option value="fontStyle">font style</option> -->
        </select>
        <button class="styling">change css</button>
     </div>

     <div class="res">

     </div>

    <script src="../js/content.js"></script>
    <script src="../js/disgin.js"></script>
        <script src="../controll/control.js"></script>

</body>

</html>