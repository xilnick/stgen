<?php

namespace Stgen\Writer;

use Stgen\Exception\InvalidArgumentException;
use Stgen\Exception\IOException;

class SingleFileWriter implements IWriter
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * SingleFileWriter constructor.
     * @param $filePath
     * @throws IOException
     * @throws InvalidArgumentException
     */
    public function __construct($filePath)
    {
        $filePath = realpath($filePath);
        if (!$filePath || !is_file($this->filePath)) {
            throw new InvalidArgumentException('Valid file path expected.');
        }
        if (!is_writable($filePath)) {
            throw new IOException("File with given path {$filePath} is not writable.");
        }
        $this->filePath = $filePath;
    }

    /**
     * @param $string
     * @throws IOException
     */
    public function write($string)
    {
        file_put_contents($this->filePath, $string, FILE_APPEND);
    }
}