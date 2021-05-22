<?php
    $fp = @fopen('/../blacklist.txt', 'r');
    if ($fp) {
      $blacklist = explode("\n", fread($fp, filesize('/../blacklist.txt')));
    }else{
      $blacklist = [];
    }

    //print_r($blacklist);

  ?>

  <script type="text/javascript">
    
    // Funktion, um DAWEIL NUR BEIM TITLE Wörter aus der Blacklist zu "blockieren"
    // TODO bei allen anderen (Notes, Tags) die Blacklist auch miteinbeziehen
    function checkBanWords() {
        // Alle Wörter in Lowercase, damit wir nicht auf Case aufpassen müssen
        // TODO Blacklist erweitern
        let bannedWords = [
        <?php
        foreach ($blacklist as $key=>$value) {
          
          echo "'".preg_replace( "/\r|\n/", "", $value )."'";
          if ($key != sizeOf($blacklist)-1) {
            echo ", ";
          }
        }
         ?>];
        //let bannedWords = <?php //echo json_encode($blacklist); ?>;
        let title = document.getElementById('f4pUpload-title');
  
        
        // Input vom Title wird in Lowercase umgewandelt, um alle Cases zu überprüfen, Spaces werden
        let titleValue = document.getElementById('f4pUpload-title').value.replace(/\s+/g, '').toLowerCase();
        for(let i=0; i<bannedWords.length; i++) {
        // ~ ist eine Local Negation, so wird nur das Wort angezeigt was wirklich falsch ist
        // bei faggot würden dann alle anderen Wörter auch in der Console auftauchen, ~ verhindert es
          if (~titleValue.indexOf(bannedWords[i])){
            // Validation für den Titel 
            title.setCustomValidity('Please us an appropriate title');
          }
        }
    }
  </script>