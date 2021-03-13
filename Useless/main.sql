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
    root_note VARCHAR(1), 
    Addition VARCHAR(10)
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
    Title VARCHAR(50) NOT NULL, 
    Path VARCHAR(100) NOT NULL, 
    Length TIME NOT NULL, 
    Tag1 VARCHAR(30),
    Tag2 VARCHAR(30),
    Tag3 VARCHAR(30),
    Tag4 VARCHAR(30),
    Tag5 VARCHAR(30), 
    Description VARCHAR(30), 
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

