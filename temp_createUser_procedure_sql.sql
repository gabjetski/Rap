CREATE OR REPLACE PROCEDURE createUser(
    IN `p_first_name` VARCHAR(30), 
    IN `p_last_name` VARCHAR(30), 
    IN `p_username` VARCHAR(20), 
    IN `p_email` VARCHAR(50), 
    IN `p_passwort` VARCHAR(30), 
    IN `p_passwort_sec` VARCHAR(30), 
    OUT `p_id` INT) 
    BEGIN
    DECLARE v_firstName_pattern INT;
    DECLARE v_lastName_pattern INT;
    DECLARE v_username_pattern INT;
    DECLARE v_email_pattern INT;

    DECLARE v_usernameCheck INT;
    DECLARE v_mailCheck INT;
    DECLARE v_validMailCheck INT;
    DECLARE v_usernameMailCheck INT;

    SELECT COUNT(pk_user_id) INTO v_usernameCheck FROM user
    WHERE Username = p_username;
    SELECT COUNT(pk_user_id) INTO v_mailCheck FROM user
    WHERE Email = p_email;
    SELECT p_email REGEXP "[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" INTO v_validMailCheck; 
    SELECT p_username REGEXP "[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" INTO v_usernameMailCheck; 
    
    SELECT p_first_name REGEXP "[a-zA-Z]+$" INTO v_firstName_pattern;
    SELECT p_last_name REGEXP "[a-zA-Z]+$" INTO v_firstName_pattern;
    SELECT p_username REGEXP "[a-zA-Z]+$" INTO v_firstName_pattern;
    SELECT p_first_name REGEXP "[a-zA-Z]+$" INTO v_firstName_pattern;
    
    IF (v_usernameCheck > 0) THEN
        SET p_id = -1;
    ELSEIF (v_mailCheck > 0) THEN
        SET p_id = -2;
    ELSEIF (v_validMailCheck = 0) THEN
        SET p_id = -3;
    ELSEIF (v_usernameMailCheck = 1) THEN
        SET p_id = -4;
    ELSE
        IF (p_passwort = p_passwort_sec) THEN
            INSERT INTO USER (FirstName, LastName, Username, Email, Passwort)
            VALUES (p_first_name, p_last_name, p_username, p_email, p_passwort);
            SELECT pk_user_id INTO p_id FROM user
            WHERE Username = p_username;
        ELSE
            SET p_id = -5;
        END IF;
    END IF;
END;