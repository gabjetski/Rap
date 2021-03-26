#----------------------DATABASE------------------------

DROP DATABASE IF EXISTS rap;
CREATE DATABASE rap;
USE rap;

CREATE OR REPLACE TABLE User(
    pk_user_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    FirstName VARCHAR(30) NOT NULL, 
    LastName VARCHAR(30) NOT NULL, 
    Username VARCHAR(20) NOT NULL, 
    Email VARCHAR(50) NOT NULL, 
    Passwort VARCHAR(30) NOT NULL, 
    Bio VARCHAR(100), 
    Insta VARCHAR(40), 
    Twitter VARCHAR(40), 
    Soundcloud VARCHAR(40)
);

CREATE OR REPLACE TABLE BPM(
    pk_bpm_id INTEGER PRIMARY KEY
);

CREATE OR REPLACE TABLE KeySignature(
    pk_key_signature_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    root_note VARCHAR(2), 
    Addition VARCHAR(10),
    short VARCHAR(3)
);

CREATE OR REPLACE TABLE UploadType(
    pk_upload_type_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    Name VARCHAR(30)
);

CREATE OR REPLACE TABLE Monetizing(
    pk_monet_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    Name VARCHAR(30)
);

CREATE OR REPLACE TABLE Files(
    pk_files_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    Title VARCHAR(60) NOT NULL, 
    Path VARCHAR(100) NOT NULL, 
    Length TIME NOT NULL, 
    Tag1 VARCHAR(30),
    Tag2 VARCHAR(30),
    Tag3 VARCHAR(30),
    Tag4 VARCHAR(30),
    Tag5 VARCHAR(30), 
    Description VARCHAR(120), 
    fk_user_id INTEGER NOT NULL, 
    fk_bpm_id INTEGER NOT NULL, 
    fk_key_signature_id INTEGER, 
    fk_upload_type_id INTEGER NOT NULL, 
    fk_monet_id INTEGER NOT NULL, 
    CONSTRAINT files_user_id FOREIGN KEY (fk_user_id)
        REFERENCES User(pk_user_id) ON DELETE CASCADE,
    CONSTRAINT files_bpm_id FOREIGN KEY (fk_bpm_id)
        REFERENCES BPM(pk_bpm_id) ON DELETE NO ACTION,
    CONSTRAINT files_key_signature_id FOREIGN KEY (fk_key_signature_id)
        REFERENCES KeySignature(pk_key_signature_id) ON DELETE NO ACTION,
    CONSTRAINT files_upload_type_id FOREIGN KEY (fk_upload_type_id)
        REFERENCES UploadType(pk_upload_type_id) ON DELETE NO ACTION,
    CONSTRAINT files_monet_id FOREIGN KEY (fk_monet_id)
        REFERENCES Monetizing(pk_monet_id) ON DELETE NO ACTION
);

CREATE OR REPLACE TABLE user_liked_file(
    pk_ulf_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    fk_user_id INTEGER, 
    fk_files_id INTEGER,
    CONSTRAINT ulf_user_id FOREIGN KEY (fk_user_id)
        REFERENCES User(pk_user_id) ON DELETE CASCADE,
    CONSTRAINT ulf_files_id FOREIGN KEY (fk_files_id)
        REFERENCES Files(pk_files_id) ON DELETE CASCADE
);
-- 
CREATE OR REPLACE TABLE user_downloaded_file(
    pk_udf_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    fk_user_id INTEGER,
    fk_files_id INTEGER,
    CONSTRAINT udf_user_id FOREIGN KEY (fk_user_id)
        REFERENCES User(pk_user_id) ON DELETE SET NULL,
    CONSTRAINT udf_files_id FOREIGN KEY (fk_files_id)
        REFERENCES Files(pk_files_id) ON DELETE CASCADE
);

CREATE OR REPLACE TABLE user_saved_file(
    pk_usf_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    track_user VARCHAR(20),
    track_title VARCHAR(50),
    fk_user_id INTEGER,
    fk_files_id INTEGER,
     CONSTRAINT usf_user_id FOREIGN KEY (fk_user_id)
        REFERENCES User(pk_user_id) ON DELETE CASCADE,
    CONSTRAINT usf_saved_id FOREIGN KEY (fk_files_id)
        REFERENCES Files(pk_files_id) ON DELETE SET NULL
);

CREATE OR REPLACE TABLE AcceptanceQueue(
    pk_acceptance_queue_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    Status VARCHAR(20), 
    Description VARCHAR(30), 
    fk_files_id INTEGER,
    CONSTRAINT acceptance_queue_files_id FOREIGN KEY (fk_files_id)
        REFERENCES Files(pk_files_id) ON DELETE CASCADE
);

CREATE OR REPLACE TABLE Feed(
    pk_feed_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    fk_files_id INTEGER,
    CONSTRAINT feed_files_id FOREIGN KEY (fk_files_id)
        REFERENCES Files(pk_files_id) ON DELETE CASCADE
);


#----------------------TESTDATA------------------------

#-- Procedure to create BPM Values

CREATE OR REPLACE PROCEDURE bpmValues()
BEGIN
DECLARE v_counter INTEGER;
    SET v_counter = 30;
  WHILE v_counter <= 240 DO
  INSERT INTO bpm (pk_bpm_id) VALUE  (v_counter);
  SET v_counter = v_counter + 1;
  END WHILE;
END;

INSERT INTO user (FirstName, LastName, Username, Email, Passwort, Bio, Insta, Twitter, Soundcloud)
    VALUES ('Hans', 'Peter', 'hp', 'hp@gmail.com', '12345', 'I am Hans Peter', 'hansPeter123', 'hansPeter123', 'hansPeter123'),
            ('Hans', 'Peter2', 'hp2', 'hp2@gmail.com', '12345', 'I am Hans Peter 2', 'hansPeter2123', 'hansPeter2123', 'hansPeter2123');
CALL bpmValues();
INSERT INTO `keysignature` (`pk_key_signature_id`, `root_note`, `Addition`) 
    VALUES (NULL, 'C', 'Major'), 
            (NULL, 'C', 'minor');
INSERT INTO `uploadtype` (`pk_upload_type_id`, `Name`) 
    VALUES (NULL, 'Beat'), 
            (NULL, 'Sample'), 
            (NULL, 'Snippet');
INSERT INTO `monetizing` (`pk_monet_id`, `Name`) 
    VALUES (NULL, 'Free for Profit'), 
            (NULL, 'Tagged');
INSERT INTO `files` (`pk_files_id`, `Title`, `Path`, `Length`, `Tag1`, `Tag2`, `Tag3`, `Tag4`, `Tag5`, `Description`, `fk_user_id`, `fk_bpm_id`, `fk_key_signature_id`, `fk_upload_type_id`, `fk_monet_id`) 
    VALUES (NULL, 'Dummy1', 'dummy1', '00:03:02', 'hip', 'dirty', 'quirky', 'corny', 'sad', 'fucking lit', '24', '69', '1', '1', '1');


#----------------------Data Definition Statements------------------------

#-- Procedure to create User
#-- Output: 0-infinity -> User ID
#--         -1 -> username taken
#--         -2 -> email taken
#--         -3 -> non valid email
#--         -4 -> username is valid email
#--         -5 -> first name non valid
#--         -6 -> last name non valid
#--         -7 -> username non valid
#--         -8 -> passwords doesnt match
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
    DECLARE v_usernameMailCheck INT;

    SELECT COUNT(pk_user_id) INTO v_usernameCheck FROM user
    WHERE Username = p_username;
    SELECT COUNT(pk_user_id) INTO v_mailCheck FROM user
    WHERE Email = p_email;
    
    SELECT p_first_name REGEXP "^[a-zA-ZÄÜÖäüö]+$" INTO v_firstName_pattern;
    SELECT p_last_name REGEXP "^[a-zA-ZÄÜÖäüö]+$" INTO v_lastName_pattern;
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

#-- Procedure to login
#-- Output: 0-infinity -> User ID
#--         -1 -> input doesnt match any, no such user
#--         -2 -> input is taken as both
#--         -3 -> else
#--         -4 -> password incorrect

#-- Frage: wollen wir wenn zb Passwort falsch ist hinschreiben: 'Passwort falsch' oder 'Falsche Eingabe'
#-- Passwort falsch is zwar für den user per se angenehmer aber ist für bösewichte hilfreich, leichter in andere accs zu kommen...

CREATE OR REPLACE PROCEDURE loginUser(
    IN `p_input` VARCHAR(50), 
    IN `p_passwort` VARCHAR(30), 
    OUT `p_id` INT) 
    BEGIN
    DECLARE v_usernameCheck INT;
    DECLARE v_validEmail INT;
    DECLARE v_mailCheck INT;
    DECLARE v_corrPassword INT;

    SELECT COUNT(pk_user_id) INTO v_usernameCheck FROM user
    WHERE Username = p_input;
    SELECT p_input REGEXP "[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" INTO v_validEmail; 
    SELECT COUNT(pk_user_id) INTO v_mailCheck FROM user
    WHERE Email = p_input;

    IF (v_usernameCheck != 1 AND v_mailCheck != 1) THEN
        SET p_id = -1;
    ELSEIF (v_usernameCheck = 1 AND v_mailCheck = 1) THEN
        SET p_id = -2;
    ELSEIF (v_validEmail = 1 AND v_mailCheck = 1) THEN
        SELECT pk_user_id INTO p_id FROM user WHERE Email = p_input;
    ELSEIF (v_validEmail = 0 AND v_usernameCheck = 1) THEN
        SELECT pk_user_id INTO p_id FROM user WHERE Username = p_input;
    ELSE
        SET p_id = -3;
    END IF;

    IF (p_id > 0) THEN
        SELECT Passwort INTO v_corrPassword FROM user WHERE pk_user_id = p_id;
    END IF;

    IF (p_passwort != v_corrPassword) THEN
        SET p_id = -4;
    END IF;
END;
