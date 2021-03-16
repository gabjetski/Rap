<?php 
if (isset($_SESSION['loginError'])) {
    echo $_SESSION['loginError'];
    switch ($_SESSION['loginError']) {
        case '-1':
        //case '-4':
            $posErrWarning = ['login-input', 'login-psw'];
            $errMsg = 'Username or Email not taken';
            break;
    
        default:
            $posErrWarning = '';
            $errMsg = '';
            break;
    }
?>
<script type="text/javascript">
window.onload =function(){
    
    login.style.display = "block";
    register.style.display = "none";
        <?php
        foreach ($posErrWarning as $value)
            echo "console.log('".$value."');";
            echo "document.getElementById('".$value."').setCustomValidity('".$errMsg."');";
        ?>
};
</script>
<?php
}
?>