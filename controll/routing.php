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
        echo "make this working lazy man ?!";
    }else if ($addr == 'my') {
        header('Location: ../public/pages/store.html?b=my');
    }else if ($addr == 'general') {
        header('Location: ../public/pages/store.html?b=general');
    }else if ($addr == 'upload') {
        header('Location: ../controll/upload.php');
    }else if ($addr == 'profile') {
        header('Location: ../model/profile.html');
    }
    else {
        
        //   header('Location: ../public/index.html');
    }
}


if (empty($route)) {
    echo "Empty (:";
} else {
    routing($route);
}
