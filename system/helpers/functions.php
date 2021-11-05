<?php

use system\core\Session;

define('VERSION', '1.0');

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
    $date = ($datetime) ? $datetime : date(DEFAULT_FORMAT_DATE);
    
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

function setLanguage(String $folder_language = NULL) {
    if ($folder_language) {
        $idiom = $folder_language;
    } else {
        $idiom = DEFAULT_LANGUAGE;
    }
    (new Session)->set('language', $idiom);
}

function callFile(String $file) {
    $file_view = '.././app/views/' . $file . '.php';
    if (file_exists($file_view)) {
        include ($file_view);
    } else {
        echo 'Error';
    }
}

function getVersion() {
    echo VERSION;
}