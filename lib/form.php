<?php
declare(strict_types=1);

if (!defined('APP_STARTED')) {
    die();
}

require_once 'db.php';
require_once 'log.php';

$type = $_POST['type'];
if (!isset($_POST['type'])) {
    return;
}
$csrfToken = $_POST['csrf-token'];
if ($csrfToken !== '6154ae4355669') {
    die('You shall not pass!');
}
$formResult = null;

switch ($type) {
    case 'add_user':
        $formResult = addUser();
        header("Location: http://{$_SERVER['HTTP_HOST']}/");
        break;
    case 'import_users':
        $formResult = importUsers();
        header("Location: http://{$_SERVER['HTTP_HOST']}/");
        break;
    default:
        die('Неверное действие!');
}

function addUser()
{
    $userData = [];
    $userData['NAME'] = $_POST['name'];
    $userData['SURNAME'] = $_POST['surname'];
    $userData['PHONE'] = $_POST['phone'];
    $userData['EMAIL'] = $_POST['email'];

    // Имя и фамилия обязательны!
    if (!$userData['NAME'] || !$userData['SURNAME'] || !$userData['PHONE']) {
        die('Имя и фамилия обязательны');
    }

    // Обработаем ошибку БД, если она случится
    try{
        insertUser($userData);
        logData("Добавлен клиент {$userData['NAME']} {$userData['SURNAME']}");
    } catch (Throwable $e) {
        var_dump($e);
    }

    return 'add_success';
}

function deleteUser()
{
    $id = $_GET['remove_id'];
    // Обработаем ошибку БД, если она случится
    try{
        removeUser($id);
        logData("Удален клиент c id {$id}");
    } catch (Throwable $e) {
        var_dump($e);
    }

    return 'delete_success';
}

function importUsers()
{
    $file = $_FILES['import_data'];
    if (!$file) {
        die('Нет файла с клиентами');
    }

    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/storage/';
    $uploadfile = $uploaddir . basename($file['name']);

    if (!move_uploaded_file($file['tmp_name'], $uploadfile)) {
        die('Не удалось сохранить файл');
    }

    $users = [];
    $fp = fopen($uploadfile, 'rb');
    while ($row = fgetcsv($fp, 1024, ';')) {
        $users[] = $row;
    }
    // Первая строка - это заголовок, удаляем ее
    array_shift($users);

    $userData = [];
    foreach ($users as $user) {
        $userData['NAME'] = $user[0];
        $userData['SURNAME'] = $user[1];
        $userData['PHONE'] = $user[2];
        $userData['EMAIL'] = $user[3];

        // Имя и фамилия обязательны!
        if (!$userData['NAME'] || !$userData['SURNAME'] || !$userData['PHONE']) {
            // Нужна запись в лог
            continue;
        }
        insertUser($userData);
    }

    return 'import_success';
}
