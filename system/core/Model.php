<?php
namespace system\core;

class Model {

    private $columns = '*';
    private $table;
    private $where;
    private $limit;
    private $order_by;

    protected function select(String $column) {
        $this->columns = $column;
    }

    protected function from(String $table) {
        $this->table = $table;
    }

    protected function where(String $column, String $condition, String $value) {
        if ($this->where != '') {
            $this->where .= ' AND ';
        }

        if ($condition == 'like') {
            $this->where .= ("$column like '%$value%'");
        }
        else if ($condition == '>' || $condition == '>=' || $condition == '<' || $condition == '<=') {
            $this->where .= ("$column $condition $value");
        }
        else {
            $this->where .= ("$column $condition '$value'");
        }
    }

    protected function and_where(String $column, String $condition, String $value) {
        if ($this->where != '') {
            $this->where .= ' AND ';
        }

        if ($condition == 'like') {
            $this->where .= ("$column like '%$value%'");
        }
        else if ($condition == '>' || $condition == '>=' || $condition == '<' || $condition == '<=') {
            $this->where .= ("$column $condition $value");
        }
        else {
            $this->where .= ("$column $condition '$value'");
        }
    }

    protected function or_where(String $column, String $condition, String $value) {
        if ($this->where != '') {
            $this->where .= ' AND ';
        }

        if ($condition == 'like') {
            $this->where .= ("$column like '%$value%'");
        }
        else if ($condition == '>' || $condition == '>=' || $condition == '<' || $condition == '<=') {
            $this->where .= ("$column $condition $value");
        }
        else {
            $this->where .= ("$column $condition '$value'");
        }
    }

    protected function limit(String $limit) {
        $this->limit = $limit;
    }

    protected function order_by(String $order_by, String $order = NULL) {
        if ($order) {
            $this->order_by = $order_by . ' ' . $order;
        } else {
            $this->order_by = $order_by;
        }
    }

    protected function get(String $table = NULL) {
        if ($table) {
            $this->table = $table;
        }
        $sql = "SELECT {$this->columns} FROM {$this->table} where {$this->where} {$this->order_by} {$this->limit}";
    }

}