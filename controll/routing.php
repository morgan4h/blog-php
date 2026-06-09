<?php

// 1. Server Hard Drive Path (For file_exists checking)
define('BASE_PATH', dirname(__DIR__)); // Resolves to absolute path of .../s1/blog-php

// 2. Safe Browser URL Path Resolution (For header redirects)
$requestUri = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$controllFolder = dirname($requestUri);
$projectFolder = dirname($controllFolder);

define('BASE_URL', $projectFolder === '/' ? '' : $projectFolder);

// Grab the key from the URL query string
$route = !empty($_GET) ? key($_GET) : '';

/**
 * Checks if a file exists on the server, then redirects.
 */
function fetch_page($relativePath)
{
    $absolutePath = BASE_PATH . $relativePath;

    if (file_exists($absolutePath)) {
        header("Location: " . BASE_URL . $relativePath);
        exit;
    } else {
        die("This page does not exist. Checked path: " . $absolutePath);
    }
}

// Function for routing logic
function routing($addr)
{
    switch ($addr) {
        case 'about':
            fetch_page('/public/pages/about.html');
            break;

        case 'blog':
            fetch_page('/public/pages/sphone.html');
            break;

        case 'community':
            fetch_page('/public/pages/community.html');
            break;

        case 'courses':
            fetch_page('/public/pages/course.html');
            break;

        case 'my':
            fetch_page('/public/pages/store.html');
            header('Location: ' . BASE_URL . '/public/pages/store.html?b=my');
            exit;

        case 'general':
            fetch_page('/public/pages/store.html');
            header('Location: ' . BASE_URL . '/public/pages/store.html?b=general');
            exit;

        case 'upload':
            fetch_page('/controll/upload.php');
            break;

        case 'profile':
            fetch_page('/model/profile.html');
            break;

        case 'lp':
            header('Location: https://youtube.com');
            exit;

        case 'email':
            echo "Keep grinding! Get this email working!";
            break;
        case 'dash':
            header('Location: ../dash/index.php');
            break;
        default:
            fetch_page('/public/index.html');
            break;
    }
}

// Execution
if (empty($route)) {
    echo "Empty (:";
} else {
    routing($route);
}
