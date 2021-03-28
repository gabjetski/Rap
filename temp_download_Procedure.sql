 CREATE OR REPLACE PROCEDURE download(
    IN `p_track_id` INT,
    IN `p_user_id` INT, 
    OUT `p_id` INT) 
    BEGIN
    DECLARE v_count_track INT;
    DECLARE v_count_user INT;

    SELECT COUNT(pk_files_id) INTO v_count_track FROM files
    WHERE pk_files_id = p_track_id;
    SELECT COUNT(pk_user_id) INTO v_count_user FROM user
    WHERE pk_user_id = p_user_id;
    IF (v_count_track != 1) THEN
        SET p_id = -1;
    ELSEIF (v_count_user != 1) THEN
        SET p_id = -2;
    ELSE
        INSERT INTO user_downloaded_file (fk_user_id, fk_files_id)
            VALUES (p_user_id, p_track_id);
        SELECT pk_udf_id INTO p_id FROM user_downloaded_file 
        WHERE fk_user_id = p_user_id AND fk_files_id = p_track_id
        ORDER BY pk_udf_id DESC
        LIMIT 1;
    END IF;
END;