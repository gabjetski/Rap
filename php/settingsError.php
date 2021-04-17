<!--only implemented if Login/Register throws error -->
<script type="text/javascript">
    //-------function for displaying errors --------------------------------
    function errorFun(form, val, msg){
        let oldCode = document.getElementById(form).outerHTML;
        let newCode = '<p class="error">'+msg+'</p>'+oldCode;
        document.getElementById(form).outerHTML = newCode;
        for(let k in val) {
            console.log(val);
            console.log(k);
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
                $errMsg = 'Username already in use';
                break;
            case '-2':  // -2 -> validation, make sure to use just, ... shit like that
                $errMsg = 'Validation failed, please match the requested format';
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
    
    if (isset($_SESSION['emailChange-Error'])) {
        //echo $_SESSION['loginError']['id'];
    $errValues = ['change-email' => $_SESSION['emailChange-Error']['value']];
        switch ($_SESSION['emailChange-Error']['id']) {
            case '-1':  // -1 -> username is already used
                //$posErrWarning = 'login-input'; -------------------------------mark field(s) which are written here red -> idk if its possible
                $errMsg = 'Email already in use';
                break;
            case '-2':  // -2 -> validation, make sure to use just, ... shit like that
                $errMsg = 'Please use a real email';
                break;
            default:
                $errMsg = 'Success!';
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
                errorFun('changeEmail', <?php echo 'values, "'.$errMsg.'"';?>);
            };
        </script>
        <?php
    }
?>


