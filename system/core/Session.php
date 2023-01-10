<?php

namespace system\core;

class Session {

    /**
     * @param string $column
     * @param string $value
     * @return void
     */
    public function set(string $column, string $value): void
    {
        $_SESSION[$column] = $value;
    }

    /**
     * @param string $column
     * @return mixed
     */
    public function get(string $column): ?string
    {
        return $_SESSION[$column];
    }

    /**
     * @param string|NULL $column
     * @return void
     */
    public function destroy(string $column = NULL): void
    {
        if ($column) {
            unset($_SESSION[$column]);
            return;
        }

        session_destroy();
    }
}
