<?php
if (isset($_GET['searchButton'])) {
  $keyword = $_GET['searchTerm'];
  echo "<br>";
  print_r("KEYWORD: " . $keyword);
  $stmntGetUsernames = $pdo->prepare("SELECT Username, pk_user_id FROM user where Username like :keyword");
  $keyword = "%" . $keyword . "%";
  $stmntGetUsernames->bindParam(':keyword', $keyword, PDO::PARAM_STR);
  echo "<br>";
  $stmntGetUsernames->execute();

  // WHILE ODER FOR EACH???? bitte foreach
  // while ($row = $stmntGetUsernames->fetch()) {
  //     echo "Alle Usernames: <a href=\"http://{$_SERVER['SERVER_NAME']}/user/{$row['pk_user_id']}\">" . $row['Username']. "</a><br />\n";
  // }
  // If keyword empty

  // Pfeil zurück Ideen für Output Seite
}
