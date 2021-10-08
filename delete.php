<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/requirements.php';
$status = $_GET['status'];
if ($status == 'remove') {
    deleteUser();
    header("Location: http://{$_SERVER['HTTP_HOST']}/");
}