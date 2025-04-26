USE `knives_database`;

-- check if username already exists
SET @username = "admin";
SELECT count(username) AS username_exists
FROM USERNAMES 
WHERE username = @username;

-- get password hash by username (username is unique)
SET @username = "admin";
SELECT password_hash 
FROM ACCESS 
WHERE id IN (
    SELECT access_id 
    FROM USERS 
    WHERE username = @username
    );

-- get user details (username is unique)
SET @username = "admin";
SELECT surname, forename
FROM USER_DETAILS
WHERE username = @username;

-- get all messages paginated
SET @start = 0;
SET @page_size = 5;
SELECT * 
FROM MESSAGES
ORDER BY MESSAGES.sent_at DESC
LIMIT 5 OFFSET 0;
