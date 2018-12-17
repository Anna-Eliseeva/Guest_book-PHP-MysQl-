<?php

require_once __DIR__ . '/config.php';

if (!empty($_SESSION['user_id'])) {
    header("Location: /index.php");
}

/*Создаем массив в котором будут содержаться ошибки валидации формы*/
$errors = [];
if (!empty($_POST['user_name'])) {
    $errors[] = 'Please enter User Name';
}

if (!empty($_POST['email'])) {
    $errors[] = 'Please enter email';
}

if (!empty($_POST['first_name'])) {
    $errors[] = 'Please enter First Name';
}

if (!empty($_POST['last_name'])) {
    $errors[] = 'Please enter Last Name';
}

if (!empty($_POST['password'])) {
    $errors[] = 'Please enter Password';
}

if (!empty($_POST['confirm_password'])) {
    $errors[] = 'Please enter Confirm Password';
}

if (strlen($_POST['user_name']) > 100) {
    $errors[] = 'User Name s too long. Max length is 100 characters';
}

if (strlen($_POST['first_name']) > 80) {
    $errors[] = 'First Name s too long. Max length is 80 characters';
}

if (strlen($_POST['last_name']) > 80) {
    $errors[] = 'Last Name s too long. Max length is 80 characters';
}

if (strlen($_POST['password']) < 6) {
    $errors[] = 'Password s too long. Min length is 6 characters';
}

if ($_POST['password'] !== $_POST['confirm_password']) {
    $errors[] = 'Your confirm password is not match password';
}

/*Добавление пользователя в БД*/
if (empty($errors)) {
    $query = '
        INSERT INTO users (`username`, `email`, `password`, `first_name`, `last_name`) 
        VALUES (:username, :email, :password, :first_name, :last_name)';
    $stmt = $dbConn->prepare($query);
    $stmt->execute([
        'username' => $_POST['user_name'],
        'email' => $_POST['email'],
        'password' => sha1($_POST['password'], SALT),
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name']
    ]);
}

$user = !empty($_POST['user_name']) ? $_POST['user_name'] : '';
$email = !empty($_POST['email']) ? $_POST['email'] : '';
$firstName = !empty($_POST['first_name']) ? $_POST['first_name'] : '';
$lastName = !empty($_POST['last_name']) ? $_POST['last_name'] : '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
</head>
<body>
<h1>Reistration Page</h1>
<div>
    <form action="" method="post">
        <div style="color:red">
            <?php foreach ($errors as $error) : ?>
                <p><?= $error; ?> </p>
            <?php endforeach; ?>
        </div>
        <div>
            <label for="user_name">UserName:</label>
            <div>
                <input type="text" id="user_name" name="user_name" required="" value="<?= $user; ?>">
            </div>
        </div>
        <div>
            <label for="email">Email:</label>
            <div>
                <input type="email" id="email" name="email" required="" value="<?= $email; ?>">
            </div>
        </div>
        <div>
            <label for="first_name">First Name:</label>
            <div>
                <input type="text" id="first_name" name="first_name" required="" value="<?= $firstName; ?>">
            </div>
        </div>
        <div>
            <label for="last_name">Last Name:</label>
            <div>
                <input type="text" id="last_name" name="last_name" required="" value="<?= $lastName; ?>">
            </div>
        </div>
        <div>
            <label for="password">Password:</label>
            <div>
                <input type="password" id="password" name="password" required="" value="">
            </div>
        </div>
        <div>
            <label for="confirm_password">Confirm Password</label>
            <div>
                <input type="password" id="confirm_password" name="confirm_password" required="" value="">
            </div>
        </div>
        <div>
            <br/>
            <input type="submit" name="submit" value="register">
        </div>
    </form>
</div>
</body>
</html>
