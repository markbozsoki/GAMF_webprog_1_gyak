-- removes all registered data and resets index counters

USE `knives_database`;
TRUNCATE `users`;
TRUNCATE `access`;
TRUNCATE `details`;
TRUNCATE `messages`;

DROP DATABASE IF EXISTS `knives_database`;
DROP USER IF EXISTS 'debug_user'@'localhost';
