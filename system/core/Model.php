<?php
namespace system\core;

use mysqli;

class Model {

    private $columns = '*';
    private $table;
    private $where = '';
    private $limit;
    private $order_by;

    protected function select(String $column = '*') {
        $this->columns = $column;
    }

    protected function table(String $table) {
        $this->table = $table;
    }

    protected function where(String $column, String $condition, String $value) {
        if ($condition == 'like') {
            $this->where = ("$column like '%$value%'");
        }
        else if ($condition == '>' || $condition == '>=' || $condition == '<' || $condition == '<=') {
            $this->where = ("$column $condition $value");
        }
        else {
            if (is_numeric($value)) {
                $this->where = ("$column $condition $value");
            } else {
                $this->where = ("$column $condition '$value'");
            }
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
            $this->where .= ' OR ';
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

    protected function row(String $table = NULL) {
        return $this->execute_select('row', $table);
    }

    protected function result(String $table = NULL) {
        return $this->execute_select('result', $table);
    }

    private function execute_select(String $type, String $table = NULL) {
        if ($table) {
            $this->table = $table;
        }
        if ($this->table != '') {
            $complement = '';
            if ($this->where != '') {
                $complement .= ' WHERE ' . $this->where;
            }
            if ($this->order_by != '') {
                $complement .= ' ORDER BY ' . $this->order_by;
            }
            if ($this->limit != '') {
                $complement .= ' LIMIT ' . $this->limit;
            }
            try {
                $connect = $this->connect();
                $sql = "SELECT {$this->columns} FROM {$this->table}$complement;";
                $result = $connect->query($sql);

                if ($result) {
                    if ($type == 'result') {
                        $response = [];
                        while ($obj = mysqli_fetch_object($result)) {
                            $response[] = $obj;
                        }
                        return $response;
                        mysqli_free_result($response);
                    }
                    else if ($type == 'row') {
                        $response[0] = [];
                        while ($obj = mysqli_fetch_object($result)) {
                            $response[0] = $obj;
                        }
                        return $response[0];
                        mysqli_free_result($response);
                    }
                    else {
                        return '';
                    }
                } else {
                    return '';
                }
                $connect->close();
            } catch (\Throwable $th) {
                return 'Error connect';
            }
        } else {
            return 'Table is not defined. <br>Use "$this->table("table_name")" to define the table';
        }
    }

    private function connect() {
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        } else {
            return $con;
        }
    }

}