<?php

include "../model/model.php";

if (isset($_POST[submit])) {
    $name = trim(strip_tags($_POST[name]));
    $login = trim(strip_tags($_POST[login]));

    $user = getAll($connect, 'users');

    if (strtolower($login) == 'admin') {
        exit("Логин админа нельзя зарегистрировать!");
    }

    foreach ($user as $item) {
        if ($login == $item[login]) {
            exit("Такой уже логин есть!");
        }
    }

    if (filter_var($_POST[email], FILTER_VALIDATE_EMAIL)) {
        $email = trim(strip_tags($_POST[email]));
    }
    $pass = trim(strip_tags($_POST[pass]));

    newUser($connect, $name, $login, $email, $pass);

    $message = "Вы зарегистрированы!";

}

if (isset($_POST[enter])) {
    $login = trim(strip_tags($_POST[login]));
    $pass = trim(strip_tags($_POST[pass]));

    $user = getAll($connect, 'users');
    foreach ($user as $item) {
        if ($login == $item[login] and $pass == $item[password]) {
            $message = "Вы вошли!";
            $_SESSION[login] = $login;
            $_SESSION[pass] = $pass;
            $_SESSION[id] = $item[id];
            header("Location: index.php");
        }
        else {
            $message = "Не правильно ввели данные! ";
        }
    }
}

if ($_GET[action] == 'logout') {
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
    unset($_SESSION['id']);
    session_destroy();
    header('Location: index.php');
}