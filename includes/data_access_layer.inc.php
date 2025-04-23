<?php
class DataAccessLayerSingleton {

    protected static $_instance = NULL;

    protected $_connection = NULL;

    private function __clone() {
        // prevent cloning
    }

    public function __wakeup() {
        // prevent unserialization
        throw new Exception(static::class . ' should not be unserialized!');
    }

    private function __construct() {
        global $_ENV;
        global $errors;
        
        if (getenv('DB_HOST') == NULL) {
            throw new Exception('DB_HOST must be set!');
        }
        if (getenv('DB_NAME') == NULL) {
            throw new Exception('DB_NAME must be set!');
        }
        if (getenv('DB_USER') == NULL) {
            throw new Exception('DB_USER must be set!');
        }
        if (getenv('DB_PW') == NULL) {
            putenv("DB_PW="); // if no password set for DB, defult to ''
        }

        $dsn = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME');
        $driver_options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
        $this->_connection = new PDO(
            $dsn,
            getenv('DB_USER'), 
            getenv('DB_PW'),
            $driver_options
        );
        // set error mode to exception
        $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // set collation for hungarian alphabetical ordering
        $this->_connection->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
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

    public static function getInstance(): DataAccessLayerSingleton {
        if (self::$_instance === NULL) {
            // init class only one time
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function executeCommand($template, $params): array | bool {
        $prepared_statement = $this->_connection->prepare($template);
        $prepared_statement->execute($params);
        return $prepared_statement->fetch(PDO::FETCH_ASSOC);
    }
}
?>
