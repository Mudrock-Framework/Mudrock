<?php

namespace Mudrock\Helpers;
use Datetime;

class Time {
    private $datetime;

    public function __construct(String $datetime = NULL) {
        if ($datetime) {
            $this->datetime = $datetime;
        } else {
            $this->datetime = date('Y-m-d H:i:s');
        }
    }

    public function now(String $format = NULL): String 
    {
        if ($format) {
            $validate_format = $this->validateFormatDate($format);
            if ($validate_format) {
                return $validate_format;
            } else {
                return $this->datetime;
            }
        } else {
            return $this->datetime;
        }
    }

    private function validateFormatDate($format = 'Y-m-d'): String
    {
        try {
            $d = DateTime::createFromFormat($format, $this->datetime);
            return $d && $d->format($format) === $this->datetime;
        } catch (\Throwable $th) {
            return $th;
        }
        
    }
}