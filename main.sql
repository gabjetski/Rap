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
    Description VARCHAR(200), 
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
INSERT INTO `user` (`pk_user_id`, `FirstName`, `LastName`, `Username`, `Email`, `Passwort`, `Bio`, `Insta`, `Twitter`, `Soundcloud`) 
    VALUES (1, 'Guest', 'Guest', 'guest', 'guest', 'guest', NULL, NULL, NULL, NULL);
INSERT INTO user (FirstName, LastName, Username, Email, Passwort, Bio, Insta, Twitter, Soundcloud)
    VALUES ('Hans', 'Peter', 'hp', 'hp@gmail.com', '12345', 'I am Hans Peter', 'hansPeter123', 'hansPeter123', 'hansPeter123'),
            ('Hans', 'Peter2', 'hp2', 'hp2@gmail.com', '12345', 'I am Hans Peter 2', 'hansPeter2123', 'hansPeter2123', 'hansPeter2123'),
            ('fName', 'lName', 'user', 'email@mail.com', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL);
CALL bpmValues();

# -- TODO Nochmal überprüfen mit index.php Zeile 284 beginnend, 4 Augen Prinzip ^^ 
INSERT INTO `keysignature` (`pk_key_signature_id`, `root_note`, `Addition`, `short`) 
    VALUES (NULL, 'C', 'Major', 'C'), 
            (NULL, 'C', 'minor', 'Cm'),
            (NULL, 'Db', 'Major', 'Db'), 
            (NULL, 'C#', 'minor', 'C#m'),
            (NULL, 'D', 'Major', 'D'), 
            (NULL, 'D', 'minor', 'Dm'),
            (NULL, 'E', 'Major', 'Eb'), 
            (NULL, 'D#', 'minor', 'D#m'),
            (NULL, 'E', 'Major', 'E'),
            (NULL, 'E', 'minor', 'Em'),
            (NULL, 'F', 'Major', 'F'), 
            (NULL, 'F', 'minor', 'Fm'),
            (NULL, 'G', 'Major', 'Gb'), 
            (NULL, 'F#', 'minor', 'F#m'),
            (NULL, 'G', 'Major', 'G'), 
            (NULL, 'G', 'minor', 'Gm'),
            (NULL, 'Ab', 'Major', 'Ab'), 
            (NULL, 'G#', 'minor', 'G#m'),
            (NULL, 'A', 'Major', 'A'), 
            (NULL, 'A', 'minor', 'Am'),
            (NULL, 'Bb', 'Major', 'Bb'), 
            (NULL, 'A#', 'minor', 'A#m'),
            (NULL, 'B', 'Major', 'B'), 
            (NULL, 'B', 'minor', 'Bm');

INSERT INTO `uploadtype` (`pk_upload_type_id`, `Name`) 
    VALUES (NULL, 'Beat'), 
            (NULL, 'Sample'), 
            (NULL, 'Snippet');
INSERT INTO `monetizing` (`pk_monet_id`, `Name`) 
    VALUES (NULL, 'Free for Profit'), 
            (NULL, 'Tagged');
INSERT INTO `files` (`pk_files_id`, `Title`, `Path`, `Length`, `Tag1`, `Tag2`, `Tag3`, `Tag4`, `Tag5`, `Description`, `fk_user_id`, `fk_bpm_id`, `fk_key_signature_id`, `fk_upload_type_id`, `fk_monet_id`) 
    VALUES (1, 'Test', '1#Test.mp3', '00:04:20', '', NULL, NULL, NULL, NULL, '', 3, 123, 1, 1, 1),
            (2, 'Â²Â³$$&amp;%Â§@â‚¬', '2#.mp3', '00:04:20', '', NULL, NULL, NULL, NULL, '', 3, 123, 1, 1, 1),
            (3, 'Testt5itelderlangeistsehrlange,sehr,sehr,lange', '3#Testt5itel.mp3', '00:04:20', '', NULL, NULL, NULL, NULL, '', 3, 123, 14, 1, 1),
            (4, 'R u dumb, stupid or dumb huh', '4#R u dumb, .mp3', '00:04:20', 'R u dumb, stupid or dumb huh ', ' R u ', NULL, NULL, NULL, 'R u dumb, stupid or dumb huh', 3, 123, 1, 1, 1);

INSERT INTO `user_downloaded_file` (`pk_udf_id`, `fk_user_id`, `fk_files_id`) 
    VALUES (NULL, '1', '1'), 
            (NULL, '2', '1');


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


#-- Procedure to add Track
#-- Output: 0-infinity -> Track ID
#--         -1 -> 
#--         -2 -> 
#--         -3 -> 
#--         -4 -> 


 CREATE OR REPLACE PROCEDURE addTrack(
    IN `p_title` VARCHAR(60),
    IN `p_title_replaced` VARCHAR(30),
    IN `p_length` TIME,
    IN `p_tag1` VARCHAR(30),
    IN `p_tag2` VARCHAR(30),
    IN `p_tag3` VARCHAR(30),
    IN `p_tag4` VARCHAR(30),
    IN `p_tag5` VARCHAR(30),
    IN `p_description` VARCHAR(200),
    IN `p_user_id` INTEGER,
    IN `p_bpm` INTEGER,
    IN `p_key` VARCHAR(30),
    IN `p_type`VARCHAR(30),
    IN `p_monet` VARCHAR(30),
    OUT `p_id` INT)
    BEGIN
    DECLARE v_bpm_if INT;
    DECLARE v_title_pattern INT;
    DECLARE v_file_name_pattern INT;
    DECLARE v_description_pattern INT;
    
    DECLARE v_key_id INT;
    DECLARE v_upload_type INT;
    DECLARE v_monet INT;

    DECLARE v_path_name VARCHAR(30);
    
    SELECT p_title REGEXP "^.{0,60}$" INTO v_title_pattern;
    SELECT p_description REGEXP "^.{0,120}$" INTO v_description_pattern;
    #--SELECT p_path REGEXP "^[[:word:]\-. ]+\.(mp3)$" INTO v_file_name_pattern;

    IF (p_bpm >= 30 AND p_bpm <= 240) THEN
        SET v_bpm_if = 0;
    ELSE 
        SET v_bpm_if = 1;
    END IF;
    CASE p_type
      WHEN 'beat' THEN SET v_upload_type = 1; 
      WHEN 'sample' THEN SET v_upload_type = 2; 
      WHEN 'snippet' THEN SET v_upload_type = 3; 
      ELSE SET v_upload_type = -1; 
    END CASE;
    CASE p_monet
      WHEN 'f4p' THEN SET v_monet = 1; 
      WHEN 'tagged' THEN SET v_monet = 2;
      ELSE SET v_monet = -1; 
    END CASE;
    #--SQL hats nd so mit case sensitivity, maybe value C bei C Major
    SELECT pk_key_signature_id INTO v_key_id FROM keysignature WHERE short = p_key LIMIT 1;
    
    IF (v_bpm_if = 1) THEN
        SET p_id = -1;
    ELSEIF (v_title_pattern = 0) THEN
        SET p_id = -2;
    ELSEIF (v_description_pattern = 0) THEN
        SET p_id = -3;
    ELSEIF (v_file_name_pattern = 0) THEN
        SET p_id = -4;
    ELSEIF (v_upload_type < 0) THEN
        SET p_id = -5;
    ELSEIF (v_monet < 0) THEN
        SET p_id = -6;
    ELSEIF (v_key_id < 0) THEN
        SET p_id = -7;
    ELSE

        SELECT pk_files_id INTO p_id FROM files 
        ORDER BY pk_files_id DESC
        LIMIT 1;
        IF (p_id IS NULL) THEN
            SET p_id = 1;
        ELSE 
            SET p_id = p_id +1;
        END IF;

        SET v_path_name = CONCAT(p_id, '#', LEFT(p_title_replaced , 10), '.mp3'); 

        INSERT INTO `files` (`Title`, `Path`, `Length`, `Tag1`, `Tag2`, `Tag3`, `Tag4`, `Tag5`, `Description`, `fk_user_id`, `fk_bpm_id`, `fk_key_signature_id`, `fk_upload_type_id`, `fk_monet_id`) 
            VALUES (p_title, v_path_name, p_length, p_tag1, p_tag2, p_tag3, p_tag4, p_tag5, p_description, p_user_id, p_bpm, v_key_id, v_upload_type, v_monet);
    END IF;
END;

#--CALL addTrack('Dummy1','Dummy1', '00:03:02', 'hip', 'dirty', 'quirky', 'corny', 'sad', 'fucking lit', '1', '69', 'C', 'beat', 'f4p', @id);

#-- Procedure to store download
#-- Output: 0-infinity -> udf ID
#--         -1 -> 
#--         -2 -> 
 CREATE OR REPLACE PROCEDURE download(
    IN `p_track_id` INT,
    IN `p_user_id` INT, 
    OUT `p_id` INT) 
    BEGIN
    DECLARE v_count_track INT;
    DECLARE v_count_user INT;
    DECLARE v_count_same INT;

    SELECT COUNT(pk_files_id) INTO v_count_track FROM files
    WHERE pk_files_id = p_track_id;
    SELECT COUNT(pk_user_id) INTO v_count_user FROM user
    WHERE pk_user_id = p_user_id;
    SELECT COUNT(pk_udf_id) INTO v_count_same FROM user_downloaded_file
    WHERE fk_user_id = p_user_id AND fk_files_id = p_track_id;

    IF (v_count_track != 1) THEN
        SET p_id = -1;
    ELSEIF (v_count_user != 1) THEN
        SET p_id = -2;
    ELSEIF (v_count_same > 0) THEN
        SET p_id = -3;
    ELSE
        INSERT INTO user_downloaded_file (fk_user_id, fk_files_id, time)
            VALUES (p_user_id, p_track_id, SYSDATE());
        SELECT pk_udf_id INTO p_id FROM user_downloaded_file 
        WHERE fk_user_id = p_user_id AND fk_files_id = p_track_id
        ORDER BY pk_udf_id DESC
        LIMIT 1;
    END IF;
END;