
<!--only implemented if Login/Register throws error -->
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
if (isset($_SESSION['loginError'])) {
    //echo $_SESSION['loginError']['id'];
    $errValues = ['login-input' => $_SESSION['loginError']['get']['input']];
    switch ($_SESSION['loginError']['id']) {
        case '-1':  // -1 -> no such user
        case '-4':  // -4 -> wrong password
            //$posErrWarning = 'login-input'; -------------------------------mark field(s) which are written here red -> idk if its possible
            $errMsg = 'Wrong login information! <br> Username/Email or Password is wrong';
            break;
        case '-2':  // -2 -> input is taken as email AND username (should be impossible)
        case '-3':  // -3 -> something else went wrong
            $errMsg = 'Something went wrong! Please try again. <br> If this happenes again, please contact us.';
            break;
        case '-11':  // -11 -> input empty
            //$errValues = ['login-input' => $_SESSION['loginError']['get']['input']];
            $errValues = [];
            $errMsg = 'Please enter your username or email address!';
            break;
        case '-12':  // -12 -> password empty
            $errMsg = 'Please enter your password!';
            break;
        default:
            $posErrWarning = '';
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
} elseif (isset($_SESSION['registerError'])) {
    //echo $_SESSION['registerError']['id'];
    $errValues = [  'register-firstName' => $_SESSION['registerError']['get']['firstName'],
                            'register-lastName' => $_SESSION['registerError']['get']['lastName'],
                            'register-username' => $_SESSION['registerError']['get']['username'],
                            'register-email' => $_SESSION['registerError']['get']['email']];
    switch ($_SESSION['registerError']['id']) {
        case '-1':  // -1 -> Username is taken
            //$posErrWarning = 'register-psw'; -------------------------------mark field(s) which are written here red -> idk if its possible
            $errMsg = 'This username is already taken!';
            break;
        case '-2':  // -2 -> email is taken
            $errMsg = 'This email is already taken!';
            break;
        case '-3':  // -3 -> email is not valid
            $errMsg = 'Please enter an valid email address!';
            break;
        case '-4':  // -4 -> username is an email address
            $errMsg = 'Username mustn\'t be a email-adress!';
            break;
        case '-5':  // -5 -> first name is not valid
            $errMsg = 'Please use a real first name!';
            break;
        case '-6':  // -6 -> last name is not valid
            $errMsg = 'Please use a real last name!';
            break;
        case '-7':  // -7 -> Username isnt valid
            $errMsg = 'Please make sure that your username is between 3 and 20 characters long and contains only letters, numbers and _ . or -';
            break;
        case '-8':  // -8 -> passwords dont match
            $errMsg = 'Passwords dont match!';
            break;
        case '-10': // -10 -> password doesnt have required characters
            $errMsg = 'Your Password must be 7 to 30 characters long and contain at least one uppercase, one lowercase and one number!';
            break;
        case '-11': // -11 -> first name empty
            $errMsg = 'Please enter your first name!';
            break;
        case '-12': // -12 -> last name empty
            $errMsg = 'Please enter your last name!';
            break;
        case '-13': // -13 -> username empty
            $errMsg = 'Please enter an username!';
            break;
        case '-14': // -14 -> email empty
            $errMsg = 'Please enter an email address!';
            break;
        case '-15': // -15 -> password empty
            $errMsg = 'Please enter a password!';
            break;
        case '-16': // -16 -> tos not selected
            $errMsg = 'Please select our Terms of Service & Privacy Policy!';
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
