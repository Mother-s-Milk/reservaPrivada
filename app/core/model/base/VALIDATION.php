<?php

    namespace app\core\model\base;

    class VALIDATION {
        protected $conn;
        protected $table;

        public function __construct ($conn, $table) {
            $this->conn = $conn;
            $this->table = $table;
        }
    }

?>