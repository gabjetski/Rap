<?php
function filter(&$value)
{
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
//htmlspecialchar Get Array to store it safely
array_walk_recursive($_GET, "filter");

if ($_GET['input'] == '') {
    $_SESSION['loginError']['id'] = '-11';
    $_SESSION['loginError']['get'] = $_GET;
    header('Location:/home');
} elseif ($_GET['psw'] == '') {
    $_SESSION['loginError']['id'] = '-12';
    $_SESSION['loginError']['get'] = $_GET;
    header('Location:/home');
} else {
    //Prepare Procedure call
    $stmtLoginUser = $pdo->prepare("CALL loginUser(?, ?, @id)");
    //define the in-parameters
    $stmtLoginUser->bindParam(1, $_GET['input'], PDO::PARAM_STR, 5000);
    $stmtLoginUser->bindParam(2, sha1($_GET['psw']), PDO::PARAM_STR, 4000);

    // 调用存储过程  !!Wichtig!!
    $stmtLoginUser->execute();

    //Select the out parameter into variable
    $sql = "SELECT @id AS id";
    $stmtGetId = $pdo->prepare($sql);
    $stmtGetId->execute();
    foreach ($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $id = $row['id'];
    }

    //check if id is negative which means an error is thrown
    if ($id < 0) {
        $_SESSION['loginError']['id'] = $id;
        $_SESSION['registerError']['get'] = $_GET;
        header('Location:/home');
    }
    //else log in
    else {
        $_SESSION['userID'] = $id;
        unset($_SESSION['loginError']['id']);
        unset($_SESSION['registerError']['id']);
        header('Location:/home');
    }
}
