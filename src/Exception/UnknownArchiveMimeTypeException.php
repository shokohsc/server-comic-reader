<?php

namespace App\Exception;

class UnknownArchiveMimeTypeException extends \Exception
{
    public $message = 'Unknown archive mimetype.';
}
