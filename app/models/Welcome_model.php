<?php

namespace system\core;

class Welcome_model extends Model {

    public function getUsers() {
        $this->table('users');
        return $this->result();
    }

}