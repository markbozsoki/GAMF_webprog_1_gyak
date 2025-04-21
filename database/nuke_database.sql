-- removes all registered data and resets index counters
TRUNCATE `knifes_database`.`users`;
TRUNCATE `knifes_database`.`access`;
TRUNCATE `knifes_database`.`details`;

DROP DATABASE IF EXISTS `knifes_database`;
DROP USER IF EXISTS 'debug_user'@'localhost';
