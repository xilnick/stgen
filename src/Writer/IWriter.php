<?php

namespace Stgen\Writer;

use Stgen\Exception\IOException;

interface IWriter
{
    /**
     * @param $string
     * @throws IOException
     */
    public function write($string);
}
