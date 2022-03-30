<?php
session_start();
require_once('functions/helpers.php');
require_once('functions/pdo_connection.php');

global $pdo;

$query1 = "SELECT * FROM `categories`";
$statement = $pdo->prepare($query1);
$statement->execute();
$categories = $statement->fetchAll();

$query2 = "SELECT * FROM `$dbName`.`categories` WHERE `id` = ?";
$statement = $pdo->prepare($query2);
$statement->execute([$_GET['cat_id']]);
$catItem = $statement->fetch();

$query3 = "SELECT * FROM `$dbName`.`posts` WHERE `cat_id` = ?";
$statement = $pdo->prepare($query3);
$statement->execute([$_GET['cat_id']]);
$posts = $statement->fetchAll();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP tutorial</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css'); ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css'); ?>" media="all" type="text/css">
</head>

<body>
    <section id="app">
        <?php require_once "layouts/site/nav-bar.php" ?>

        <section class="container my-5">
            <?php if ($catItem !== false) { ?>
                <section class="row">
                    <section class="col-12">
                        <h1><?= $category->name ?></h1>
                        <hr>
                    </section>
                </section>
                <section class="row">
                    <?php foreach ($posts as $postItem) { ?>

                        <section class="col-md-4">
                            <section class="mb-2 overflow-hidden" style="max-height: 15rem;"><img class="img-fluid" src="" alt=""></section>
                            <h2 class="h5 text-truncate"><?= $postItem->title ?></h2>
                            <p><?= $postItem->body ?></p>
                            <p><a class="btn btn-primary" href="" role="button">View details »</a></p>
                        </section>
                    <?php } ?>
                </section>
            <?php } else { ?>
                <section class="row">
                    <section class="col-12">
                        <h1>Category not found</h1>
                    </section>
                </section>
            <?php }
            ?>

        </section>
    </section>

    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>