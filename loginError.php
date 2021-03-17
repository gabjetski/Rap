<script type="text/javascript">
function errorFun(form ,val, msg){
    console.log('test');
    let oldCode = document.getElementById(form).outerHTML;
    let newCode = '<p class="error">'+msg+'</p>'+oldCode;
    document.getElementById(form).outerHTML = newCode;
    for(let k in val) {
        document.getElementById(k).value = val[k];
        console.log(k + val[k]);
    }
    console.log(val);
    console.log(newCode);
    console.log(oldCode);
}</script>
<?php 
if (isset($_SESSION['loginError'])) {
    echo $_SESSION['loginError'];
    switch ($_SESSION['loginError']) {
        case '-1':
        //case '-4':
            //$posErrWarning = ['login-input', 'login-psw'];
            $posErrWarning = 'login-input';
            $errValues = ['login-input' => $_SESSION['errGet']['input']];
            $errMsg = 'Wrong login Information! Username/Email or Password is wrong';
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
    
    login.style.display = "block";
    register.style.display = "none";
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
