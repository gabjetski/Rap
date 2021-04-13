<?php
    $hotels = array(
        'hotel1' => 'Wynn',
        'hotel2' => 'Trump International Hotel',
        'hotel3' => 'The Venetian',
    );

    function readTemplateFile(string $path) : string{
        //echo $path;
        $handle = fopen($path, "r+");
        $contents = fread($handle, filesize($path));
        fclose($handle);
        //var_dump($contents);
        return $contents;
    };

    $cont = readTemplateFile('../../WEBT/ViewaLasVegas_Quenteam2.0/index.html');
    foreach($hotels as $key => $hotel){
        echo "<br>";
        echo $hotel;
        echo "<br>";
        $pos = strpos($key, $cont);
        if ($pos === false) {
            echo "Der String '$key' wurde nicht im String  gefunden";
        } else {
            echo "Der String '$key' wurde im String  gefunden";
            echo " und befindet sich an Position $pos";
        }
        echo str_replace($key, $hotel, $cont);
        echo "<hr>";
    };
    echo "<hr>";
    echo $cont;