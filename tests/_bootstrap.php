<?php

declare(strict_types=1);

$root = dirname(realpath(__DIR__) . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
define('PROJECT_PATH', $root);

require_once $root . 'tests/_config/functions.php';

if (file_exists(rootDir('.env'))) {
    $dotenv = Dotenv\Dotenv::createImmutable(rootDir());
    $dotenv->load();
}

loadIni();
loadFolders();
loadDefined();

unset($root);
