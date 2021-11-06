<?php

namespace system\core;

class Welcome_model extends Model {

    public function getUsers(String $table) {
        $this->table($table);
        $this->where('email', '=', 'douglas@teste.com');
//        $this->and_where('nome', '=', 'Fernanda');
//        $this->order_by('id', 'asc');
//        $this->limit(1);
//        return $this->result();
        return $this->result();
    }

    public function getUser(String $table, Int $id) {
        $this->table($table);
        $this->where('id', '=', $id);
        return $this->row();
    }

}