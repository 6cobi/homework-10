<?php
require_once "../app/models/Model.php";
require_once "../app/models/User.php";
require_once "../app/controllers/UserController.php";
require_once "../app/models/Post.php";
require_once "../app/controllers/PostController.php";

// Set our environment variables
$env = parse_ini_file('../.env');
define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);

use app\controllers\UserController;
use app\controllers\PostController;

// Get URI without query strings
$uri = strtok($_SERVER["REQUEST_URI"], '?');

// Get URI pieces
$uriArray = explode("/", $uri);
// Example:
// 0 = ""
// 1 = "api"
// 2 = "users" or "posts"
// 3 = "id"

// Handle API endpoints for users
if ($uriArray[1] === 'api' && $uriArray[2] === 'users') {
    $userController = new UserController();

    // Get all users or a single user
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;

        if ($id) {
            $userController->getUserByID($id);
        } else {
            $userController->getAllUsers();
        }
    }

    // Save user
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController->saveUser();
    }

    // Update user
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        $userController->updateUser($id);
    }

    // Delete user
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        $userController->deleteUser($id);
    }
}

// Handle API endpoints for posts
if ($uriArray[1] === 'api' && $uriArray[2] === 'posts') {
    $postController = new PostController();

    // Get all posts or a single post
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;

        if ($id) {
            $postController->getPostByID($id);
        } else {
            $postController->getAllPosts();
        }
    }

    // Save post
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postController->savePost();
    }

    // Update post
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        $postController->updatePost($id);
    }

    // Delete post
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        $postController->deletePost($id);
    }
}

// Handle views for users
if ($uri === '/users-add' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersAddView();
}

if ($uriArray[1] === 'users-update' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersUpdateView();
}

if ($uriArray[1] === 'users-delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersDeleteView();
}

if ($uriArray[1] === '' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersView();
}

// Handle views for posts
if ($uri === '/posts-add' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsAddView();
}

if ($uriArray[1] === 'posts-update' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsUpdateView();
}

if ($uriArray[1] === 'posts-delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsDeleteView();
}

if ($uriArray[1] === 'posts-view' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsView();
}

// Default to not found
include '../public/assets/views/notFound.html';
exit();
