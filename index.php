<?php
session_start();
require_once('functions/helpers.php');
require_once('functions/pdo_connection.php');


$query = "SELECT * FROM `categories`";
$statement = $pdo->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();

/**
 * Get All Enable Posts
 */
$query = "SELECT `$dbName`.`posts`.* ,`$dbName`.`categories`.`name` AS `category_name` FROM  `$dbName`.`posts` LEFT JOIN `$dbName`.`categories` ON `$dbName`.`posts`.`cat_id` = `$dbName`.`categories`.`id` WHERE status = 1";
$statement = $pdo->prepare($query);
$statement->execute();
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
            <!-- Example row of columns -->
            <section class="row">
                <?php
                foreach ($posts as $post) {
                ?>
                    <section class="col-md-4">
                        <section class="mb-2 overflow-hidden" style="max-height: 15rem;">
                            <img class="img-fluid" src="<?= asset($post->image) ?>" alt="" width="300" height="200">
                        </section>
                        <h2 class="h5 text-truncate"><?= $post->title ?></h2>
                        <p><?= substr($post->body, 0 , 100) . '...' ?></p>
                        <p><a class="btn btn-primary" href="<?= url('single.php?post_id=' . $post->id) ?>" role="button">View details »</a></p>
                    </section>

                <?php } ?>

            </section>
        </section>

    </section>
    <script src="<?= asset('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.min.js'); ?>"></script>
</body>

</html>