-- removes all registered data and resets index counters
TRUNCATE `knives_database`.`users`;
TRUNCATE `knives_database`.`access`;
TRUNCATE `knives_database`.`details`;

DROP DATABASE IF EXISTS `knives_database`;
DROP USER IF EXISTS 'debug_user'@'localhost';
