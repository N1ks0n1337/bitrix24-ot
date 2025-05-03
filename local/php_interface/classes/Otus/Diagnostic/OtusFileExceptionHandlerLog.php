<?php
namespace Otus\Diagnostic;

use Bitrix\Main\Diag\FileExceptionHandlerLog;
use Bitrix\Main\Diag\ExceptionHandlerFormatter;

class OtusFileExceptionHandlerLog extends FileExceptionHandlerLog
{
    /**
     * Записывает отформатированное исключение в файл с префиксом OTUS
     *
     * @param \Throwable $exception
     * @param int        $logType
     */
    public function write(\Throwable $exception, int $logType): void
    {
        $formatter = new ExceptionHandlerFormatter();
        $message = $formatter->format($exception, $logType);

        $timestamp = date('Y-m-d H:i:s');
        $line = '[' . $timestamp . '] OTUS ' . $message . PHP_EOL;

        // добавляем запись в файл лога
        file_put_contents(
            $this->logFile,
            $line,
            FILE_APPEND | LOCK_EX
        );
    }
}
