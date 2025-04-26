USE `knives_database`;

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
INSERT INTO `users` (`id`, `username`, `created_at`, `access_id`, `detail_id`) VALUES (default, @username, UNIX_TIMESTAMP(NOW()), @access_last_id, @details_last_id);
SET @test_user_cat_id = LAST_INSERT_ID();

-- orphan useraccess 
SET @password = 'password12345';
INSERT INTO `access` (`id`, `created_at`, `last_logged_in`, `password_hash`) VALUES (default, UNIX_TIMESTAMP(NOW() - INTERVAL 1 HOUR), default, SHA2(@password, 256));


SET @username = 'testUser4';
SET @password = 'ILoveSharks';
SET @surname = 'Fish-Lover';
SET @forename = 'User';
INSERT INTO `access` (`id`, `created_at`, `last_logged_in`, `password_hash`) VALUES (default, UNIX_TIMESTAMP(NOW()), default, SHA2(@password, 256));
SET @access_last_id = LAST_INSERT_ID();
INSERT INTO `details` (`id`, `surname`, `forename`) VALUES (default, @surname, @forename);
SET @details_last_id = LAST_INSERT_ID();
INSERT INTO `users` (`id`, `username`, `created_at`, `access_id`, `detail_id`) VALUES (default, @username, UNIX_TIMESTAMP(NOW()), @access_last_id, @details_last_id);
SET @test_user_fish_id = LAST_INSERT_ID();

INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 5 MINUTE), "Hello, is your frigde running?&#92;&#110;&#92;&#110;&#92;&#110;Bye");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 10 MINUTE), "Hello,&#92;&#110;&#92;&#110;how are you?&#92;&#110;&#92;&#110;I'am a guest.&#92;&#110;&#92;&#110;&#92;&#110;Bye");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_dummy_id, UNIX_TIMESTAMP(NOW() - INTERVAL 15 MINUTE), "Hello,&#92;&#110;&#92;&#110;&#92;&#110;how are you?&#92;&#110;&#92;&#110;I'am the dummy user.&#92;&#110;&#92;&#110;&#92;&#110;Bye");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_horse_id, UNIX_TIMESTAMP(NOW() - INTERVAL 20 MINUTE), "Hello,&#92;&#110;&#92;&#110;&#92;&#110;how are you?&#92;&#110;I'am the horse user.&#92;&#110;&#92;&#110;&#92;&#110;Bye");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_dog_id, UNIX_TIMESTAMP(NOW() - INTERVAL 25 MINUTE), "Hello,&#92;&#110;&#92;&#110;how are you?&#92;&#110;I'am the dog user.&#92;&#110;&#92;&#110;&#92;&#110;Bye");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_cat_id, UNIX_TIMESTAMP(NOW() - INTERVAL 30 MINUTE), "Hello,&#92;&#110;&#92;&#110;how are you?&#92;&#110;I'am the cat user.&#92;&#110;&#92;&#110;&#92;&#110;Bye");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 33 MINUTE), "ʕノ•ᴥ•ʔノ ︵ ┻━┻&#92;&#110;&#92;&#110;┻━┻ ︵ヽ(`Д´)ﾉ︵ ┻━┻&#92;&#110;&#92;&#110;¯\_( ͡° ͜ʖ ͡°)_/¯");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_fish_id, UNIX_TIMESTAMP(NOW() - INTERVAL 35 MINUTE), "Hello,\n\nhow are you?\nI'am the fish user.\n\n\nBye");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 40 MINUTE), "Just letting you know we featured your website on our blog roundup!\n\nBest,\nThe Popular Blog Team");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 45 MINUTE), "Do you offer a demo or trial version of your product?");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 45 MINUTE), "Test - zW9X0oLMeTkP3rQ");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 50 MINUTE), "I tried using your contact form, but it didn’t go through — reaching out here instead.");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_cat_id, UNIX_TIMESTAMP(NOW() - INTERVAL 55 MINUTE), "I’m looking for more technical details about knives.\nDo you have a spec sheet?");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 60 MINUTE), "Hello, I recently placed an order on your website and unfortunately received the wrong item. I tried reaching out via the contact form, but haven’t received a response. I'd appreciate it if someone could assist me with a replacement or refund as soon as possible. Thanks in advance for your help.");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_horse_id, UNIX_TIMESTAMP(NOW() - INTERVAL 65 MINUTE), "Hello there!\n\nJust wanted to say your website looks great! One small thing — I noticed a broken link on the homepage.");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 70 MINUTE), "Hello! I’m interested in your services and wanted to ask about your pricing options.");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 72 MINUTE), "Test - dVrY7kpXLO23mne");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 75 MINUTE), "Hi,\nI came across your site and had a quick question about one of your knives.\n\nCould you help?");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_dog_id, UNIX_TIMESTAMP(NOW() - INTERVAL 80 MINUTE), "Is super knife currently in stock? I'm interested in placing an order.");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 85 MINUTE), "Do you have a press/media kit available for download?");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 90 MINUTE), "Do you offer discounts for bulk purchases?\nTIA");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 92 MINUTE), "Check this cool ASCII art I made for you:\n\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⡀\n⠀⠀⠀⠀⠀⠀⣀⢀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢠⢾⡇\n⠀⠀⣀⠤⡒⠉⠒⡄⡇⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⡰⠃⢸⠃\n⢰⣾⡐⠉⡠⠂⠜⠠⠸⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⠞⠠⡃⡿⠀\n⠈⢟⣼⡐⠠⢲⡀⠀⠀⢱⡀⠀⠀⠀⠀⠀⠀⠀⡰⢋⢰⠇⣸⠇⠀\n⠀⠈⢿⣷⡀⠁⠠⠀⠩⠀⡳⡀⠀⠀⠀⠀⢠⠞⣺⡗⠣⣐⡏⠀⠀\n⠀⠀⠈⢻⣱⡀⠁⠀⠀⢰⣆⠳⡄⠀⢀⣴⢇⣼⠛⠀⣰⡟⠀⠀⠀\n⠀⠀⠀⠀⠹⣷⡄⠘⢀⡀⠀⣇⠼⣦⠊⠞⠀⠛⡀⣰⡟⠀⠀⠀⠀\n⠀⠀⠀⠀⠀⠘⢿⣄⣁⡡⠒⢷⣝⠏⠳⣦⣀⡀⣼⠏⠀⠀⠀⠀⠀\n⠀⠀⠀⠀⠀⠀⠀⠙⠁⠀⡠⣛⣻⣆⢶⠘⢟⠾⠋⠀⠀⠀⠀⠀⠀\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⡔⡧⣩⠟⠙⣷⡤⡬⣣⠀⠀⠀⠀⠀⠀⠀\n⠀⠀⠀⠀⠀⠀⠀⠀⠘⣬⣵⠃⠀⠀⠘⣧⣤⠞⠀⠀⠀⠀⠀⠀⠀");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_dummy_id, UNIX_TIMESTAMP(NOW() - INTERVAL 95 MINUTE), "Test - X7b92LmTqP1oKej");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 103 MINUTE), "Test - aVz39PxkLe8TRyo");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 106 MINUTE), "Test - N0rBq15ZsXvdM6J");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 109 MINUTE), "Test - mUoT9EjwF7KzLqx");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_fish_id, UNIX_TIMESTAMP(NOW() - INTERVAL 110 MINUTE), "Test - Wq8eJ7zLMy0kRpN");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, @test_user_dummy_id, UNIX_TIMESTAMP(NOW() - INTERVAL 115 MINUTE), "Test - b3XzQWm94Et7uVo");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 120 MINUTE), "Test - TfK1pZxqvYO29le");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 122 MINUTE), "Test - EqLzM49KnT8rWvo");
INSERT INTO `messages` (`id`, `sender_id`, `sent_at`, `text`) VALUES (default, default, UNIX_TIMESTAMP(NOW() - INTERVAL 150 MINUTE), "Test - 1152sdascvas562");
