<?php

require_once('../../conf.php');
require_once('../../functions/helpers.php');
require_once('../../functions/pdo_connection.php');

global $pdo;

if (!isset($_GET['post_id']) || ($_GET['post_id'] == '')) {
    redirect('dashboard/post');
}

/**
 * Get Post Data
 */
$query = "SELECT * FROM `$dbName`.`posts` WHERE `id` = ?";
$statement = $pdo->prepare($query);
$statement->execute([$_GET['post_id']]);
$post = $statement->fetch();

if ($post === false) {
    redirect('dashboard/post');
}

/**
 * Get All Categories
 */
$query = "SELECT * FROM `categories`";
$statement = $pdo->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();

/**
 * Update post
 */
if (
    isset($_POST['title']) && $_POST['title'] !== '' &&
    isset($_POST['cat_id']) && $_POST['cat_id'] !== '' &&
    isset($_POST['body']) && $_POST['body'] !== ''
) {
    /**
     * Check Cat_id is exist!
     */
    $query = "SELECT * FROM `$dbName`.`categories` WHERE `id` = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$_POST['cat_id']]);
    $category = $statement->fetch();

    if (isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
        /**
         * Check image post Mime
         */
        $imageMime = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array($imageMime, $allowMimeImage)) {
            redirect('dashboard/post');
        }

        $basePath = dirname(dirname(__DIR__));

        // Delete Old Image
        if (file_exists($basePath . $post->image)) {
            unlink($basePath . $post->image);
        }

        $image = '/assets/images/posts/' . date('Y_m_d_H_i_s') . '.' . $imageMime;
        $image_upload = move_uploaded_file($_FILES['image']['tmp_name'], $basePath . $image);

        /**
         * Check valid category & success upload image.
         * Insert post
         */
        if ($category !== false && $image_upload !== false) {

            $query = "UPDATE `$dbName`.`posts` SET title = ?, cat_id = ?, body = ?, image = ?,   `updated_at` = NOW() WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$_POST['title'], $_POST['cat_id'], $_POST['body'], $image, $_GET['post_id']]);
        }
    } else {

        if ($category !== false) {

            $query = "UPDATE `$dbName`.`posts` SET title = ?, cat_id = ?, body = ?, `updated_at` = NOW() WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$_POST['title'], $_POST['cat_id'], $_POST['body'], $_GET['post_id']]);
        }
    }

    redirect('dashboard/post');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP panel</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css'); ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css'); ?>" media="all" type="text/css">
</head>

<body>
    <section id="app">
        <!-- Top Menu -->
        <?php require_once '../layouts/top-nav.php'; ?>

        <section class="container-fluid">
            <section class="row">
                <section class="col-md-2 p-0">

                    <!-- sidebar -->
                    <?php require_once '../layouts/sidebar.php'; ?>

                </section>

                <!-- Start:: Body Content -->

                <section class="col-md-10 pt-3">

                    <form action="<?= url('dashboard/post/edit.php?post_id=' . $_GET['post_id']) ?>" method="post" enctype="multipart/form-data">
                        <section class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="title ..." value="<?= $post->title; ?>">
                        </section>
                        <section class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <img src="<?= asset($post->image)  ?>" alt="" class="mt-2" width="150" height="150">
                        </section>
                        <section class="form-group">
                            <label for="cat_id">Category</label>
                            <select class="form-control" name="cat_id" id="cat_id">
                                <?php
                                foreach ($categories as $category) { ?>

                                    <option value="<?= $category->id ?>" <?= ($category->id == $post->cat_id) ? 'selected' : '' ?>> <?= $category->name ?> </option>

                                <?php
                                } ?>
                            </select>
                        </section>
                        <section class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" name="body" id="body" rows="5" placeholder="body ..."><?= $post->body; ?></textarea>
                        </section>
                        <section class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </section>
                    </form>

                </section>

                <!-- End:: Body Content -->

            </section>
        </section>

    </section>

    <script src="<?= asset('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.min.js'); ?>"></script>
</body>

</html>