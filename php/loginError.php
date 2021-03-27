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
if (isset($_SESSION['loginError'])) {
    //echo $_SESSION['loginError'];
    switch ($_SESSION['loginError']) {
        case '-1':  // -1 -> no such user
        case '-4':  // -4 -> wrong password
            //$posErrWarning = 'login-input'; -------------------------------mark field(s) which are written here red -> idk if its possible
            $errValues = ['login-input' => $_SESSION['errGet']['input']];
            $errMsg = 'Wrong login Information! <br> Username/Email or Password is wrong';
            break;
            
        case '-2':  // -2 -> input is taken as email AND username (should be impossible)
        case '-3':  // -3 -> something else went wrong
            //$posErrWarning = 'login-input';
            $errValues = ['login-input' => $_SESSION['errGet']['input']];
            $errMsg = 'Something went wrong! Please try again. <br> If this happenes again, pleas contact us.';
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
