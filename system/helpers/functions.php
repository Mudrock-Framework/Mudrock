<?php

function dd($parameters = NULL, bool $die = TRUE) {
    echo '<pre>';
    print_r($parameters);
    echo '</pre>';
    
    if ($die) {
        die();
    }
}

function now(String $datetime = NULL, String $format = NULL): String 
{
    $date = ($datetime) ? $datetime : date('Y-m-d H:i:s');
    
    if ($format) {
        $validate_format = validateFormatDate($date, $format);
        if ($validate_format) {
            return $validate_format;
        } else {
            return $date;
        }
    } else {
        return $date;
    }
}

function validateFormatDate(String $date, String $format = 'Y-m-d'): String
{
    try {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    } catch (\Throwable $th) {
        return $th;
    }
    
}

function getVersion() {
    return '1.0';
}