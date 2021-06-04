#----------------------DATABASE------------------------

DROP DATABASE IF EXISTS rap;
CREATE DATABASE rap;
USE rap;

CREATE OR REPLACE TABLE usertype(
    pk_user_type_id INTEGER PRIMARY KEY,
    description VARCHAR(30)
);
CREATE OR REPLACE TABLE module(
    pk_module_type_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30),
    description VARCHAR(30)
);

CREATE OR REPLACE TABLE Permission(
    pk_permission_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    fk_user_type_id INTEGER,
    fk_module_type_id INTEGER,
    CONSTRAINT permission_user_type FOREIGN KEY (fk_user_type_id) REFERENCES usertype(pk_user_type_id) ON DELETE CASCADE,
    CONSTRAINT permission_module_type FOREIGN KEY (fk_module_type_id) REFERENCES module(pk_module_type_id) ON DELETE CASCADE
);

CREATE OR REPLACE TABLE User(
    pk_user_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    FirstName VARCHAR(50) NOT NULL, 
    LastName VARCHAR(50) NOT NULL, 
    Username VARCHAR(20) NOT NULL, 
    Email VARCHAR(50) NOT NULL, 
    Passwort VARCHAR(40) NOT NULL, 
    Bio VARCHAR(100), 
    Insta VARCHAR(40), 
    Twitter VARCHAR(40), 
    Soundcloud VARCHAR(40),
    YouTube VARCHAR(40),
    Location VARCHAR(40),
    user_added DATETIME,
    fk_user_type_id INTEGER,
    CONSTRAINT user_user_type FOREIGN KEY(fk_user_type_id) REFERENCES usertype(pk_user_type_id) ON DELETE CASCADE 
);
CREATE OR REPLACE TABLE archiveUser(
    pk_user_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    FirstName VARCHAR(50), 
    LastName VARCHAR(50), 
    Username VARCHAR(20), 
    Email VARCHAR(50), 
    Passwort VARCHAR(40), 
    Bio VARCHAR(100), 
    Insta VARCHAR(40), 
    Twitter VARCHAR(40), 
    Soundcloud VARCHAR(40),
    YouTube VARCHAR(40),
    Location VARCHAR(40),
    user_added DATETIME,
    fk_user_type_id INTEGER
    #--archive_date DATETIME
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
    Tag1 VARCHAR(31),
    Tag2 VARCHAR(31),
    Tag3 VARCHAR(31),
    Tag4 VARCHAR(31),
    Tag5 VARCHAR(31), 
    Description VARCHAR(200), 
    fk_user_id INTEGER NOT NULL, 
    fk_bpm_id INTEGER NOT NULL, 
    fk_key_signature_id INTEGER, 
    fk_upload_type_id INTEGER NOT NULL, 
    fk_monet_id INTEGER NOT NULL, 
    file_added DATETIME,
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

CREATE OR REPLACE TABLE archiveFiles(
    pk_files_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    Title VARCHAR(60) NOT NULL, 
    Path VARCHAR(100) NOT NULL, 
    Tag1 VARCHAR(31),
    Tag2 VARCHAR(31),
    Tag3 VARCHAR(31),
    Tag4 VARCHAR(31),
    Tag5 VARCHAR(31), 
    Description VARCHAR(200), 
    fk_user_id INTEGER NOT NULL, 
    fk_bpm_id INTEGER NOT NULL, 
    fk_key_signature_id INTEGER, 
    fk_upload_type_id INTEGER NOT NULL, 
    fk_monet_id INTEGER NOT NULL, 
    file_added DATETIME
    #--archive_date DATETIME
);

CREATE OR REPLACE TABLE user_liked_file(
    pk_ulf_id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    fk_user_id INTEGER, 
    fk_files_id INTEGER,
    like_added DATETIME,
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
    download_added DATETIME,
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
    save_added DATETIME,
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

CREATE OR REPLACE TABLE Milestones(
    pk_milestone_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    required_downloads INTEGER,
    text VARCHAR(30)
);

CREATE OR REPLACE TABLE song_reaches_milestone(
    pk_song_milestone_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    fk_song_id INTEGER,
    fk_milestone_id INTEGER,
    CONSTRAINT srm_song_id FOREIGN KEY (fk_song_id)
        REFERENCES Files(pk_files_id) ON DELETE CASCADE,
    CONSTRAINT srm_milestone_id FOREIGN KEY (fk_milestone_id)
        REFERENCES Milestones(pk_milestone_id) ON DELETE CASCADE
);


#----------------------TESTDATA------------------------

#-- Procedure to create BPM Values

CREATE OR REPLACE PROCEDURE bpmValues()
BEGIN
DECLARE v_counter INTEGER;
    SET v_counter = 1;
  WHILE v_counter <= 999 DO
  INSERT INTO bpm (pk_bpm_id) VALUE  (v_counter);
  SET v_counter = v_counter + 1;
  END WHILE;
END;
INSERT INTO `module` (`pk_module_type_id`, `name`, `description`) VALUES (NULL, 'download', 'download von track'), (NULL, 'upload', 'upload von track'), (NULL, 'loginRegister', 'kann sich der User einloggen oder ist er schon'), (NULL, 'editSongs', 'able to edit all songs'), (NULL, 'editOwnSongs', 'able to edit own songs'), (NULL, 'editUsers', 'able to edit all users'), (NULL, 'editOwnUser', 'able to edit own user');
INSERT INTO `usertype` (`pk_user_type_id`, `description`) VALUES ('0', 'gast'), ('1', 'user'), ('2', 'admin');
INSERT INTO `permission` (`pk_permission_id`, `fk_user_type_id`, `fk_module_type_id`) VALUES (NULL, '0', '1'),(NULL, '0', '3'), (NULL, '1', '2'), (NULL, '1', '1'), (NULL, '1', '5'), (NULL, '1', '7'), (NULL, '2', '1'),(NULL, '2', '4'),(NULL, '2', '5'),(NULL, '2', '6'),(NULL, '2', '7');

INSERT INTO `user` (`pk_user_id`, `FirstName`, `LastName`, `Username`, `Email`, `Passwort`, `Bio`, `Insta`, `Twitter`, `Soundcloud`, `fk_user_type_id`) 
    VALUES (1, 'Guest', 'Guest', 'guest', 'guest', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL, 0);
INSERT INTO user (FirstName, LastName, Username, Email, Passwort, Bio, Insta, Twitter, Soundcloud, `fk_user_type_id`)
    VALUES ('Hans', 'Peter', 'hp', 'hp@gmail.com', 'b8736f4de6612d55c73c9648093ba0', 'I am Hans Peter', 'hansPeter123', 'hansPeter123', 'hansPeter123', 2),
            ('Hans', 'Peter2', 'hp2', 'hp2@gmail.com', 'b8736f4de6612d55c73c9648093ba0', 'I am Hans Peter 2', 'hansPeter2123', 'hansPeter2123', 'hansPeter2123', 1),
            ('fName', 'lName', 'user', 'email@mail.com', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL, 1),
            ('fName', 'lName', 'user2', 'email2@mail.com', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL, 1),
            ('fName', 'lName', 'user3', 'email3@mail.com', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL, 1),
            ('fName', 'lName', 'user4', 'email4@mail.com', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL, 1),
            ('fName', 'lName', 'user5', 'email5@mail.com', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL, 1),
            ('fName', 'lName', 'user6', 'email6@mail.com', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL, 1),
            ('fName', 'lName', 'user7', 'email7@mail.com', 'b8736f4de6612d55c73c9648093ba0', NULL, NULL, NULL, NULL, 1);
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
            (NULL, 'Gb', 'Major', 'Gb'), 
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
INSERT INTO `files` (`pk_files_id`, `Title`, `Path`, `Tag1`, `Tag2`, `Tag3`, `Tag4`, `Tag5`, `Description`, `fk_user_id`, `fk_bpm_id`, `fk_key_signature_id`, `fk_upload_type_id`, `fk_monet_id`) 
    VALUES (1, 'Test', '1#Test.mp3','', NULL, NULL, NULL, NULL, '', 2, 123, 1, 1, 1),
            (2, 'Â²Â³$$&amp;%Â§@â‚¬', '2#.mp3', '', NULL, NULL, NULL, NULL, '', 3, 123, 1, 1, 1),
            (3, 'Testt5itelderlangeistsehrlange,sehr,sehr,lange', '3#Testt5itel.mp3', '', NULL, NULL, NULL, NULL, '', 4, 123, 14, 1, 1),
            (4, 'R u dumb, stupid or dumb huh', '4#R u dumb, .mp3', '#R u dumb stupid or dumb huh ', '#R u ', NULL, NULL, NULL, 'R u dumb, stupid or dumb huh', 4, 123, 1, 1, 1);

-- INSERT INTO `user_downloaded_file` (`pk_udf_id`, `fk_user_id`, `fk_files_id`) 
--     VALUES (NULL, '1', '1'), 
--             (NULL, '2', '1');

INSERT INTO Milestones (pk_milestone_id, required_downloads, text)
    VALUES (NULL, '3', '3 Downloads'),
           (NULL, '10', '10 Downloads'),
           (NULL, '50', '50 Downloads'),
           (NULL, '100', '100 Downloads'),
           (NULL, '500', '500 Downloads');

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
    IN `p_first_name` VARCHAR(50), 
    IN `p_last_name` VARCHAR(50), 
    IN `p_username` VARCHAR(20), 
    IN `p_email` VARCHAR(50), 
    IN `p_passwort` VARCHAR(40), 
    IN `p_passwort_sec` VARCHAR(40), 
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
            INSERT INTO USER (FirstName, LastName, Username, Email, Passwort, user_added)
            VALUES (p_first_name, p_last_name, p_username, p_email, p_passwort,NOW());
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
    IN `p_passwort` VARCHAR(40), 
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
#--         -1 -> BPM is out of range or not valid
#--         -2 -> title non valid
#--         -3 -> description non valid
#--         -4 -> filename non valid
#--         -5 -> error with uploadtype
#--         -6 -> error with monettype
#--         -7 -> error with key


 CREATE OR REPLACE PROCEDURE addTrack(
    IN `p_title` VARCHAR(60),
    IN `p_title_replaced` VARCHAR(30),
    IN `p_tag1` VARCHAR(31),
    IN `p_tag2` VARCHAR(31),
    IN `p_tag3` VARCHAR(31),
    IN `p_tag4` VARCHAR(31),
    IN `p_tag5` VARCHAR(31),
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
    DECLARE v_tag1_pattern INT;
    DECLARE v_tag2_pattern INT;
    DECLARE v_tag3_pattern INT;
    DECLARE v_tag4_pattern INT;
    DECLARE v_tag5_pattern INT;
    DECLARE v_tags_pattern INT;
    
    DECLARE v_key_id INT;
    DECLARE v_upload_type INT;
    DECLARE v_monet INT;

    DECLARE v_path_name VARCHAR(30);
    
    SELECT p_title REGEXP "^.{0,60}$" INTO v_title_pattern;
    SELECT p_description REGEXP "^.{0,120}$" INTO v_description_pattern;

    SELECT p_tag1 REGEXP "((\#(\w){0,30})|.{0})$" INTO v_tag1_pattern;
    SELECT p_tag2 REGEXP "((\#(\w){0,30})|.{0})$" INTO v_tag2_pattern;
    SELECT p_tag3 REGEXP "((\#(\w){0,30})|.{0})$" INTO v_tag3_pattern;
    SELECT p_tag4 REGEXP "((\#(\w){0,30})|.{0})$" INTO v_tag4_pattern;
    SELECT p_tag5 REGEXP "((\#(\w){0,30})|.{0})$" INTO v_tag5_pattern;

    SET v_tags_pattern = v_tag1_pattern + v_tag2_pattern + v_tag3_pattern + v_tag4_pattern + v_tag5_pattern;



    
    #-- FIXME filename-pattern: SELECT p_path REGEXP "^[[:word:]\-. ]+\.(mp3)$" INTO v_file_name_pattern;

    IF (p_bpm >= 0 AND p_bpm <= 1000) THEN
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
    ELSEIF (v_tags_pattern < 5) THEN
        SET p_id = -8;
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

        INSERT INTO `files` (`Title`, `Path`, `Tag1`, `Tag2`, `Tag3`, `Tag4`, `Tag5`, `Description`, `fk_user_id`, `fk_bpm_id`, `fk_key_signature_id`, `fk_upload_type_id`, `fk_monet_id`, file_added) 
            VALUES (p_title, v_path_name, p_tag1, p_tag2, p_tag3, p_tag4, p_tag5, p_description, p_user_id, p_bpm, v_key_id, v_upload_type, v_monet, NOW());
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
    DECLARE v_count_download_new INT;
    DECLARE v_i INT;
    DECLARE v_milestone INT;
    DECLARE v_milestone_id INT;

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
    ELSEIF (v_count_same > 0 AND p_user_id != 1) THEN
        SET p_id = -3;
    ELSE
        INSERT INTO user_downloaded_file (fk_user_id, fk_files_id, download_added)
            VALUES (p_user_id, p_track_id, SYSDATE());
        SELECT pk_udf_id INTO p_id FROM user_downloaded_file 
        WHERE fk_user_id = p_user_id AND fk_files_id = p_track_id
        ORDER BY pk_udf_id DESC
        LIMIT 1;

    SELECT COUNT(pk_udf_id) FROM user_downloaded_file WHERE fk_files_id = p_track_id INTO v_count_download_new;
    SET v_count_download_new = v_count_download_new+1;
    SET v_i = 1;
    -- loop_label: loop
    --     SELECT COUNT(pk_milestone_id) FROM Milestones WHERE required_downloads = v_i INTO v_milestone;
    --     IF (v_milestone = 1) THEN
    --         SELECT pk_milestone_id FROM Milestones WHERE required_downloads = v_i INTO v_milestone_id;
    --         INSERT INTO song_reaches_milestone (pk_song_milestone_id, fk_song_id, fk_milestone_id)
    --             VALUES (NULL, p_track_id, v_milestone_id);
    --     END IF;
    --     if (v_i >= v_count_download_new) THEN
    --         LEAVE loop_label;
    --     END IF;
    --     SET v_i = v_i + 1;
    -- end loop;
        SELECT COUNT(pk_milestone_id) FROM Milestones WHERE required_downloads = v_count_download_new INTO v_milestone;
        IF (v_milestone = 1) THEN
            SELECT pk_milestone_id FROM Milestones WHERE required_downloads = v_count_download_new INTO v_milestone_id;
            INSERT INTO song_reaches_milestone (pk_song_milestone_id, fk_song_id, fk_milestone_id)
                VALUES (NULL, p_track_id, v_milestone_id);
        END IF;
    -- WHILE v_i <= v_count_download_new
    -- BEGIN
    --     SELECT COUNT(pk_milestone_id) FROM Milestones WHERE required_downloads = v_i INTO v_milestone;
    --     IF (v_milestone = 1) THEN
    --         SELECT pk_milestone_id FROM Milestones WHERE required_downloads = v_i INTO v_milestone_id;
    --         INSERT INTO song_reaches_milestone (pk_song_milestone_id, fk_song_id, fk_milestone_id)
    --             VALUES (NULL, p_track_id, v_milestone_id);
    --     END IF;
    --     SET v_i = v_i + 1;
    -- END;
    END IF;
END;