<?php
    class abstractDAO
    {
        protected $mysqli;
        protected static $DB_HOST = 'localhost:8889';
        protected static $DB_USER = 'root';
        protected static $DB_PASS = 'root';
        protected static $DB_NAME = 'wp_eatery';

        public function __construct()
        {
            try {
                $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USER, self::$DB_PASS, self::$DB_NAME);
            } catch (mysqli_sql_exception $e) {
                throw $e;
            }
        }

        public function getMysqli()
        {
            return $this->mysqli;
        }
    }
