CREATE OR REPLACE PROCEDURE addTrack(
    IN `p_title` VARCHAR(60),
    IN `p_path` VARCHAR(50),
    IN `p_length` TIME,
    IN `p_tag1` VARCHAR(30),
    IN `p_tag2` VARCHAR(30),
    IN `p_tag3` VARCHAR(30),
    IN `p_tag4` VARCHAR(30),
    IN `p_tag5` VARCHAR(30),
    IN `p_description` VARCHAR(120),
    IN `p_user_id` INTEGER,
    IN `p_bpm` INTEGER,
    IN `p_key_id` INTEGER,
    IN `p_type`INTEGER,
    IN `p_monet` INTEGER,
    OUT `p_id` INT)
    BEGIN
    DECLARE v_bpm_pattern INT;
    DECLARE v_title_pattern INT;
    DECLARE v_file_name_pattern INT;
    DECLARE v_email_pattern INT;

    DECLARE v_usernameCheck INT;
    DECLARE v_mailCheck INT;
    DECLARE v_usernameMailCheck INT;

    SELECT COUNT(pk_user_id) INTO v_usernameCheck FROM user
    WHERE Username = p_username;
    SELECT COUNT(pk_user_id) INTO v_mailCheck FROM user
    WHERE Email = p_email;
    
    SELECT p_bpm REGEXP "^\d{2,3}$" INTO v_bpm_pattern;
    SELECT p_title REGEXP "^[\s\S]{0,60}$" INTO v_title_pattern;
    SELECT p_username REGEXP "^[a-zA-Z0-9ÄÜÖäüö_.\-]{3,20}$" INTO v_username_pattern;
    SELECT p_email REGEXP "^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$" 
                INTO v_email_pattern;
    SELECT p_username REGEXP "^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$" 
                INTO v_usernameMailCheck;
    
    IF (v_usernameCheck > 0) THEN
        SET p_id = -1;
    ELSEIF (v_mailCheck > 0) THEN
        SET p_id = -2;
    ELSEIF (v_email_pattern = 0) THEN
        SET p_id = -3;
    ELSEIF (v_usernameMailCheck = 1) THEN
        SET p_id = -4;
    ELSEIF (v_firstName_pattern = 0) THEN
        SET p_id = -5;
    ELSEIF (v_lastName_pattern = 0) THEN
        SET p_id = -6;
    ELSEIF (v_username_pattern = 0) THEN
        SET p_id = -7;
    ELSE
        IF (p_passwort = p_passwort_sec) THEN
            INSERT INTO USER (FirstName, LastName, Username, Email, Passwort)
            VALUES (p_first_name, p_last_name, p_username, p_email, p_passwort);
            SELECT pk_user_id INTO p_id FROM user
            WHERE Username = p_username;
        ELSE
            SET p_id = -8;
        END IF;
    END IF;
END;