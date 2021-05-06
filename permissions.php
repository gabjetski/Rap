<?php
class permissions
{
    function permission($userId, $module)
    {
        $pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
        $stmntGetPermission = $pdo->prepare("SELECT * FROM `permission` 
        INNER JOIN usertype ON usertype.pk_user_type_id = fk_user_type_id 
        INNER JOIN user ON usertype.pk_user_type_id = user.fk_user_type_id
        WHERE pk_user_id = :usid AND fk_module_type_id = :mod ");
        $stmntGetPermission->bindParam('usid', $userId);
        $stmntGetPermission->bindParam('mod', $module);
        $stmntGetPermission->execute();
        // return $userType;
        if ($stmntGetPermission->rowCount() >= 1) {
            return true;
        } else {
            return false;
        }
    }
}
