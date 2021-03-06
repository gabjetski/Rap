<?php
//htmlspecialchar Get Array to store it safely
array_walk_recursive($_GET, "filter");

if($_GET['firstName'] == ''){
    $_SESSION['registerError']['id'] = '-11';
    $_SESSION['registerError']['get'] = $_GET;
    header('Location:index.php');
}elseif($_GET['lastName'] == ''){
    $_SESSION['registerError']['id'] = '-12';
    $_SESSION['registerError']['get'] = $_GET;
    header('Location:index.php');
}elseif($_GET['username'] == ''){
    $_SESSION['registerError']['id'] = '-13';
    $_SESSION['registerError']['get'] = $_GET;
    header('Location:index.php');
}elseif($_GET['email'] == ''){
    $_SESSION['registerError']['id'] = '-14';
    $_SESSION['registerError']['get'] = $_GET;
    header('Location:index.php');
}elseif($_GET['psw'] == ''){
    $_SESSION['registerError']['id'] = '-15';
    $_SESSION['registerError']['get'] = $_GET;
    header('Location:index.php');
}elseif($_GET['tos'] == ''){
    $_SESSION['registerError']['id'] = '-16';
    $_SESSION['registerError']['get'] = $_GET;
    header('Location:index.php');
}else


//check if password match Validations (Password-Validation already here and not in SQL cause the database only gets it hashed [shq])
if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.\-ÄÜÖäüö]{7,30}$/',$_GET['psw'])) {
    //Prepare Procedure call
    $stmtCreateUser = $pdo->prepare("CALL createUser(?, ?, ?, ?, ?, ?, @id)");
    //define the in-parameters
    $stmtCreateUser->bindParam(1, $_GET['firstName'], PDO::PARAM_STR, 4000);
    $stmtCreateUser->bindParam(2, $_GET['lastName'], PDO::PARAM_STR, 4000);
    $stmtCreateUser->bindParam(3, $_GET['username'], PDO::PARAM_STR, 4000);
    $stmtCreateUser->bindParam(4, $_GET['email'], PDO::PARAM_STR, 5000);
    $stmtCreateUser->bindParam(5, sha1($_GET['psw']), PDO::PARAM_STR, 4000);
    $stmtCreateUser->bindParam(6, sha1($_GET['psw-repeat']), PDO::PARAM_STR, 4000);

    // 调用存储过程  !!Wichtig!!
    $stmtCreateUser->execute();

    //Select the out parameter into variable
    $sql = "SELECT @id AS id";
    $stmtGetId = $pdo->prepare($sql);
    $stmtGetId->execute();
    foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
        $id = $row['id'];
    }
    //check if id is negative which means an error is thrown
    if ($id < 0) {
        $_SESSION['registerError']['id'] = $id;
        $_SESSION['registerError']['get'] = $_GET;
        header('Location:index.php');
    }
    //else log in
    else{
        $_SESSION['userID'] = $id;
        unset($_SESSION['registerError']['id']);
        unset($_SESSION['loginError']['id']);
        unset($_SESSION['registerError']['get']);
        header('Location:index.php');
    }
}
//if password doesnt match validations
else{
//also set error
$_SESSION['registerError']['id'] = '-10';
$_SESSION['registerError']['get'] = $_GET;
header('Location:index.php');
}