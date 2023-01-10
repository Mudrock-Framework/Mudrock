<?php
namespace system\core;

use mysqli;

class Model {

    /**
     * @var string
     */
    private $columns = '*';

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $where = '';

    /**
     * @var int
     */
    private $limit;

    /**
     * @var string
     */
    private $order_by;

    /**
     * @param string $column
     * @return void
     */
    protected function select(string $column = '*'): void
    {
        $this->columns = $column;
    }

    /**
     * @param string $table
     * @return void
     */
    protected function table(string $table): void
    {
        $this->table = $table;
    }

    /**
     * @param string $column
     * @param string $condition
     * @param string $value
     * @return void
     */
    protected function where(
        string $column,
        string $condition,
        string $value
    ): void {
        if ($condition == 'like') {
            $this->where = ("$column like '%$value%'");
        } else if ($condition == '>' || $condition == '>=' || $condition == '<' || $condition == '<=') {
            $this->where = ("$column $condition $value");
        } else {
            $this->where = ("$column $condition '$value'");

            if (is_numeric($value)) {
                $this->where = ("$column $condition $value");
            }
        }
    }

    /**
     * @param string $column
     * @param string $condition
     * @param string $value
     * @return void
     */
    protected function and_where(string $column, string $condition, string $value): void
    {
        $this->or_and_where_structrure(
            'AND',
            $condition,
            $column,
            $value
        );
    }

    /**
     * @param string $column
     * @param string $condition
     * @param string $value
     * @return void
     */
    protected function or_where(string $column, string $condition, string $value): void
    {
        $this->or_and_where_structrure(
            'OR',
            $condition,
            $column,
            $value
        );
    }

    /**
     * @param string $limit
     * @return void
     */
    protected function limit(string $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @param string $order_by
     * @param string|NULL $order
     * @return void
     */
    protected function order_by(string $order_by, string $order = NULL): void
    {
        $this->order_by = $order_by;

        if ($order) {
            $this->order_by = $order_by . ' ' . $order;
        }
    }

    /**
     * @param array $data
     * @return string
     */
    protected function insert(array $data): string
    {
        if ($this->table != '') {
            return 'Table not defined';
        }

        $final_columns = "";
        $final_values = "";

        foreach ($data as $column => $value) {
            $final_columns .= "$column,";
            $final_values .= "'$value',";
        }

        if ($final_values != '' && $final_columns != '') {
            $final_columns = substr($final_columns, 0, -1);
            $final_values = substr($final_values, 0, -1);
            $connect = $this->connect();
            $sql_insert = "INSERT INTO {$this->table} ($final_columns) VALUES ($final_values);";
            $connect->query($sql_insert);
            $id = $connect->insert_id;
            $connect->close();

            return $id;
        }

        return 'Values not informed';
    }

    /**
     * @param array $data
     * @return bool|\mysqli_result|string
     */
    protected function update(array $data): ?bool
    {
        if ($this->table == '') {
            return 'Table not defined';
        }

        $where = '';

        if ($this->where != '') {
            $where = "WHERE {$this->where}";
        }

        $final_values = "";

        foreach ($data as $column => $value) {
            $final_values .= "$column = '$value',";
        }

        if ($final_values != '') {
            $final_values = substr($final_values, 0, -1);
            $sql_update = "UPDATE {$this->table} SET $final_values $where;";
            $connect = $this->connect();
            $result = $connect->query($sql_update);
            $connect->close();

            return $result;
        }

        return 'Values not informed';
    }

    /**
     * @param string|NULL $table
     * @return array|string
     */
    protected function row(string $table = NULL): ?array
    {
        return $this->execute_select('row', $table);
    }

    /**
     * @param string|NULL $table
     * @return array|string
     */
    protected function result(string $table = NULL): ?array
    {
        return $this->execute_select('result', $table);
    }

    /**
     * @param string $type
     * @param string $condition
     * @param string $column
     * @param string $value
     * @return void
     */
    private function or_and_where_structrure(
        string $type,
        string $condition,
        string $column,
        string $value
    ): void {
        if ($this->where != '') {
            $this->where .= " $type ";
        }

        if ($condition == 'like') {
            $this->where .= ("$column like '%$value%'");
        } else if ($condition == '>' || $condition == '>=' || $condition == '<' || $condition == '<=') {
            $this->where .= ("$column $condition $value");
        } else {
            $this->where .= ("$column $condition '$value'");
        }
    }

    private function execute_select(string $type, string $table = NULL) {
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

    public function do_login(array $login, array $password, string $table) {
        try {
            foreach ($login as $column => $value) {
                $where = "$column = '$value'";
            }
            foreach ($password as $column => $value) {
                $password_column = $column;
                $password_value = $value;
            }
            $connect = $this->connect();
            $sql = "SELECT {$password_column} FROM {$table} WHERE {$where}";
            $response = false;
            $result = $connect->query($sql);
            if ($result) {
                while ($obj = mysqli_fetch_object($result)) {
                    if (decrypt($obj->{$password_column}) == $password_value) {
                        $response = true;
                    }
                    if ($obj->{$password_column} == $password_value) {
                        $response = true;
                    }
                }
            }
            return $response;

        } catch (\Throwable $th) {
            return FALSE;
        }
    }
}
