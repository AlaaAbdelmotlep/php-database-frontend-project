<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$pubemail = $pubpassword = "" ;
$pubemail_err = $pubpassword_err = "" ;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["pubemail"]))){
        $pubemail_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT pubid FROM publisher WHERE pubemail = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_pubemail);
            
            // Set parameters
            $param_pubemail = trim($_POST["pubemail"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $pubemail_err = "This email is already taken.";
                } else{
                    $pubemail = trim($_POST["pubemail"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["pubpassword"]))){
        $pubpassword_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["pubpassword"])) < 6){
        $pubpassword_err = "Password must have atleast 6 characters.";
    } else{
        $pubpassword = trim($_POST["pubpassword"]);
    }
    
    // Check input errors before inserting in database
    if(empty($pubemail_err) && empty($pubpassword_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO publisher (pubemail, pubpassword) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_pubemail, $param_pubpassword);
            
            // Set parameters
            $param_pubemail = $pubemail;
            $param_pubpassword = password_hash($pubpassword, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Protofile Project</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width , intial-scale=0.1">
	
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/style.css">
	
</head>
<body>
		<div class="login-form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2  class="text-center">Sign Up</h2>
                <div class="form-group">
                    <div class="form-group <?php echo (!empty($pubemail_err)) ? 'has-error' : ''; ?>">
				        <input type="text" name="pubemail" class="form-control" value="<?php echo $pubemail_err; ?>" placeholder="Enter Email" required="required">
                        <!--to view the error-->
                        <span class="help-block"><?php echo $pubemail_err; ?></span>
			     </div>
                    <div class="form-group">
				        <input type="password" name="pubpassword" value="<?php echo $pubpassword_err; ?>" class="form-control" placeholder="Enter Password"  required="required">
                        <span class="help-block"><?php echo $pubpassword_err; ?></span>
			         </div>
                    <div class="form-group">
				        <button type="submit" class="btn btn-primary btn-block">Singup</button>
			         </div>
                </div>
            </form>
        </div>
</body>
</html>
