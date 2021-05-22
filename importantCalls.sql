use rap;
CALL createUser('Franz','Günther','fg', 'fg@gmail.com', '12345', @id);
CALL loginUser('fg', '12345' @id2);
CALL addTrack('Dummy1','Dummy1','00:03:02', 'hip', 'dirty', 'quirky', 'corny', 'sad', 'fucking lit', '1', '69', 'C', 'beat', 'f4p', @id);
 CALL download(1,1, @id);
