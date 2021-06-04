<?php
class Notification
{
    public $data;
    public $notificationList;

    public function __construct($userid)
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
        $stmntSelectNotis = $this->pdo->prepare("SELECT * FROM song_reaches_milestone INNER JOIN files f on fk_song_id = f.pk_files_id INNER JOIN milestones m on fk_milestone_id = m.pk_milestone_id WHERE f.fk_user_id = ?");
        $stmntSelectNotis->bindParam(1, $userid);
        $stmntSelectNotis->execute();
        $this->data = [
            "userID" => $userid
        ];

        $i = 0;
        foreach ($stmntSelectNotis->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $this->notificationList[$i] = [
                "nText" => $row['text'],
                "nMilestoneNumber" => $row['required_downloads'],
                "nMilestoneId" => $row['pk_milestone_id'],
                "nNotiId" => $row['pk_song_milestone_id'],
                "sTitle" => $row['Title'],
                "sId" => $row['pk_files_id'],
            ];
            $i++;
        }
    }

    public function getPopup()
    {
        $returntxt = <<< returnText
        <div id="notisForm">
        <div class="blocker" onclick="closeNotisForm()"></div>
        <div class="form-popup notisFormular">
            <h1>Bitte Notifications </h1>
            <div>
                <label><b> Notifications: </b></label>
                <ul>
returnText;
        if ($this->notificationList) {

            foreach ($this->notificationList as $row) {
                $returntxt .= "<li>You reached <b>" . $row['nText'] . "</b> on your Song <br><mark>" . $row['sTitle'] . "</mark>{$row['nNotiId']}";
                $returntxt .= <<< returnText
            <form action="{$_SERVER['PHP_SELF']}" method="get">
                        <input type="hidden" name="nId" value="{$row['nNotiId']}">
                        <input type="submit" name="deleteN" value="X">
                    </form></li>
            returnText;
            }
        }

        $returntxt .= <<< returnText
                        </ul>
                        <button type="button" class="cancelButton" onclick="closeNotisForm()">Close</button>
                    </div>
            </div>
        </div>
        returnText;

        return $returntxt;
    }
    public function getCount()
    {
        if ($this->notificationList) {
            return count($this->notificationList);
        } else {
            return 0;
        }
    }
}
