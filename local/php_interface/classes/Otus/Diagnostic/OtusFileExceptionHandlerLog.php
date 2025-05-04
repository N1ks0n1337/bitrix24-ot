<?php
namespace Otus\Diagnostic;

use Bitrix\Main\Diag\FileExceptionHandlerLog;
use Bitrix\Main\Diag\ExceptionHandlerFormatter;

class OtusFileExceptionHandlerLog extends FileExceptionHandlerLog
{
    /**
     * @var string Путь к файлу лога
     */
    protected $logFile;

    /**
     * Конструктор: задаёт путь к файлу лога
     */
    public function __construct()
    {
        $logDirectory = $_SERVER['DOCUMENT_ROOT'] . '/logs';
        if (!is_dir($logDirectory)) {
            // создаём папку, если её нет
            mkdir($logDirectory, 0755, true);
        }
        $this->logFile = $logDirectory . '/' . date('Y-m-d') . '.log';
    }

    /**
     * Записывает отформатированное исключение в файл с префиксом OTUS
     *
     * @param mixed $exception
     * @param mixed $logType
     */
    public function write($exception, $logType)
    {
        $formatter = new ExceptionHandlerFormatter();
        $message   = $formatter->format($exception, $logType);

        $timestamp = date('Y-m-d H:i:s');
        $line      = '[' . $timestamp . '] OTUS ' . $message . PHP_EOL;

        // И пишем её в файл
        file_put_contents(
            $this->logFile,
            $line,
            FILE_APPEND | LOCK_EX
        );
    }
}
