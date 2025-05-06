-- -------- removes all registered data and resets index counters -------- --

USE `knives_database`;
TRUNCATE `USERS`;
TRUNCATE `ACCESS`;
TRUNCATE `DETAILS`;
TRUNCATE `MESSAGES`;

DROP DATABASE IF EXISTS `knives_database`;
DROP USER IF EXISTS 'debug_user'@'localhost';
