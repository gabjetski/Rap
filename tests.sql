use rap;
CALL createUser('Franz','Günther','fg', 'fg@gmail.com', '12345', '12345' @id);
CALL loginUser('fg', '12345' @id2);

#-- Register User                   -------------------------------------------------
#-- Output: 0-infinity -> User ID (bei Yes)
#--         -1 bedeutet -> username taken
#--         -2 bedeutet -> email taken
#--         -3 bedeutet -> non valid email
#--         -4 bedeutet -> username is valid email
#--         -5 bedeutet -> passwords doesnt match (and others so far)

#-- Procedure to create User
#-- Output: 0-infinity -> User ID
#--         -1 bedeutet -> username taken
#--         -2 bedeutet -> email taken
#--         -3 bedeutet -> non valid email
#--         -4 bedeutet -> username is valid email
#--         -5 bedeutet -> first name non valid
#--         -6 bedeutet -> last name non valid
#--         -7 bedeutet -> username non valid
#--         -8 bedeutet -> passwords doesnt match

CALL createUser('Franz','Günther','fg1', 'fg@gmail.com', '12345', '12345', @id); -- -> Yes
SELECT @id;
CALL createUser('ADASD','DFDSAF','DDASFD', 'fg2@gmail.com', '', 'as', @id); -- -> No -5
SELECT @id;
CALL createUser('SDDS','ADSF','FDSA2', 'fg@gmai', '12345', '12345', @id); -- -> No -3
SELECT @id;

CALL createUser('keine', 'email', 'Goat', 'sjeklf.com', 'abc', 'abc', @id); -- -> NO - 3
SELECT @id;

CALL createUser('wer', '12423', 'fg1', 'sefewf@gmail.com', 'wefewfwew', 'wefewfwew', @id); -- -> NO - 1
SELECT @id;

CALL createUser('werwe', 'werjew', 'fg2', 'fgs@gmail.com', 'abcdef', 'abcdef', @id); -- -> NO - 2
SELECT @id;

CALL createUser('qwer', 'sadf', 'fg@gmail.com', 'fgggg@gmail.com', 'xxx', 'xxx', @id); -- -> NO - 4
SELECT @id;

CALL createUser('short', 'password', 'shortPassword', 'sp@gmx.at', '1', '1', @id); -- -> NO - 
SELECT @id;


#-- LoginUser                   -----------------------------------------------------
#-- Output: 0-infinity -> User ID (bei Yes)
#--         -1 bedeutet -> input doesnt match any, no such user
#--         -2 bedeutet -> input is taken as both
#--         -3 bedeutet -> else
#--         -4 bedeutet -> password incorrect

CALL loginUser('fg1', '12345' @idL); -- -> Yes
SELECT @idL;
CALL loginUser('', '12345' @idL); -- -> No -1
SELECT @idL;
CALL loginUser('fg1', '12' @idL); -- -> No -4
SELECT @idL;
...

CALL loginUser('fg@gmail.com', '' @idL); -- -> No -1
SELECT @idL;

CALL loginUser('', '' @idL); -- -> No -1
SELECT @idL;

e