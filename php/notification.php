<div id="notisForm">
    <div class="blocker" onclick="closeNotisForm()"></div>
    <div class="form-popup notisFormular">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <h1>Bitte Notifications </h1>
            <div>
                <!-- Username bzw. Email Adresse -->
                <label><b> Notifications: </b></label>
                <ul>
                    <?php
                    $stmntSelectNotis = $pdo->prepare("SELECT * FROM song_reaches_milestone INNER JOIN files f on fk_song_id = f.pk_files_id INNER JOIN milestones m on fk_milestone_id = m.pk_milestone_id WHERE f.fk_user_id = ?");
                    $stmntSelectNotis->bindParam(1, $_SESSION['userID']);
                    $stmntSelectNotis->execute();

                    foreach ($stmntSelectNotis->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        echo "<li>You reached <b>" . $row['text'] . "</b> on your Song <br><mark>" . $row['Title'] . "</mark></li>";
                    }
                    ?>
                </ul>
                <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen". -->
                <button type="button" class="cancelButton" onclick="closeNotisForm()">Close</button>
            </div>
        </form>
    </div>
</div>