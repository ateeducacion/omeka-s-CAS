<?php

namespace CAS\Session;

class TicketStorage
{
    private string $storagePath;

    public function __construct(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }

    public function store(string $ticket, string $sessionId): void
    {
        if ($ticket === '' || $sessionId === '') {
            return;
        }

        $this->write(function (array $map) use ($ticket, $sessionId) {
            $map[$ticket] = $sessionId;
            return $map;
        });
    }

    public function getSessionId(string $ticket): ?string
    {
        $map = $this->read();
        return $map[$ticket] ?? null;
    }

    public function remove(string $ticket): ?string
    {
        $removedSessionId = null;
        $this->write(function (array $map) use ($ticket, &$removedSessionId) {
            if (array_key_exists($ticket, $map)) {
                $removedSessionId = $map[$ticket];
                unset($map[$ticket]);
            }
            return $map;
        });

        return $removedSessionId;
    }

    /**
     * @return string[]
     */
    public function removeBySessionId(string $sessionId): array
    {
        $removedTickets = [];
        $this->write(function (array $map) use ($sessionId, &$removedTickets) {
            foreach ($map as $ticket => $storedSessionId) {
                if ($storedSessionId === $sessionId) {
                    unset($map[$ticket]);
                    $removedTickets[] = $ticket;
                }
            }
            return $map;
        });

        return $removedTickets;
    }

    private function read(): array
    {
        if (!is_file($this->storagePath)) {
            return [];
        }

        $handle = fopen($this->storagePath, 'rb');
        if ($handle === false) {
            return [];
        }

        try {
            if (!flock($handle, LOCK_SH)) {
                return [];
            }

            $content = stream_get_contents($handle);
            flock($handle, LOCK_UN);
        } finally {
            fclose($handle);
        }

        $data = json_decode($content ?: '[]', true);
        return is_array($data) ? $data : [];
    }

    /**
     * @param callable $writer fn(array $map): array
     */
    private function write(callable $writer): void
    {
        $directory = dirname($this->storagePath);
        if (!is_dir($directory)) {
            @mkdir($directory, 0777, true);
        }

        $handle = fopen($this->storagePath, 'c+b');
        if ($handle === false) {
            return;
        }

        try {
            if (!flock($handle, LOCK_EX)) {
                return;
            }

            $existing = stream_get_contents($handle);
            $map = json_decode($existing ?: '[]', true);
            $map = is_array($map) ? $map : [];

            $map = $writer($map);

            ftruncate($handle, 0);
            rewind($handle);
            fwrite($handle, json_encode($map, JSON_UNESCAPED_SLASHES));
            fflush($handle);

            flock($handle, LOCK_UN);
        } finally {
            fclose($handle);
        }
    }
}

