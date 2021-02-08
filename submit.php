<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";



$papname = $papabustruct = $pappublisher = $uplodedfile = "";
$papname_err = $papabustruct_err = $pappublisher_err = $uplodedfile_err =  "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //validate papername
    if(empty(trim($_POST["papname"]))){
        $papname_err = "Please enter a paper title.";
    } else{
        //select statement
        $sql = "SELECT papname FROM pap_view";        
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the select statement as parameters 
            mysqli_stmt_bind_param($stmt, "s", $param_papname);
            
            // Set parameters
            $param_papname = trim($_POST["papname"]);
            
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                }else{
                    echo "Something went wrong. Please try again later.";
                }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    //validate papabustruct
    if(empty(trim($_POST["papabustruct"]))){
        $papabustruct_err = "Please enter a paper abustruct.";
    } else{
        //select statement
        $sql = "SELECT papabustruct FROM pap_view";        
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the select statement as parameters 
            mysqli_stmt_bind_param($stmt, "s", $param_papabustruct);
            
            // Set parameters
            $param_papabustruct = trim($_POST["papabustruct"]);
            
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                }else{
                    echo "Something went wrong. Please try again later.";
                }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    //validate pappublisher
    if(empty(trim($_POST["pappublisher"]))){
        $pappublisher_err = "Please enter a paper author.";
    } else{
        //select statement
        $sql = "SELECT pappublisher FROM pap_view";        
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the select statement as parameters 
            mysqli_stmt_bind_param($stmt, "s", $param_pappublisher);
            
            // Set parameters
            $param_pappublisher = trim($_POST["pappublisher"]);
            
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                }else{
                    echo "Something went wrong. Please try again later.";
                }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    /*//validate uploadeed file
    if(empty(trim($_POST["uplodedfile"]))){
        $uplodedfile_err = "Please uplode a file.";
    } else{
        //select statement
        $sql = "SELECT uplodedfile FROM pap_view WHERE uplodedfile =?";        
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the select statement as parameters 
            mysqli_stmt_bind_param($stmt, "s", $param_uplodedfile);
            
            // Set parameters
            $param_uplodedfile = trim($_POST["uplodedfile"]);
            
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result 
                mysqli_stmt_store_result($stmt);
                
                }else{
                    echo "Something went wrong. Please try again later.";
                }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }*/
    // Check input errors before inserting in database
    if(empty($papname_err) && empty($papabustruct_err) && empty($pappublisher_err) && empty($uplodedfile_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO pap_view (papname , papabustruct , pappublisher , uplodedfile) VALUES ('$papname' , '$papabustruct' , '$pappublisher' , '$uplodedfile')";
       /* $sql = "call insert_paper('$papname' , '$papabustruct' , '$pappublisher' , '$uplodedfile')";
         */
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the insert statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_papname , $papabustruct , $pappublisher , $uplodedfile);
            
            // Set parameters
            $param_papname = $papname;
            $param_papabustruct = $papabustruct;
            $param_pappublisher = $pappublisher;
            $param_uplodedfile = $uplodedfile;
            
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: post-submit.php");
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





<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/style.css">
    <title>journal article</title>
  </head>
	
  <body>
	  <nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">Journal Article</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="submit.html">Submit article</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="mypaper.php">My paper</a>
					</li>
				</ul>
				<form class="form-inline my-2 my-lg-0">
                <a href="logout.php" class="btn btn-secondary my-2 my-sm-0" role="button" aria-pressed="true">log out</a>
    		  </form>	
			 </div>
		 </nav>
	  <div class="container">
		  <h1 style="border-bottom: 2px solid gray; margin-top: 5px">New submission</h1>
		  <h5>Start a new article-reviewed submission below.</h5>
		  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group">
				  <div class="ol-form">
					  <h3>Check policies and scope</h3>
					  <a href="reviewed-journal.html">Peer-reviewed article author guidelines</a><br>
					  <h6>Use one of our manuscript templates (or copy its structure) to speed up review time substantially.</h6>
					  <a href="doc/doc.docx" download rel="noopener noreferrer" target="_blank">Download File</a>
				  </div>
				  <h6 style="text-align: center;"><strong>You are about to create a article-reviewed in the journal.</strong></h6><br>
					  <div class="form-group <?php echo (!empty($papname_err)) ? 'has-error' : ''; ?>">
						<label for="articleTitle">Title</label>
						<input type="text" class="form-control" name="papname" value="<?php echo $papname; ?>" placeholder="Title" maxlength="250">
						 <small>250 characters remaining</small>
                          <span class="help-block"><?php echo $papname_err; ?></span>
					  </div>
					  <div class="form-group <?php echo (!empty($papabustruct_err)) ? 'has-error' : ''; ?>">
						<label for="articleAbustract">Abstract</label>
						<input type="text" class="form-control" name="papabustruct" value="<?php echo $papabustruct; ?>" id="articleAbustract" placeholder="Abustract" maxlength="3000">
						 <small>3000 characters remaining</small>
                         <span class="help-block"><?php echo $papabustruct_err; ?></span> 
					  </div>
					  <div class="form-group <?php echo (!empty($pappublisher_err)) ? 'has-error' : ''; ?>">
						<label for="articleAuthor">Author</label>
						<input type="text" class="form-control" name="pappublisher" value="<?php echo $pappublisher; ?>" id="articleAuthor" placeholder="Author" maxlength="50">
                        <span class="help-block"><?php echo $pappublisher_err; ?></span>
					  </div>
					  <div class="form-group <?php echo (!empty($uplodedfile_err)) ? 'has-error' : ''; ?>">
						<label for="fileUplode">Uplode File</label>
						<input type="file" class="form-control-file" value="<?php echo $uplodedfile; ?>" id="fileUplode">
					  </div>
            <input class="btn btn-primary" type="submit" value="submit">
		  </form>
	  </div>
  </body>
</html>