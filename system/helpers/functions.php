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

function encrypt(String $string) {
    $encryption_key = base64_decode(ENCRYPT_KEY);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($string, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt(String $string) {
    $encryption_key = base64_decode(ENCRYPT_KEY);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($string), 2),2,null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

function getVersion() {
    echo VERSION;
}