<?php

require_once('../../functions/helpers.php');
require_once ('../../auth/user-is-login.php');
require_once('../../functions/pdo_connection.php');


global $pdo;

if (isset($_GET['post_id']) && $_GET['post_id'] !== '') {


    $query = "SELECT * FROM `$dbName`.`posts` WHERE `id` = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$_GET['post_id']]);
    $post = $statement->fetch();

    if ($post === false) {
        redirect('dashboard/post');
    }

    $query = "DELETE FROM `$dbName`.`posts` WHERE `id` = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$_GET['post_id']]);

    // Delete Old Image

    $basePath = dirname(dirname(__DIR__));
    if (file_exists($basePath . $post->image)) {
        unlink($basePath . $post->image);
    }
}

redirect('dashboard/post');
