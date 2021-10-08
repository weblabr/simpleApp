<?php
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/requirements.php';


$userId = (int)$_GET['user_id'];
if ($userId < 1) {
    die('Некорректный id клиента!');
}
$user = getUserById($userId);
?>
    <div>
        <h3>Данные клиента <b><?= $user['name'] . ' ' . $user['surname'] ?></b></h3>
    </div>
    <table border="1">
        <tr>
            <td>Id клиента</td>
            <td><?= $user['id']?></td>
        </tr>
        <tr>
            <td>Имя</td>
            <td><?= $user['name']?></td>
        </tr>
        <tr>
            <td>Фамилия</td>
            <td><?= $user['surname']?></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><?= $user['phone']?></td>
        </tr>
        <tr>
            <td>Почта</td>
            <td><?= $user['email']?></td>
        </tr>
        <tr>
            <td>Дата создания</td>
            <td><?= $user['created_at']?></td>
        </tr>
    </table>
    <div>
        <a href="/">Вернуться к списку</a>
    </div>