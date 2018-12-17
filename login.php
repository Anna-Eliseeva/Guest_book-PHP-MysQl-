<?php
require_once __DIR__ . 'config.php';
if (!empty($_SESSION['user_id'])) {
    header("Location: /index.php");
}

/*Здесь будут отображаться ошибки валидации*/
$errors = [];
$isRegistered = 0;
if (!empty($_GET['registration'])) {
    $isRegistered = 1;
}
if (!empty($_POST)) {
    if (empty($_POST['user_name'])) {
        $errors[] = 'Please enter User Name';
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Please enter password';
    }
    if (empty($errors)) {
        $stmt = $dbConn->prepare('SELECT id FROM `users` WHERE (username = :username OR email = :username) AND password = :password');
        $stmt->execute(array('username' => $_POST['user_name'], 'password' => sha1($_POST['password'] . SALT)));
        $id = $stmt->fetchColumn();
        if (!empty($id)) {
            $_SESSION['user_id'] = $id;
            die('Вы успешно авторизованы');
        } else {
            $errors[] = 'Please enter valid credentails';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My guest book</title>
</head>
<body>
<?php if (!empty($isRegistered)) :?>
    <h2>Вы успешно зарегистрировались! Используйте свои данные для входа на сайт</h2>
<?php endif; ?>


<h1>Log in Page</h1>
<div>
    <form action="" method="post">
        <div style="color: red">
            <?php foreach ($errors as $error) : ?>
                <p><?= $error; ?></p>
            <?php endforeach; ?>
        </div>
        <div>
            <label>User Name/ Email:</label>
            <div>
                <input type="text" name="user_name" required=""
                       value="<?= (!empty($_POST['user_name']) ? $_POST['user_name'] : ''); ?>"/>
            </div>
        </div>
        <div>
            <label>Password:</label>
            <div>
                <input type="password" name="password" required="" value=""/>
            </div>
        </div>
        <div>
            <br/>
            <input type="submit" name="submit" value="logIn">
        </div>
    </form>
</body>
</html>
