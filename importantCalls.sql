use rap;
CALL createUser('Franz','Günther','fg', 'fg@gmail.com', '12345', @id);
CALL loginUser('fg', '12345' @id2);
