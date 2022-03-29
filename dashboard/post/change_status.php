<?php

require_once('../../conf.php');
require_once('../../functions/helpers.php');
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

    $query = "UPDATE `$dbName`.`posts` SET status = ?, `updated_at` = NOW() WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([ (!$post->status), $_GET['post_id']]);

}

redirect('dashboard/post');