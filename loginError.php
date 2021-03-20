<script type="text/javascript">
//-------function for displaying errors --------------------------------
function errorFun(form ,val, msg){
    console.log('test');
    let oldCode = document.getElementById(form).outerHTML;
    let newCode = '<p class="error">'+msg+'</p>'+oldCode;
    document.getElementById(form).outerHTML = newCode;
    for(let k in val) {
        document.getElementById(k).value = val[k];
        console.log(k +' - ' + val[k]);
    }
    console.log(val);
    console.log(newCode);
    console.log(oldCode);
}</script>
<?php 
//-------select which error if login --------------------------------
if (isset($_SESSION['loginError'])) {
    echo $_SESSION['loginError'];
    switch ($_SESSION['loginError']) {
        case '-1':
        case '-4':
            //$posErrWarning = ['login-input', 'login-psw'];
            $posErrWarning = 'login-input';
            $errValues = ['login-input' => $_SESSION['errGet']['input']];
            $errMsg = 'Wrong login Information! <br> Username/Email or Password is wrong';
            break;
            
        case '-2':
        case '-3':
            //$posErrWarning = ['login-input', 'login-psw'];
            $posErrWarning = 'login-input';
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
    window.onload =function(){

        let values = [];
        <?php
            foreach ($errValues as $key => $value)
                echo "values['".$key."'] = '".$value."';";
            ?>

        errorFun('loginButton', <?php echo 'values, "'.$errMsg.'"';?>);
        //errorFun('loginButton', <?php echo 'values, "'.$errMsg.'", "'.$posErrWarning.'"';?>);
        
        login.style.display = "block";
        register.style.display = "none";
    };
</script>
<?php

//-------select which error if login --------------------------------
} elseif (isset($_SESSION['registerError'])) {
    echo $_SESSION['registerError'];
    switch ($_SESSION['registerError']) {
        case '-1':
            $posErrWarning = 'register-psw';
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'This username is already taken!';
            break;
            
        case '-2':
            $posErrWarning = 'register-psw';
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'This email is already taken!';
            break;
        case '-3':
            $posErrWarning = 'register-psw';
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Please enter an valid email address!';
            break;
        case '-4':
            $posErrWarning = 'register-psw';
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Username mustn\'t be a email-adress!';
            break;
        case '-5':
            $posErrWarning = 'register-psw';
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Please use a real first name!';
            break;
        case '-6':
            $posErrWarning = 'register-psw';
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Please use a real last name!';
            break;
        case '-7':
            $posErrWarning = 'register-psw';
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Please make sure that your username is between 3 and 20 characters long and contains only letters, numbers and _ . or -';
            break;
        case '-8':
            $posErrWarning = 'register-psw';
            $errValues = [  'register-firstName' => $_SESSION['errGet']['firstName'],
                            'register-lastName' => $_SESSION['errGet']['lastName'],
                            'register-username' => $_SESSION['errGet']['username'],
                            'register-email' => $_SESSION['errGet']['email']];
            $errMsg = 'Passwords doent match!';
            break;
    
        default:
            $posErrWarning = '';
            $errMsg = '';
            break;
    }
?>
<script type="text/javascript">
window.onload =function(){

    let values = [];
    <?php
        foreach ($errValues as $key => $value)
            echo "values['".$key."'] = '".$value."';";
        ?>

    errorFun('registerButton', <?php echo 'values, "'.$errMsg.'", "'.$posErrWarning.'"';?>);
    
    login.style.display = "none";
    register.style.display = "block";
        <?php
        /*foreach ($posErrWarning as $value)
            echo "console.log('".$value."');";
            echo "document.getElementById('".$value."').setCustomValidity('".$errMsg."');";*/
        ?>
};
</script>
<?php
}
?>
