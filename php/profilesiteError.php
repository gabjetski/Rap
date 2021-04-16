<!--only implemented if Login/Register throws error -->
<script type="text/javascript">
    //-------function for displaying errors --------------------------------
    function errorFun(form, val, msg){
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
if (isset($_SESSION['usernameChange-Error'])) {
    //echo $_SESSION['loginError']['id'];
    $errValues = ['change-username' => $_SESSION['usernameChange-Error']['value']];
    switch ($_SESSION['usernameChange-Error']['id']) {
        case '-1':  // -1 -> username is already used
            //$posErrWarning = 'login-input'; -------------------------------mark field(s) which are written here red -> idk if its possible
            $errMsg = 'Already Used';
            break;
        case '-2':  // -2 -> validation, make sure to use just, ... shit like that
            $errMsg = 'Wrong Validation';
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
        errorFun('changeUsername', <?php echo 'values, "'.$errMsg.'"';?>);
        //errorFun('loginButton', <?php // echo 'values, "'.$errMsg.'", "'.$posErrWarning.'"';?>); --- only if fields are highlighted 
        
    };
</script>
<?php
}