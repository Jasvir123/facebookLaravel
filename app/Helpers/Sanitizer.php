<?php

namespace App\Helpers;

class Sanitizer
{
    public static function sanitizeInput($input)
    {
        $input = trim($input);
        return strip_tags($input);
    }
}
