<?php

$route = $_GET['route'];

// function for routing

function routing($addr)
{
    echo $addr;
    if ($addr == 'lp') {
        header('Location: https://youtube.com');
    } else if ($addr == 'courses') {
        header('Location:  ../public/pages/course.html');
    } else if ($addr == 'community') {
        header('Location: ../public/pages/community.html');
    } else if ($addr == 'about') {
        header('Location: ../public/pages/about.html');
    } else if ($addr == 'blog') {
        header('Location: ../public/pages/sphone.html');
    } else if ($addr == 'email') {
        $to = "example@example.com";  // The recipient's email address
        $subject = "Your Subject Here"; // The subject of the email
        $body = "This is the body of the email."; // The email body

        // Encode the variables to ensure proper formatting in the URL
        $to = urlencode($to);
        $subject = urlencode($subject);
        $body = urlencode($body);

        // Create the mailto link
        $mailToLink = "mailto:$to?subject=$subject&body=$body";

        // Redirect the user to the mailto link
        header("Location: $mailToLink");
        exit();
    } else {
        //   header('Location: ../public/index.html');
    }
}


if (empty($route)) {
    echo "Empty (:";
} else {
    routing($route);
}
