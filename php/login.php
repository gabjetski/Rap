<?php
//htmlspecialchar Get Array to store it safely
array_walk_recursive($_GET, "filter");

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
foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
    $id = $row['id'];
}

//check if id is negative which means an error is thrown
if ($id < 0) {
    $_SESSION['loginError'] = $id;
    $_SESSION['errGet'] = $_GET;
    header('Location:index.php');
}
//else log in
else{
    $_SESSION['userID'] = $id;
    unset($_SESSION['loginError']);
    unset($_SESSION['registerError']);
    header('Location:index.php');
}