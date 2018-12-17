<?php
require_once __DIR__ . 'config.php';
if (empty($_SESSION['user_id'])) {
    header("Location: /login.php");
}

if (!empty($_POST['comment'])) {
/*Вставка комментариев в БД*/
    $stmt = $pdo->prepare("INSERT INTO comments (`user_id`, `comment`) VALUES (:user_id, :comment)");
    $stmt->execute(array('user_id' => $_SESSION['user_id'], 'comment' => $_POST['comment']));
}

$stmt = $pdo->prepare("SELECT `user_id`, `comment`, `created_add` FROM `comments` ORDER BY `id` DESC");
$stmt->execute();
$comments = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comments Page</title>
    <style>
        #comments-header {
            text-align: center;
        }

        #comments-form {
            border: 1px dotted black;
            width: 50%;
            padding-left: 20px;
        }

        #comments-form textarea {
            width: 70px;
            min-height: 50%;
            padding-left: 20px;
            margin-top: 20px;
        }

        #comments-panel {
            border: 1px dashed black;
            width: 50%;
            padding-left: 20px;
            margin-top: 20px;
        }

        .comment-date {
            font-style: italic
        }
    </style>
</head>
<body>
<div id="comments-header">
    <h1>Comments Page</h1>
</div>
<div id="comments-form">
    <h3>Please dd your comment</h3>
    <form action="" method="post">
        <div>
            <label>Comment</label>
            <div>
                <textarea name="comment"></textarea>
            </div>
        </div>
        <div>
            <br>
            <input type="submit" name="submit" value="Save">
        </div>
    </form>
</div>
<div id="comments-panel">
    <h3>Comments:</h3>
    <?php foreach ($comments as $comment) : ?>
        <p>
            <?php if ($comment['user_id'] == $_SESSION['user_id']) echo 'style= "font-weight: bold;"'; ?>
            <?= $comment['comment']; ?>
            <span class="comment-date">
            (<?= $comment['created']; ?>)
        </span>
        </p>
    <?php endforeach; ?>

</div>
</body>
</html>
