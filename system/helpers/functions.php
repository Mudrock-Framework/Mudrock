<?php

use system\core\Session;

define('VERSION', '1.2.1');

/**
 * @param string|array|bool $parameters
 * @param bool $die
 * @return void
 */
function dd($parameters = NULL, bool $die = TRUE): void
{
    echo '<pre>';
    print_r($parameters);
    echo '</pre>';
    
    if ($die) {
        die();
    }
}

/**
 * @param string|NULL $datetime
 * @param string|NULL $format
 * @return string
 */
function now(string $datetime = NULL, string $format = NULL): string
{
    $date = ($datetime) ?: date(DEFAULT_FORMAT_DATE);
    
    if ($format) {
        $validate_format = validateFormatDate($date, $format);
        if ($validate_format) {
            return $validate_format;
        }

        return $date;
    }

    return $date;
}

/**
 * @param string $date
 * @param string $format
 * @return string
 */
function validateFormatDate(string $date, string $format = 'Y-m-d'): string
{
    try {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    } catch (\Throwable $th) {
        return $th;
    }
}

/**
 * @param string|NULL $folder_language
 * @return void
 */
function setLanguage(string $folder_language = NULL): void
{
    $idiom = DEFAULT_LANGUAGE;
    if ($folder_language) {
        $idiom = $folder_language;
    }

    (new Session)->set('language', $idiom);
}

/**
 * @param string $file
 * @return string|null
 */
function callFile(string $file): string
{
    $file_view = '.././app/views/' . $file . '.php';
    if (file_exists($file_view)) {
        include ($file_view);

        return '';
    }

    return 'Error';
}

/**
 * @param string $string
 * @return string
 */
function encrypt(string $string): string
{
    $encryption_key = base64_decode(ENCRYPT_KEY);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($string, 'aes-256-cbc', $encryption_key, 0, $iv);

    return base64_encode($encrypted . '::' . $iv);
}

/**
 * @param string $string
 * @return false|string
 */
function decrypt(string $string): ?bool
{
    $encryption_key = base64_decode(ENCRYPT_KEY);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($string), 2),2,null);

    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

/**
 * @param string $url
 * @return void
 */
function redirect(string $url): void
{
    header('Location: ' . $url);
}

/**
 * @param string $column
 * @param string $value
 * @return void
 */
function setSession(string $column, string $value): void
{
    (new Session)->set($column, $value);
}

/**
 * @param string $column
 * @return mixed|string|null
 */
function getSession(string $column): ?string
{
    return (new Session)->get($column);
}

/**
 * @param string|NULL $column
 * @return void
 */
function destroySession(string $column = NULL): void
{
    (new Session)->destroy($column);
}

/**
 * @return void
 */
function getVersion(): void
{
    echo VERSION;
}