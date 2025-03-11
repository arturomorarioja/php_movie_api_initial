<?php

// Query parameters are removed
$url = strtok($_SERVER['REQUEST_URI'], '?');
// Remove the trailing slash if it exists
if (substr($url, strlen($url) - 1) === '/') {
    $url = substr($url, 0, strlen($url) - 1);
}
// The server path up to this folder is removed
$url = substr($url, strpos($url, basename(__DIR__)));

// The different pieces are set into an array
$urlPieces = explode('/', urldecode($url));

header('Content-Type: application/json');
header('Accept-version: v1');




require_once 'classes/Movie.php';
$movie = new Movie();

http_response_code(200);

switch ($_GET['action']) {
    case 'list':
        echo json_encode($movie->list());
        break;
    case 'search':
        $searchText = trim($_GET['search_text'] ?? '');
        if ($searchText === '') {
            reportError();
        } else {
            echo json_encode($movie->search($searchText));
        }
        break;
    case 'add':
        $name = trim($_GET['name'] ?? '');
        if ($name === '') {
            reportError();
        } else {
            http_response_code(201);
            echo json_encode($movie->add($name));
        }
        break;
    case 'edit':

        break;
    case 'delete':
        break;
    default:
        http_response_code(405);
}

function reportError()
{
    http_response_code(400);
    echo json_encode([
        'error' => 'Incorrect parameters'
    ]);
}