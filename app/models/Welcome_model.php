<?php

namespace system\core;

class Welcome_model extends Model {

    public function getUsers() {
        $this->table('users');
        return $this->result();
    }

    public function getUserById(Int $id) {
        $this->table('user');
        $this->where('id', '=', $id);
        return $this->row();
    }

    public function insertUser() {
        $data = [
            'name' => 'User Name',
            'email' => 'User Mail',
            'password' => 'User Pass'
        ];
        $this->table('users');
        return $this->insert($data);
    }

    public function updateUser(Int $id) {
        $data = [
            'name' => 'New User Name',
            'email' => 'New User Mail',
            'password' => 'New User Pass'
        ];
        $this->table('users');
        $this->where('id', '=', $id);
        return $this->update($data);
    }

}