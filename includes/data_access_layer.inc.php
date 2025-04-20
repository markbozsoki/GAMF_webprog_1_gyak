<?php
//TODO: these should come from environment file
putenv("DB_HOST='localhost'");
putenv("DB_NAME='knifes_database'");
putenv("DB_USER='root'");
putenv("DB_PW=''");

class DataAccessLayerSingleton {

    protected static $_instance;

    protected $_connection;

    private function __clone() {
        // prevent cloning
    }

    public function __wakeup() {
        // prevent unserialization
        throw new \Exception(statci::class . ' should not be unserialized!');
    }

    private function __construct() {
        if (!isset($_ENV['DB_HOST'])) {
            throw new \Exception('DB_HOST must be set!');
        }
        if (!isset($_ENV['DB_NAME'])) {
            throw new \Exception('DB_NAME must be set!');
        }
        if (!isset($_ENV['DB_USER'])) {
            throw new \Exception('DB_USER must be set!');
        }
        if (!isset($_ENV['DB_PW'])) {
            putenv("DB_PW=''"); // if no password set for DB, defult to ''
        }

        try {
            $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], 
            $this->_connection = new PDO(
                $dsn,
                $_ENV['DB_USER'], 
                $_ENV['DB_PW'],
                $driver_options
            );
            // set error mode to exception
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)
            // set collation for hungarian alphabetical ordering
            $this->_connection->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        }
        catch {
            load_error_page($errors['500'], 'DB connection failed');
        }
    }

    public function __get($name) {
        // delegate every get call to PDO instance
        return $this->_connection->$name;
    }

    public function __set($name, $value) {
        // delegate every set call to PDO instance
        return $this->_connection->$name = $value;
    }

    public function __call($method, $args) {
        // delegate every method call to PDO instance
        $callback = array($this->_connection, $method);
        return call_user_func_array($callback, $args);
    }

    public static function getInstance() {
        if (self::$_instance === NULL) {
            // init class only one time
            self::$_instance = new self();
        }
        return self::$_instance
    }

}
?>
