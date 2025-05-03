<?php
declare(strict_types=1);

$logDir = $_SERVER['DOCUMENT_ROOT'] . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/init.php';

use Otus\Diagnostic\OtusLogger;

$logger = new OtusLogger(DEBUG_FILE_NAME);
$logger->log('debug.php accessed');

header('Content-Type: text/plain; charset=utf-8');
echo 'Лог записан: ' . date('Y-m-d H:i:s');
