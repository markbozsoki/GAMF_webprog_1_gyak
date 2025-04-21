USE `knifes_database`;

SET @username = 'dummyUser';
SET @password = 'Password12345';
SET @surname = 'Dummilton';
SET @forename = 'Userling';
INSERT INTO `access` (`id`, `created_at`, `last_logged_in`, `password_hash`) VALUES (NULL, UNIX_TIMESTAMP(NOW()), '0', SHA2(@password, 256));
SET @access_last_id = LAST_INSERT_ID();
INSERT INTO `details` (`id`, `surname`, `forename`) VALUES (NULL, @surname, @forename);
SET @details_last_id = LAST_INSERT_ID();
INSERT INTO `users` (`id`, `username`, `created_at`, `access_id`, `detail_id`) VALUES (NULL, @username, UNIX_TIMESTAMP(NOW()), @access_last_id, @details_last_id);

-- orphan useraccess 
SET @password = 'randomstring';
INSERT INTO `access` (`id`, `created_at`, `last_logged_in`, `password_hash`) VALUES (NULL, UNIX_TIMESTAMP(NOW()), '0', SHA2(@password, 256));

SET @username = 'testUser1';
SET @password = 'ILoveHorses';
SET @surname = 'Horse-Lover';
SET @forename = 'User';
INSERT INTO `access` (`id`, `created_at`, `last_logged_in`, `password_hash`) VALUES (NULL, UNIX_TIMESTAMP(NOW()), '0', SHA2(@password, 256));
SET @access_last_id = LAST_INSERT_ID();
INSERT INTO `details` (`id`, `surname`, `forename`) VALUES (NULL, @surname, @forename);
SET @details_last_id = LAST_INSERT_ID();
INSERT INTO `users` (`id`, `username`, `created_at`, `access_id`, `detail_id`) VALUES (NULL, @username, UNIX_TIMESTAMP(NOW()), @access_last_id, @details_last_id);

-- orphan userdetail
SET @surname = 'Doe';
SET @forename = 'John';
INSERT INTO `details` (`id`, `surname`, `forename`) VALUES (NULL, @surname, @forename);

-- orphan userdetail
SET @surname = 'Doe';
SET @forename = 'Jane';
INSERT INTO `details` (`id`, `surname`, `forename`) VALUES (NULL, @surname, @forename);

SET @username = 'testUser1';
SET @password = 'ILoveDogs';
SET @surname = 'Dog-Lover';
SET @forename = 'User';
INSERT INTO `access` (`id`, `created_at`, `last_logged_in`, `password_hash`) VALUES (NULL, UNIX_TIMESTAMP(NOW()), '0', SHA2(@password, 256));
SET @access_last_id = LAST_INSERT_ID();
INSERT INTO `details` (`id`, `surname`, `forename`) VALUES (NULL, @surname, @forename);
SET @details_last_id = LAST_INSERT_ID();
INSERT INTO `users` (`id`, `username`, `created_at`, `access_id`, `detail_id`) VALUES (NULL, @username, UNIX_TIMESTAMP(NOW()), @access_last_id, @details_last_id);

SET @username = 'testUser2';
SET @password = 'ILoveCats';
SET @surname = 'Cat-Lover';
SET @forename = 'User';
INSERT INTO `access` (`id`, `created_at`, `last_logged_in`, `password_hash`) VALUES (NULL, UNIX_TIMESTAMP(NOW()), '0', SHA2(@password, 256));
SET @access_last_id = LAST_INSERT_ID();
INSERT INTO `details` (`id`, `surname`, `forename`) VALUES (NULL, @surname, @forename);
SET @details_last_id = LAST_INSERT_ID();
INSERT INTO `users` (`id`, `username`, `created_at`, `access_id`, `detail_id`) VALUES (NULL, @username, UNIX_TIMESTAMP(NOW()), @access_last_id, @details_last_id);
