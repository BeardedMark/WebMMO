<?php

namespace App\Traits;

trait HasLogs
{
    public function getLogs(): array
    {
        return is_array($this->logs) ? $this->logs : [];
    }

    public function addLog(string $type, string $message): void
    {
        $logs = $this->getLogs();
        $maxLogs = 100;

        $logs[] = [
            'datetime' => now()->toDateTimeString(),
            'type' => $type,
            'message' => $message,
        ];

        if (count($logs) > $maxLogs) {
            $logs = array_slice($logs, -$maxLogs);
        }

        $this->logs = $logs;
        $this->save();
    }
}
