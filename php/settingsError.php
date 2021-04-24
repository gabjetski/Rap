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
    
    // Errors for Email
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

    if (isset($_SESSION['passwordChange-Error'])) {
    $errValues = ['change-password' => $_SESSION['passwordChange-Error']['value']];
        switch ($_SESSION['passwordChange-Error']['id']) {
            case '-1':  // -1 -> username is already used
                //$posErrWarning = 'login-input'; -------------------------------mark field(s) which are written here red -> idk if its possible
                $errMsg = 'Idk bruh';
                break;
            case '-2':  // -1 -> username is already used
                //$posErrWarning = 'login-input'; -------------------------------mark field(s) which are written here red -> idk if its possible
                $errMsg = 'Wrong Validations Idiot';
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
                errorFun('changePassword', <?php echo 'values, "'.$errMsg.'"';?>);
            };
        </script>
        <?php
    }

    // ANCHOR FirstName Errors
    if (isset($_SESSION['firstNameChange-Error'])) {
        $errValues = ['change-firstName' => $_SESSION['firstNameChange-Error']['value']];
            switch ($_SESSION['firstNameChange-Error']['id']) {
                case '-1':  // -1 -> First Name failed the validation
                    $errMsg = 'Your new First Name failed the validation';
                    break;
                case '-2':  // -2 -> New First Name is the current First Name
                    $errMsg = 'Please make sure to use a new First Name';
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
                    errorFun('changeFirstName', <?php echo 'values, "'.$errMsg.'"';?>);
                };
            </script>
            <?php
        }

        // ANCHOR LastName Errors 
        if (isset($_SESSION['lastNameChange-Error'])) {
            $errValues = ['change-lastName' => $_SESSION['lastNameChange-Error']['value']];
                switch ($_SESSION['lastNameChange-Error']['id']) {
                    case '-1':  // -1 -> Last Name failed the validation
                        $errMsg = 'Your new Last Name failed the validation';
                        break;
                    case '-2':  // -2 -> New First Name is the current First Name
                        $errMsg = 'Please make sure to use a new Last Name';
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
                        errorFun('changeLastName', <?php echo 'values, "'.$errMsg.'"';?>);
                    };
                </script>
                <?php
            }

            // ANCHOR Instagram Errors
            if (isset($_SESSION['instagramNameChange-Error'])) {
                $errValues = ['change-instagramName' => $_SESSION['instagramNameChange-Error']['value']];
                    switch ($_SESSION['instagramNameChange-Error']['id']) {
                        case '-1':  // -1 -> Last Name failed the validation
                            $errMsg = 'Instagram Username is not available';
                            break;
                        case '-2':  // -2 -> New First Name is the current First Name
                            $errMsg = 'Wrong Validation Bruh';
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
                            errorFun('changeInstagramName', <?php echo 'values, "'.$errMsg.'"';?>);
                        };
                    </script>
                    <?php
                }

                // ANCHOR Twitter Errors
            if (isset($_SESSION['twitterNameChange-Error'])) {
                $errValues = ['change-twitterName' => $_SESSION['twitterNameChange-Error']['value']];
                    switch ($_SESSION['twitterNameChange-Error']['id']) {
                        case '-1':  // -1 -> Last Name failed the validation
                            $errMsg = 'Twitter Username is not available';
                            break;
                        case '-2':  // -2 -> New First Name is the current First Name
                            $errMsg = 'Wrong Validation Bruh';
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
                            errorFun('changeTwitterName', <?php echo 'values, "'.$errMsg.'"';?>);
                        };
                    </script>
                    <?php
                }

                 // ANCHOR Soundcloud Errors
            if (isset($_SESSION['scNameChange-Error'])) {
                $errValues = ['change-scName' => $_SESSION['scNameChange-Error']['value']];
                    switch ($_SESSION['scNameChange-Error']['id']) {
                        case '-1':  // -1 -> Last Name failed the validation
                            $errMsg = 'Sc Username is not available';
                            break;
                        case '-2':  // -2 -> New First Name is the current First Name
                            $errMsg = 'Wrong Validation Bruh';
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
                            errorFun('changeScName', <?php echo 'values, "'.$errMsg.'"';?>);
                        };
                    </script>
                    <?php
                }
?>


