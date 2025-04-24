-- DEBUG USER FOR CONNECTION
CREATE USER IF NOT EXISTS 'debug_user'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE ON *.* TO 'debug_user'@'localhost' 
REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 3600 MAX_CONNECTIONS_PER_HOUR 3600 MAX_UPDATES_PER_HOUR 3600 MAX_USER_CONNECTIONS 3600;
GRANT SELECT, INSERT, UPDATE ON `knives\_database`.* TO 'debug_user'@'localhost';

-- DATABASE
CREATE DATABASE IF NOT EXISTS `knives_database`
CHARACTER SET utf8 COLLATE utf8_hungarian_ci;

USE `knives_database`;

-- TABLES
CREATE TABLE IF NOT EXISTS `ACCESS` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `created_at` int(10) NOT NULL,
  `last_logged_in` int(10) default '0',
  `password_hash` varchar(64) default NULL,
  PRIMARY KEY (`id`)
) ENGINE = MYISAM;

CREATE TABLE IF NOT EXISTS `DETAILS` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `surname` varchar(35) default '',
  `forename` varchar(35) default '',
  PRIMARY KEY (`id`)
) ENGINE = MYISAM;

CREATE TABLE IF NOT EXISTS `USERS` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `username` varchar(25) NOT NULL unique,
  `created_at` int(10) NOT NULL,
  `access_id` int(5) unsigned NOT NULL unique,
  `detail_id` int(5) unsigned NOT NULL unique,
  PRIMARY KEY (`id`),
  CONSTRAINT FK_USER_ACCESS FOREIGN KEY (access_id) REFERENCES ACCESS(id),
  CONSTRAINT FK_USER_DETAIL FOREIGN KEY (detail_id) REFERENCES DETAILS(id)
) ENGINE = MYISAM;

-- VIEWS
CREATE VIEW IF NOT EXISTS `USERNAMES` AS
SELECT username FROM USERS;

CREATE VIEW IF NOT EXISTS `USER_DETAILS` AS
SELECT USERS.username AS username, 
       DETAILS.surname AS surname, 
       DETAILS.forename AS forename 
FROM USERS LEFT JOIN DETAILS ON USERS.detail_id = DETAILS.id;

CREATE VIEW IF NOT EXISTS `USER_LOGINS` AS
SELECT USERS.username AS username, 
       from_unixtime(ACCESS.last_logged_in) AS last_logged_in,
       from_unixtime(ACCESS.created_at) AS access_created_at,
       from_unixtime(USERS.created_at) AS user_created_at, 
       ACCESS.last_logged_in AS logged_in_epoch,
       ACCESS.created_at AS access_crtd_epoch, 
       USERS.created_at AS user_crtd_epoch
FROM USERS LEFT JOIN ACCESS ON USERS.access_id = ACCESS.id
ORDER BY logged_in_epoch DESC, access_crtd_epoch DESC, user_crtd_epoch DESC;

CREATE VIEW IF NOT EXISTS `ORPHAN_ACCESS_RECORDS` AS
SELECT * 
FROM ACCESS 
WHERE id NOT IN (
  SELECT access_id 
  FROM USERS
  );

CREATE VIEW IF NOT EXISTS `ORPHAN_DETAILS_RECORDS` AS
SELECT * 
FROM DETAILS 
WHERE id NOT IN (
  SELECT detail_id 
  FROM USERS
  );

-- REGISTER ADMIN USER
SET @username = 'admin';
SET @password = 'admin';
SET @surname = 'The';
SET @forename = 'Admin';
INSERT INTO `ACCESS` (`id`, `created_at`, `last_logged_in`, `password_hash`) VALUES (NULL, UNIX_TIMESTAMP(NOW()), '0', SHA2(@password, 256));
SET @access_last_id = LAST_INSERT_ID();
INSERT INTO `DETAILS` (`id`, `surname`, `forename`) VALUES (NULL, @surname, @forename);
SET @details_last_id = LAST_INSERT_ID();
INSERT INTO `USERS` (`id`, `username`, `created_at`, `access_id`, `detail_id`) VALUES (NULL, @username, UNIX_TIMESTAMP(NOW()), @access_last_id, @details_last_id);
