<?php
namespace Otus\Diagnostic;

/**
 * логгер: добавляет префикс OTUS и пишет в DEBUG_FILE_NAME.
 */
class OtusLogger
{
    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function log(string $message): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $line = sprintf('[%s] OTUS %s', $timestamp, $message) . PHP_EOL;
        file_put_contents($this->file, $line, FILE_APPEND | LOCK_EX);
    }
}
