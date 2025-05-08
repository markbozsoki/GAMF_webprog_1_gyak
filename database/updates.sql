USE `knives_database`;

-- -------- update login timestamp -------- --
SET @username = "admin";
UPDATE ACCESS
SET last_logged_in = UNIX_TIMESTAMP(NOW())
WHERE id IN (
    SELECT access_id 
    FROM USERS 
    WHERE username = @username
    );
