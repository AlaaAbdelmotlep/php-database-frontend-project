<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$pubemail = $pubpassword = "" ;
$pubemail_err = $pubpassword_err = "" ;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["pubemail"]))){
        $pubemail_err = "Please enter email.";
    } else{
        $pubemail = trim($_POST["pubemail"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["pubpassword"]))){
        $pubpassword_err = "Please enter your password.";
    } else{
        $pubpassword = trim($_POST["pubpassword"]);
    }
    
    // Validate credentials
    if(empty($pubemail_err) && empty($pubpassword_err)){
        // Prepare a select statement
        $sql = "SELECT pubid, pubemail, pubpassword FROM publisher WHERE pubemail = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_pubemail);
            
            // Set parameters
            $param_pubemail = $pubemail;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $pubid, $pubemail, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($pubpassword, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["pubid"] = $pubid;
                            $_SESSION["pubemail"] = $pubemail;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $pubpassword_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $pubemail_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
			<h2 class="text-center">Log in</h2>       
			<div class="form-group <?php echo (!empty($pubemail_err)) ? 'has-error' : ''; ?>">
				<input type="text" name="pubemail" class="form-control" value="<?php echo $pubemail; ?>" placeholder="Enter Email" required="required">
                <span class="help-block"><?php echo $pubemail_err; ?></span>
			</div>
			<div class="form-group <?php echo (!empty($pubpassword_err)) ? 'has-error' : ''; ?>">
				<input type="password" class="form-control" name="pubpassword" placeholder="Enter Password"  required="required">
                <span class="help-block"><?php echo $pubpassword_err; ?></span>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Log in</button>
			</div>       
		</form>
    	<p class="text-center"><a href="singup.php">Create an Account</a></p>
	</div>
</body>
</html>