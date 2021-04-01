<!-- only implemented if Login/Register throws error -->
<script type="text/javascript">
    //-------function for displaying errors --------------------------------
    function errorFun(form ,val, msg){
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
    switch ($_SESSION['uploadError']['id']) {
        case '-1':  // -1 -> BPM is out of range or not valid
            //$posErrWarning = 'register-psw'; -------------------------------mark field(s) which are written here red -> idk if its possible
            $type = $_SESSION['uploadError']['post']['f4pUpload-type'];
            $tags = $_SESSION['uploadError']['post']['f4pUpload-tags'];
            $errValues = [  'f4pUpload-bpm' => $_SESSION['uploadError']['post']['f4pUpload-bpm'],
                            'f4pUpload-key' => $_SESSION['uploadError']['post']['f4pUpload-key'],
                            'f4pUpload-title' => $_SESSION['uploadError']['post']['f4pUpload-title'],
                            'f4pUpload-notes' => $_SESSION['uploadError']['post']['f4pUpload-notes']];
            $errMsg = 'Please enter valid BPM';
            //FIXME write what range of bpm is valid
            break;
        case '-2':  // -2 -> title non valid
            $type = $_SESSION['uploadError']['post']['f4pUpload-type'];
            $tags = $_SESSION['uploadError']['post']['f4pUpload-tags'];
            $errValues = [  'f4pUpload-bpm' => $_SESSION['uploadError']['post']['f4pUpload-bpm'],
                            'f4pUpload-key' => $_SESSION['uploadError']['post']['f4pUpload-key'],
                            'f4pUpload-title' => $_SESSION['uploadError']['post']['f4pUpload-title'],
                            'f4pUpload-notes' => $_SESSION['uploadError']['post']['f4pUpload-notes']];
            $errMsg = 'Please enter a valid title';
            break;
        case '-3':  // -3 -> description non valid
            $type = $_SESSION['uploadError']['post']['f4pUpload-type'];
            $tags = $_SESSION['uploadError']['post']['f4pUpload-tags'];
            $errValues = [  'f4pUpload-bpm' => $_SESSION['uploadError']['post']['f4pUpload-bpm'],
                            'f4pUpload-key' => $_SESSION['uploadError']['post']['f4pUpload-key'],
                            'f4pUpload-title' => $_SESSION['uploadError']['post']['f4pUpload-title'],
                            'f4pUpload-notes' => $_SESSION['uploadError']['post']['f4pUpload-notes']];
            $errMsg = 'Please enter a valid description';
            break;
        case '-4':  // -4 -> filename non valid
            $type = $_SESSION['uploadError']['post']['f4pUpload-type'];
            $tags = $_SESSION['uploadError']['post']['f4pUpload-tags'];
            $errValues = [  'f4pUpload-bpm' => $_SESSION['uploadError']['post']['f4pUpload-bpm'],
                            'f4pUpload-key' => $_SESSION['uploadError']['post']['f4pUpload-key'],
                            'f4pUpload-title' => $_SESSION['uploadError']['post']['f4pUpload-title'],
                            'f4pUpload-notes' => $_SESSION['uploadError']['post']['f4pUpload-notes']];
            $errMsg = 'Please enter a valid filename';
            break;
        case '-5':  // -5 -> error with uploadtype
            $type = $_SESSION['uploadError']['post']['f4pUpload-type'];
            $tags = $_SESSION['uploadError']['post']['f4pUpload-tags'];
            $errValues = [  'f4pUpload-bpm' => $_SESSION['uploadError']['post']['f4pUpload-bpm'],
                            'f4pUpload-key' => $_SESSION['uploadError']['post']['f4pUpload-key'],
                            'f4pUpload-title' => $_SESSION['uploadError']['post']['f4pUpload-title'],
                            'f4pUpload-notes' => $_SESSION['uploadError']['post']['f4pUpload-notes']];
            $errMsg = 'Please enter a valid title';
            break;
        case '-6':  // -6 -> error with monettype
            $type = $_SESSION['uploadError']['post']['f4pUpload-type'];
            $tags = $_SESSION['uploadError']['post']['f4pUpload-tags'];
            $errValues = [  'f4pUpload-bpm' => $_SESSION['uploadError']['post']['f4pUpload-bpm'],
                            'f4pUpload-key' => $_SESSION['uploadError']['post']['f4pUpload-key'],
                            'f4pUpload-title' => $_SESSION['uploadError']['post']['f4pUpload-title'],
                            'f4pUpload-notes' => $_SESSION['uploadError']['post']['f4pUpload-notes']];
            $errMsg = 'Please enter a valid title';
            break;
        case '-7':  // -7 -> error with key
            $type = $_SESSION['uploadError']['post']['f4pUpload-type'];
            $tags = $_SESSION['uploadError']['post']['f4pUpload-tags'];
            $errValues = [  'f4pUpload-bpm' => $_SESSION['uploadError']['post']['f4pUpload-bpm'],
                            'f4pUpload-key' => $_SESSION['uploadError']['post']['f4pUpload-key'],
                            'f4pUpload-title' => $_SESSION['uploadError']['post']['f4pUpload-title'],
                            'f4pUpload-notes' => $_SESSION['uploadError']['post']['f4pUpload-notes']];
            $errMsg = 'Please enter a valid title';
            break;
    
        default:
            //$posErrWarning = '';
            $errMsg = '';
            break;
    }
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
        errorFun('loginButton', <?php echo 'values, "'.$errMsg.'"';?>);
        //errorFun('loginButton', <?php // echo 'values, "'.$errMsg.'", "'.$posErrWarning.'"';?>); --- only if fields are highlighted 
        
        //show login-popup
        login.style.display = "block";
        register.style.display = "none";
    };
</script>
<?php
//-------select which error if login --------------------------------
} elseif ($_SESSION['uploadError']['type'] == 'tagged'){
    //echo $_SESSION['registerError'];
    switch ($_SESSION['registerError']) {
        case '-1':  // -1 -> Username is taken
            //$posErrWarning = 'register-psw'; -------------------------------mark field(s) which are written here red -> idk if its possible
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'This username is already taken!';
            break;
            
        case '-2':  // -2 -> email is taken
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'This email is already taken!';
            break;
        case '-3':  // -3 -> email is not valid
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Please enter an valid email address!';
            break;
        case '-4':  // -4 -> username is an email address
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Username mustn\'t be a email-adress!';
            break;
        case '-5':  // -5 -> first name is not valid
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Please use a real first name!';
            break;
        case '-6':  // -6 -> last name is not valid
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Please use a real last name!';
            break;
        case '-7':  // -7 -> Username isnt valid
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Please make sure that your username is between 3 and 20 characters long and contains only letters, numbers and _ . or -';
            break;
        case '-8':  // -8 -> passwords dont match
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Passwords dont match!';
            break;
        case '-10': // -10 -> password doesnt have required characters
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Your Password must be 7 to 30 characters long and contain at least one uppercase, one lowercase and one number!';
            break;
    
        default:
            //$posErrWarning = '';
            $errMsg = '';
            break;
    }
?>
<script type="text/javascript">
    //function triggered onload
    window.onload =function(){
        //store values from php array into js array
        let values = [];
        <?php
            foreach ($errValues as $key => $value)
                echo "values['".$key."'] = '".$value."';";
            ?>
        //call error function
        errorFun('registerButton', <?php echo 'values, "'.$errMsg.'"';?>);
        
        //show register popup
        login.style.display = "none";
        register.style.display = "block";
    };
</script>
<?php
}
?>
