 CREATE OR REPLACE PROCEDURE addTrack(
    IN `p_title` VARCHAR(60),
    IN `p_length` TIME,
    IN `p_tag1` VARCHAR(30),
    IN `p_tag2` VARCHAR(30),
    IN `p_tag3` VARCHAR(30),
    IN `p_tag4` VARCHAR(30),
    IN `p_tag5` VARCHAR(30),
    IN `p_description` VARCHAR(120),
    IN `p_user_id` INTEGER,
    IN `p_bpm` INTEGER,
    IN `p_key` INTEGER,
    IN `p_type`INTEGER,
    IN `p_monet` INTEGER,
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
        SET p_id = p_id +1;

        SET v_path_name = CONCAT(p_id, '#', LEFT(p_title , 10), '.mp3'); 

        INSERT INTO `files` (`Title`, `Path`, `Length`, `Tag1`, `Tag2`, `Tag3`, `Tag4`, `Tag5`, `Description`, `fk_user_id`, `fk_bpm_id`, `fk_key_signature_id`, `fk_upload_type_id`, `fk_monet_id`) 
            VALUES (p_title, v_path_name, p_length, p_tag1, p_tag2, p_tag3, p_tag4, p_tag5, p_description, p_user_id, p_bpm, v_key_id, v_upload_type, v_monet);
    END IF;
END;