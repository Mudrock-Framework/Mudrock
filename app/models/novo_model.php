
<?php

namespace system\core;

class Novo_model extends Model {

    public function example_select() {
        $this->table('novo');
        return $this->result();
    }

}

?>