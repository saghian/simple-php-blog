<?php
require_once('../../functions/helpers.php');
require_once ('../../auth/user-is-login.php');
require_once('../../functions/pdo_connection.php');



if (isset($_GET['cat_id']) && $_GET['cat_id'] !== '') {

    global $pdo;

    $query = "DELETE FROM `toplearn-blog`.`categories` WHERE `id` = ?";

    $statement = $pdo->prepare($query);

    $statement->execute([$_GET['cat_id']]);
}

redirect('dashboard/category');
