<?php

namespace system\core;

class Session {

    public function set(string $column, string $value) {
        $_SESSION[$column] = $value;
    }

    public function get(string $column) {
        return $_SESSION[$column];
    }

    public function destroy(string $column = NULL) {
        if ($column) {
            unset($_SESSION[$column]);
        } else {
            session_destroy();
        }
    }

}