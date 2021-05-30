<?php

namespace App\Libs;

class CsvReader
{
    private $file;

    public function __construct(string $file, string $mode = "r")
    {
        $accepted_modes = [ 'r', 'r+', 'w', 'w+', 'a', 'a+', 'x', 'x+', ];
        $mode           = in_array($mode, $accepted_modes) ? $mode : 'r';
        $this->file     = fopen($file, $mode);
    }

    public function lineByLine(
        ?int $length = 0,
        string $separator = ',',
        string $enclosure = '"',
        string $escape = '\\'
    )
    {
        $separator = $separator ?: ',';

        while (!feof($this->file))
        {
            yield fgetcsv($this->file, $length, $separator, $enclosure, $escape);
        }
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}
