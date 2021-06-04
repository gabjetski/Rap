<?php
if (Permissions::permission($_SESSION['userID'], 3)) {
    require_once 'php/logRegForms.php';
    echo '<button class="openForm" onclick="openLogin()">Log In/Register</button>';
    echo '<i class="fa fa-upload fa-3x" onclick="openUploadLogin()"></i>';
}
//show username and id if logged in
elseif (!Permissions::permission($_SESSION['userID'], 3)) {
    $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = " . $_SESSION['userID']);
    $stmntGetUserInfos->execute();
    foreach ($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $_SESSION['userUName'] = $row['Username'];
    }
    $notis = new Notification($_SESSION['userID']);
    echo '
    <script src="global.js" defer></script>
    <div id="dropMenu">
      <div class="dropContainer">

        <div id="navToggle" class="nav-toggle">
          <a href="user/my"><div class="openForm">' . $_SESSION['userID'] . ' - ' . $_SESSION['userUName'];
    if ($notis->getCount()) {
        echo '<b class="notisBubble">' . $notis->getCount() . '</b>';
    }
    echo '</div></a>
        </div>


        <div id="dropNav" class="dropNav">
          <ul id="list">
            <li class="dropList">
              <h3> <a href="user/my"> View Profile </a></h3>
            </li>
            <li class="dropList">
              <h3> <a href="user/my/settings"> Settings </a></h3>
            </li>
            <li class="dropList">
              <h3>
                <button type="button" onclick="openNotisForm()">Notifications';
    if ($notis->getCount()) {
        echo '<b class="notisBubble">' . $notis->getCount() . '</b>';
    }
    echo '</button>
              </h3>
            </li>
            <li class="dropList">
              <h3>
                <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="get" class="form-container">
                  <input type="submit" value="Log Out" name="logout">
                </form>
              </h3>
            </li>
          </ul>
        </div>

      </div>
    </div>
    ';

    echo $notis->getPopup();

    //TODO reopen notifications on delete
    // if (isset($_SESSION['delNoti'])) {
    //     echo "<script>window.onload = function(){document.getElementById(\"notisForm\").style.display=\"block\"}</script>";
    //     // unset($_SESSION['delNoti']);
    // }
}
