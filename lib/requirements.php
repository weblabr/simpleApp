<?php
declare(strict_types=1);

const APP_STARTED = true;
session_start();

require_once 'form.php';
require_once 'db.php';
require_once 'log.php';

function dd($val)
{
    var_dump($val);
    die();
}