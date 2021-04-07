<!-- only implemented if Login/Register throws error -->
<script type="text/javascript">
    //-------function for displaying errors --------------------------------
    function errorFun(form ,val, msg, typ, tags){
        let oldCode = document.getElementById(form).outerHTML;
        let newCode = '<p class="error">'+msg+'</p>'+oldCode;
        document.getElementById(form).outerHTML = newCode;
        for(let k in val) {
            document.getElementById(k).value = val[k];
        }
    }
</script>
<?php 
//-------select which error if login --------------------------------
if ($_SESSION['uploadError']['type'] == 'f4p') {
    if (isset($_SESSION['uploadError']['post']['f4pUpload-type'])) {
        $type = $_SESSION['uploadError']['post']['f4pUpload-type'];
    }else{
        $type = '';
    }

    if (!isset($_SESSION['uploadError']['post']['f4pUpload-key'])) {
        $_SESSION['uploadError']['post']['f4pUpload-key'] = 0;
        
    }

    $tags = $_SESSION['uploadError']['post']['f4pUpload-tags'];
    $errValues = [  'f4pUpload-bpm' => $_SESSION['uploadError']['post']['f4pUpload-bpm'],
                    'f4pUpload-key' => $_SESSION['uploadError']['post']['f4pUpload-key'],
                    'f4pUpload-title' => $_SESSION['uploadError']['post']['f4pUpload-title'],
                    'f4pUpload-notes' => $_SESSION['uploadError']['post']['f4pUpload-desc']];
    switch ($_SESSION['uploadError']['id']) {
        case '-1':  // -1 -> BPM is out of range or not valid
            //$posErrWarning = 'register-psw'; -------------------------------mark field(s) which are written here red -> idk if its possible
            $errMsg = 'Please enter valid BPM';
            //FIXME write what range of bpm is valid
            break;
        case '-2':  // -2 -> title non valid
            $errMsg = 'Please enter a valid title';
            break;
        case '-3':  // -3 -> description non valid
            $errMsg = 'Please enter a valid description';
            break;
        case '-4':  // -4 -> filename non valid
            $errMsg = 'Please enter a valid filename';
            break;
        case '-5':  // -5 -> error with uploadtype
            $errMsg = 'Please select if your Upload is a Beat or a Sample';
            break;
        case '-6':  // -6 -> error with monettype
            $errMsg = 'Something went wrong! Please try again. <br> If this happenes again, pleas contact us.<br> #1006';
            break;
        case '-7':  // -7 -> error with key
            $errMsg = 'Something went wrong! Please try again. <br> If this happenes again, pleas contact us. <br> #1007';
            break;
        case '-10':  // -10 -> file is empty
            $errMsg = 'Please select a file!';
            break;
        case '-11':  // -11 -> file is no mp3
            $errMsg = 'Please select a mp3 file!';
            //var_dump($_FILES['f4pUpload-file']['size']);
            break;
        case '-12':  // -12 -> file to big
            $errMsg = 'We are sorry, your file must not be above 100MB!';
            break;
        case '-13':  // -13 -> bpm not set
            $errMsg = 'Please enter the bpm of the track!';
            break;
    
        default:
            //$posErrWarning = '';
            $errMsg = '';
            break;
    }
    //unset($_SESSION['uploadError']);
?>
<script type="text/javascript">
    //funtion triggered onload
    window.onload = function(){
        //store values from php array into js array
        let values = [];
        <?php
            foreach ($errValues as $key => $value)
                echo "values['".$key."'] = '".$value."';";
            ?>

        //call error function
        errorFun('f4pUpload-submit', <?php echo 'values, "'.$errMsg.'", "'.$type.'", "'.$tags.'"';?>);
        //errorFun('loginButton', <?php // echo 'values, "'.$errMsg.'", "'.$posErrWarning.'"';?>); --- only if fields are highlighted 
        
        //show login-popup
        f4p.style.display = "block";
        tag.style.display = "none";
    };
</script>
<?php
//-------select which error if login --------------------------------
} elseif ($_SESSION['uploadError']['type'] == 'tagged'){
    //echo $_SESSION['registerError'];
    switch ($_SESSION['registerError']) {
        case '-1':  // -1 -> BPM is out of range or not valid
            //$posErrWarning = 'register-psw'; -------------------------------mark field(s) which are written here red -> idk if its possible
            $type = $_SESSION['uploadError']['post']['taggedUpload-type'];
            $tags = $_SESSION['uploadError']['post']['taggedUpload-tags'];
            $errValues = [  'taggedUpload-bpm' => $_SESSION['uploadError']['post']['taggedUpload-bpm'],
                            'taggedUpload-key' => $_SESSION['uploadError']['post']['taggedUpload-key'],
                            'taggedUpload-title' => $_SESSION['uploadError']['post']['taggedUpload-title'],
                            'taggedUpload-notes' => $_SESSION['uploadError']['post']['taggedUpload-notes']];
            $errMsg = 'Please enter valid BPM';
            //FIXME write what range of bpm is valid
            break;
        case '-2':  // -2 -> title non valid
            $type = $_SESSION['uploadError']['post']['taggedUpload-type'];
            $tags = $_SESSION['uploadError']['post']['taggedUpload-tags'];
            $errValues = [  'taggedUpload-bpm' => $_SESSION['uploadError']['post']['taggedUpload-bpm'],
                            'taggedUpload-key' => $_SESSION['uploadError']['post']['taggedUpload-key'],
                            'taggedUpload-title' => $_SESSION['uploadError']['post']['taggedUpload-title'],
                            'taggedUpload-notes' => $_SESSION['uploadError']['post']['taggedUpload-notes']];
            $errMsg = 'Please enter a valid title';
            break;
        case '-3':  // -3 -> description non valid
            $type = $_SESSION['uploadError']['post']['taggedUpload-type'];
            $tags = $_SESSION['uploadError']['post']['taggedUpload-tags'];
            $errValues = [  'taggedUpload-bpm' => $_SESSION['uploadError']['post']['taggedUpload-bpm'],
                            'taggedUpload-key' => $_SESSION['uploadError']['post']['taggedUpload-key'],
                            'taggedUpload-title' => $_SESSION['uploadError']['post']['taggedUpload-title'],
                            'taggedUpload-notes' => $_SESSION['uploadError']['post']['taggedUpload-notes']];
            $errMsg = 'Please enter a valid description';
            break;
        case '-4':  // -4 -> filename non valid
            $type = $_SESSION['uploadError']['post']['taggedUpload-type'];
            $tags = $_SESSION['uploadError']['post']['taggedUpload-tags'];
            $errValues = [  'taggedUpload-bpm' => $_SESSION['uploadError']['post']['taggedUpload-bpm'],
                            'taggedUpload-key' => $_SESSION['uploadError']['post']['taggedUpload-key'],
                            'taggedUpload-title' => $_SESSION['uploadError']['post']['taggedUpload-title'],
                            'taggedUpload-notes' => $_SESSION['uploadError']['post']['taggedUpload-notes']];
            $errMsg = 'Please enter a valid filename';
            break;
        case '-5':  // -5 -> error with uploadtype
            $type = $_SESSION['uploadError']['post']['taggedUpload-type'];
            $tags = $_SESSION['uploadError']['post']['taggedUpload-tags'];
            $errValues = [  'taggedUpload-bpm' => $_SESSION['uploadError']['post']['taggedUpload-bpm'],
                            'taggedUpload-key' => $_SESSION['uploadError']['post']['taggedUpload-key'],
                            'taggedUpload-title' => $_SESSION['uploadError']['post']['taggedUpload-title'],
                            'taggedUpload-notes' => $_SESSION['uploadError']['post']['taggedUpload-notes']];
            $errMsg = 'Something went wrong! Please try again. <br> If this happenes again, pleas contact us.<br> #1005';
            break;
        case '-6':  // -6 -> error with monettype
            $type = $_SESSION['uploadError']['post']['taggedUpload-type'];
            $tags = $_SESSION['uploadError']['post']['taggedUpload-tags'];
            $errValues = [  'taggedUpload-bpm' => $_SESSION['uploadError']['post']['taggedUpload-bpm'],
                            'taggedUpload-key' => $_SESSION['uploadError']['post']['taggedUpload-key'],
                            'taggedUpload-title' => $_SESSION['uploadError']['post']['taggedUpload-title'],
                            'taggedUpload-notes' => $_SESSION['uploadError']['post']['taggedUpload-notes']];
            $errMsg = 'Something went wrong! Please try again. <br> If this happenes again, pleas contact us.<br> #1006';
            break;
        case '-7':  // -7 -> error with key
            $type = $_SESSION['uploadError']['post']['taggedUpload-type'];
            $tags = $_SESSION['uploadError']['post']['taggedUpload-tags'];
            $errValues = [  'taggedUpload-bpm' => $_SESSION['uploadError']['post']['taggedUpload-bpm'],
                            'taggedUpload-key' => $_SESSION['uploadError']['post']['taggedUpload-key'],
                            'taggedUpload-title' => $_SESSION['uploadError']['post']['taggedUpload-title'],
                            'taggedUpload-notes' => $_SESSION['uploadError']['post']['taggedUpload-notes']];
            $errMsg = 'Something went wrong! Please try again. <br> If this happenes again, pleas contact us. <br> #1007';
            break;
    
        default:
            //$posErrWarning = '';
            $errMsg = '';
            break;
    }
?>
<script type="text/javascript">
    //function triggered onload
    window.onload = function(){
        //store values from php array into js array
        let values = [];
        <?php
            foreach ($errValues as $key => $value)
                echo "values['".$key."'] = '".$value."';";
            ?>

        //call error function
        errorFun('taggedUpload-submit', <?php echo 'values, "'.$errMsg.'", "'.$type.'", "'.$tags.'"';?>);
        //errorFun('loginButton', <?php // echo 'values, "'.$errMsg.'", "'.$posErrWarning.'"';?>); --- only if fields are highlighted 
        
        //show login-popup
        tag.style.display = "block";
        f4p.style.display = "none";
    };
</script>
<?php
}
?>
